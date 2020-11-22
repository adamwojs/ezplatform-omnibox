<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\ContextBasedCommandInterface;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\State;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\DFA;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\CommandInterface;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Lexer\Lexer;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\DFAVisitorFactory;

final class CommandSuggestionProvider implements SuggestionProviderInterface
{
    /** @var DFAVisitorFactory */
    private $dfaVisitorFactory;

    /** @var CommandInterface[] */
    private $commands;

    /** @var DFA|null */
    private $dfa;

    public function __construct(DFAVisitorFactory $dfaVisitorFactory, iterable $commands)
    {
        $this->dfaVisitorFactory = $dfaVisitorFactory;

        $this->commands = [];
        foreach ($commands as $command) {
            $this->commands[get_class($command)] = $command;
        }
    }

    public function getSuggestions(SuggestionQuery $query): iterable
    {
        if ($this->dfa === null) {
            $this->dfa = $this->buildDFA($this->commands, $query->getContext());
        }

        $lexer = new Lexer();
        $lexer->tokenize($query->getQueryString()->toString());

        $visitor = $this->dfaVisitorFactory->createVisitor($lexer);

        $i = 0;
        foreach ($visitor->visitRootNode($this->dfa) as $path) {
            if ($i === $query->getLimit()) {
                break;
            }

            $command = $this->commands[$path->getAcceptState()->getLabel()];
            yield $command->buildSuggestion($path, $query->getContext());

            ++$i;
        }

        yield from [];
    }

    /**
     * @param CommandInterface[] $commands
     */
    private function buildDFA(iterable $commands, SuggestionContext $context): State
    {
        $root = new DFA();
        foreach ($commands as $command) {
            if ($this->supportsContext($command, $context)) {
                $command->buildDFA($root, $context);
            }
        }

        return $root;
    }

    private function supportsContext(CommandInterface $command, SuggestionContext $context): bool
    {
        if ($command instanceof ContextBasedCommandInterface) {
            return $command->supportsContext($context);
        }

        return true;
    }
}
