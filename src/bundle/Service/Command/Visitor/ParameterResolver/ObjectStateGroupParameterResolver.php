<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\ParameterResolver;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\ParameterState;
use Ibexa\Contracts\Core\Repository\ObjectStateService;

final class ObjectStateGroupParameterResolver implements ParameterResolver
{
    /** @var \Ibexa\Contracts\Core\Repository\Values\ObjectState\ObjectStateGroup */
    private $objectStateService;

    public function __construct(ObjectStateService $objectStateService)
    {
        $this->objectStateService = $objectStateService;
    }

    public function resolve(ParameterState $node, string $prefix): iterable
    {
        foreach ($this->objectStateService->loadObjectStateGroups() as $group) {
            $name = $group->getName();
            if (empty($name)) {
                $name = $group->identifier;
            }

            if ($prefix === '' || strpos(mb_strtolower($name), $prefix) === 0) {
                yield new ParameterValue($name, $group);
            }
        }

        yield from [];
    }

    public function getType(): string
    {
        return 'object_state_group';
    }
}
