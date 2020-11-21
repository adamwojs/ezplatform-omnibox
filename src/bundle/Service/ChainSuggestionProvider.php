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

    public function getSuggestions(SuggestionQuery $query): iterable
    {
        foreach ($this->providers as $type => $provider) {
            if ($query->getTypes() !== null && !in_array($type, $query->getTypes())) {
                continue;
            }

            foreach ($provider->getSuggestions($query) as $suggestion) {
                yield $suggestion;
            }
        }

        yield from [];
    }
}
