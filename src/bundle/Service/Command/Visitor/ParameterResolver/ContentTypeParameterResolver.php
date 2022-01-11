<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\ParameterResolver;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\ParameterState;
use Ibexa\Contracts\Core\Repository\ContentTypeService;

final class ContentTypeParameterResolver implements ParameterResolver
{
    /** @var \Ibexa\Contracts\Core\Repository\ContentTypeService */
    private $contentTypeService;

    public function __construct(ContentTypeService $contentTypeService)
    {
        $this->contentTypeService = $contentTypeService;
    }

    public function resolve(ParameterState $node, string $prefix): iterable
    {
        foreach ($this->contentTypeService->loadContentTypeGroups() as $group) {
            foreach ($this->contentTypeService->loadContentTypes($group) as $type) {
                if ($prefix === '' || strpos(mb_strtolower($type->getName()), $prefix) === 0) {
                    yield new ParameterValue(
                        $type->getName(),
                        $type
                    );
                }
            }
        }

        yield from [];
    }

    public function getType(): string
    {
        return 'content_type';
    }
}
