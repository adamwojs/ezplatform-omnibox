<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\AST\Node;

interface CommandInterface
{
    public function buildAST(Node $root): void;
}
