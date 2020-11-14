<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\Node;

final class CreateContentCommand implements CommandInterface
{
    public function buildDFA(Node $root): void
    {
        // Create content <ContentType>
        $root->addTextChild('create')->addTextChild('content')->addPlaceholder('content_type')->addEpsilon();
    }
}
