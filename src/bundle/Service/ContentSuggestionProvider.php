<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service;

use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\Content;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ContentSuggestionProvider implements SuggestionProviderInterface
{
    /** @var SearchService */
    private $searchService;

    /** @var UrlGeneratorInterface */
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
            /** @var Content $content */
            $content = $searchResult->valueObject;

            if (!$queryString->isPrefixOf($content->getName())) {
                continue;
            }

            yield new ContentSuggestion(
                $content,
                $this->urlGenerator->generate('_ez_content_view', [
                    'contentId' => $content->id,
                ])
            );
        }

        return [];
    }
}
