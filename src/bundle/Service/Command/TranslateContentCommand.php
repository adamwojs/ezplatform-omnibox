<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\AST\Node;

final class TranslateContentCommand implements CommandInterface
{
    public function buildAST(Node $root): void
    {
        // Translate to <Language> (from <Language>)?
        $root->addTextChild('translate')->addPlaceholder('language')->addEpsilon();
    }
}
