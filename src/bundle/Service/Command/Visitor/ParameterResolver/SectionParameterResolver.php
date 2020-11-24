<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\ParameterResolver;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\ParameterState;
use eZ\Publish\API\Repository\SectionService;

final class SectionParameterResolver implements ParameterResolver
{
    /** @var \eZ\Publish\API\Repository\SectionService */
    private $sectionService;

    public function __construct(SectionService $sectionService)
    {
        $this->sectionService = $sectionService;
    }

    public function resolve(ParameterState $node, string $prefix): iterable
    {
        foreach ($this->sectionService->loadSections() as $section) {
            $name = $section->name;
            if (empty($name)) {
                $name = $section->identifier;
            }

            if ($prefix === '' || strpos(mb_strtolower($name), $prefix) === 0) {
                yield new ParameterValue($name, $section);
            }
        }
    }

    public function getType(): string
    {
        return 'section';
    }
}
