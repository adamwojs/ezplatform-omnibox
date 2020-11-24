<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\ParameterResolver;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\ParameterState;
use eZ\Publish\API\Repository\ObjectStateService;
use eZ\Publish\API\Repository\Values\ObjectState\ObjectStateGroup;

final class ObjectStateGroupParameterResolver implements ParameterResolver
{
    /** @var ObjectStateGroup */
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
