<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\State;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\DFAPath;
use AdamWojs\EzPlatformOmniboxBundle\Service\CommandSuggestion;
use AdamWojs\EzPlatformOmniboxBundle\Service\Suggestion;

final class TranslateContentCommand implements CommandInterface
{
    public function buildDFA(State $dfa): void
    {
        // Translate to <target:language> (from <source:language>)?
        $dfa->addTextState('translate')
            ->addTextState('to')
            ->addParameter('target', 'language')
            ->addAcceptState();
    }

    public function buildSuggestion(DFAPath $path): Suggestion
    {
        return new CommandSuggestion(
            $path->join(),
            'javascript:alert("Translate content")'
        );
    }
}
