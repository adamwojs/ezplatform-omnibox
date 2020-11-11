<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service;

interface SuggestionProviderInterface
{
    public const DEFAULT_SUGGESTIONS_LIMIT = 5;

    /**
     * @return Suggestion[]
     */
    public function getSuggestions(QueryString $query, int $limit = self::DEFAULT_SUGGESTIONS_LIMIT): iterable;
}
