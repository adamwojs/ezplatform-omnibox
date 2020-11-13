<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\AST\Node;

final class CreateContentTypeCommand implements CommandInterface
{
    public function buildAST(Node $root): void
    {
        // Create content type <ContentType>
        $root->addTextChild('create')->addTextChild('content')->addTextChild('type')->addEpsilon();
    }
}
