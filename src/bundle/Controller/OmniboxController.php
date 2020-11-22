<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Controller;

use AdamWojs\EzPlatformOmniboxBundle\Service\QueryString;
use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;
use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionProviderInterface;
use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionQuery;
use EzSystems\EzPlatformRest\Server\Exceptions\BadRequestException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class OmniboxController extends AbstractController
{
    /** @var SuggestionProviderInterface */
    private $suggestionProvider;

    public function __construct(SuggestionProviderInterface $omniboxService)
    {
        $this->suggestionProvider = $omniboxService;
    }

    public function searchAction(Request $request): JsonResponse
    {
        $query = $this->createSuggestionQuery($request);

        if ($query->getQueryString()->isEmpty() || $query->getLimit() <= 0) {
            // No suggestions for empty query
            return new JsonResponse([]);
        }

        $suggestions = $this->suggestionProvider->getSuggestions($query);

        $response = new JsonResponse(iterator_to_array($suggestions));
        $response->setPrivate();
        $response->setTtl(0);

        return $response;
    }

    private function createSuggestionQuery(Request $request): SuggestionQuery
    {
        $types = $request->query->get('types');
        if ($types !== null && !is_array($types)) {
            throw new BadRequestException();
        }

        $queryString = new QueryString($request->query->get('query', ''));

        return new SuggestionQuery(
            $queryString,
            $request->query->getInt('limit', SuggestionQuery::DEFAULT_LIMIT),
            $types,
            $this->createSuggestionContext($request)
        );
    }

    private function createSuggestionContext(Request $request): SuggestionContext
    {
        $context = $request->query->get('context');

        if (empty($context)) {
            return new SuggestionContext('unknown');
        }

        return new SuggestionContext(
            $context['identifier'],
            $context['payload'] ?? []
        );
    }
}
