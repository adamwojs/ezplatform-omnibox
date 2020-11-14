<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\ParameterResolver;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\ParameterState;

interface ParameterResolver
{
    public function resolve(ParameterState $node, string $prefix): iterable;

    public function getType(): string;
}
