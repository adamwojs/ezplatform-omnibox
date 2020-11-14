<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\DFA;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\DFAPath;
use AdamWojs\EzPlatformOmniboxBundle\Service\CommandSuggestion;
use AdamWojs\EzPlatformOmniboxBundle\Service\Suggestion;

final class CreateContentCommand implements CommandInterface
{
    public function buildSuggestion(DFAPath $path): Suggestion
    {
        return new CommandSuggestion(
            $path->join(),
            'javascript:alert("Create content")'
        );
    }

    public function buildDFA(DFA $dfa): void
    {
        // Create content <ContentType>
        $dfa
            ->addTextState('create')
            ->addTextState('content')
            ->addParameter('content_type', 'content_type')
            ->addAcceptState(self::class);
    }
}
