<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service;

interface SuggestionProviderInterface
{
    /**
     * @return Suggestion[]
     */
    public function getSuggestions(QueryString $query): iterable;
}
