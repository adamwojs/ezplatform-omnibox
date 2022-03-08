<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\DFA;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\DFAPath;
use AdamWojs\EzPlatformOmniboxBundle\Service\Suggestion;
use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;

interface CommandInterface
{
    public function getCommandName(): string;

    /**
     * Builds DFA for command.
     */
    public function buildDFA(DFA $dfa, SuggestionContext $context): void;

    /**
     * Builds suggestion from given DFAPath and context.
     */
    public function buildSuggestion(DFAPath $path, SuggestionContext $context): Suggestion;
}
