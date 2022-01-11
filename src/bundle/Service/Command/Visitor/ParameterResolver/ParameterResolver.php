<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\ParameterResolver;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\ParameterState;

interface ParameterResolver
{
    public function resolve(ParameterState $node, string $prefix): iterable;

    public function getType(): string;
}
