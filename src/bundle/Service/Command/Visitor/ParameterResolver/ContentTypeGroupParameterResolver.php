<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\ParameterResolver;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\ParameterState;
use eZ\Publish\API\Repository\ContentTypeService;

final class ContentTypeGroupParameterResolver implements ParameterResolver
{
    /** @var \eZ\Publish\API\Repository\ContentTypeService */
    private $contentTypeService;

    public function __construct(ContentTypeService $contentTypeService)
    {
        $this->contentTypeService = $contentTypeService;
    }

    public function resolve(ParameterState $node, string $prefix): iterable
    {
        foreach ($this->contentTypeService->loadContentTypeGroups() as $group) {
            $name = $group->getName();
            if (empty($name)) {
                $name = $group->identifier;
            }

            if ($prefix === '' || strpos(mb_strtolower($name), $prefix) === 0) {
                yield new ParameterValue($name, $group);
            }
        }
    }

    public function getType(): string
    {
        return 'content_type_group';
    }
}
