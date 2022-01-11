<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service;

use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ContentSuggestionProvider implements SuggestionProviderInterface
{
    /** @var \Ibexa\Contracts\Core\Repository\SearchService */
    private $searchService;

    /** @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface */
    private $urlGenerator;

    public function __construct(SearchService $searchService, UrlGeneratorInterface $urlGenerator)
    {
        $this->searchService = $searchService;
        $this->urlGenerator = $urlGenerator;
    }

    public function getSuggestions(SuggestionQuery $suggestionQuery): iterable
    {
        $queryString = $suggestionQuery->getQueryString();

        $query = new Query();
        $query->limit = $suggestionQuery->getLimit();
        $query->filter = new Criterion\FullText($queryString->toString() . '*');
        $query->sortClauses[] = new SortClause\ContentName();

        $searchResults = $this->searchService->findContent($query);
        foreach ($searchResults as $searchResult) {
            /** @var \Ibexa\Contracts\Core\Repository\Values\Content\Content $content */
            $content = $searchResult->valueObject;

            if (!$queryString->isPrefixOf($content->getName())) {
                continue;
            }

            yield new ContentSuggestion(
                $content,
                $this->urlGenerator->generate('ibexa.content.view', [
                    'contentId' => $content->id,
                ])
            );
        }

        return [];
    }
}
