<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\AST\Node;

final class CreateSectionCommand implements CommandInterface
{
    public function buildAST(Node $root): void
    {
        // Create section
        $root->addTextChild('create')->addTextChild('section')->addEpsilon();
    }
}
