<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\Node;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\RootNode;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\CommandInterface;

final class CommandSuggestionProvider implements SuggestionProviderInterface
{
    /** @var CommandInterface[] */
    private $commands;

    /** @var RootNode */
    private $dfa;

    public function __construct(iterable $commands)
    {
        $this->commands = $commands;
        $this->dfa = $this->buildDFA($commands);
    }

    public function getSuggestions(QueryString $query, int $limit = self::DEFAULT_SUGGESTIONS_LIMIT): iterable
    {
        return [];
    }

    /**
     * @param CommandInterface[] $commands
     */
    private function buildDFA(iterable $commands): Node
    {
        $root = new RootNode();
        foreach ($commands as $command) {
            $command->buildDFA($root);
        }

        return $root;
    }
}
