<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Controller;

use AdamWojs\EzPlatformOmniboxBundle\Service\QueryString;
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
        $queryString = new QueryString($request->query->get('query', ''));
        $limit = $request->query->getInt('limit', SuggestionQuery::DEFAULT_LIMIT);
        $types = $request->query->get('types');

        if ($types !== null && !is_array($types)) {
            throw new BadRequestException();
        }

        if ($queryString->isEmpty() || $limit <= 0) {
            // No suggestions for empty query
            return new JsonResponse([]);
        }

        $suggestions = $this->suggestionProvider->getSuggestions(
            new SuggestionQuery($queryString, $limit, $types)
        );

        $response = new JsonResponse(iterator_to_array($suggestions));
        $response->setPrivate();
        $response->setTtl(0);

        return $response;
    }
}
