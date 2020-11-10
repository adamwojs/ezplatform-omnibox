<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service;

use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\Content;
use eZ\Publish\API\Repository\Values\Content\ContentInfo;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ContentProvider implements SuggestionProviderInterface
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

    public function getSuggestions(QueryString $suggestionQuery): iterable
    {
        $query = new Query();
        $query->filter = new Criterion\FullText($suggestionQuery->toString() . '*');
        $query->sortClauses[] = new SortClause\ContentName();

        $searchResults = $this->searchService->findContent($query);
        foreach ($searchResults as $searchResult) {
            /** @var Content $content */
            $content = $searchResult->valueObject;

            $text = $content->getName();
            if (!$suggestionQuery->isPrefixOf($text)) {
                continue;
            }

            yield new Suggestion(
                $text,
                $this->urlGenerator->generate('_ez_content_view', [
                    'contentId' => $content->id,
                ])
            );
        }

        return [];
    }
}
