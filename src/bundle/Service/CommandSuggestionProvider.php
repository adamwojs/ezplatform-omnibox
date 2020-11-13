<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\AST\Node;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\AST\RootNode;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\CommandInterface;

final class CommandSuggestionProvider implements SuggestionProviderInterface
{
    /** @var CommandInterface[] */
    private $commands;

    /** @var RootNode */
    private $tree;

    public function __construct(iterable $commands)
    {
        $this->commands = $commands;
        $this->tree = $this->buildAST($commands);
    }

    public function getSuggestions(QueryString $query, int $limit = self::DEFAULT_SUGGESTIONS_LIMIT): iterable
    {
        return [];
    }

    /**
     * @param CommandInterface[] $commands
     */
    private function buildAST(iterable $commands): Node
    {
        $root = new RootNode();
        foreach ($commands as $command) {
            $command->buildAST($root);
        }

        return $root;
    }
}
