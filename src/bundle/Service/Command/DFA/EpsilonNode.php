<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA;

final class EpsilonNode extends Node
{
    public function __construct(?Node $parent = null)
    {
        parent::__construct($parent);
    }
}
