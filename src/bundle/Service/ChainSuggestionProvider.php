<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service;

final class ChainSuggestionProvider implements SuggestionProviderInterface
{
    /** @var SuggestionProviderInterface[] */
    private $providers;

    public function __construct(iterable $providers)
    {
        $this->providers = $providers;
    }

    public function getSuggestions(QueryString $query): iterable
    {
        foreach ($this->providers as $provider) {
            foreach ($provider->getSuggestions($query) as $suggestion) {
                yield $suggestion;
            }
        }

        yield from [];
    }
}
