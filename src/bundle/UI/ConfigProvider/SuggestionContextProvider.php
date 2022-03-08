<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\UI\ConfigProvider;

use Ibexa\Contracts\AdminUi\UI\Config\ProviderInterface;

final class SuggestionContextProvider implements ProviderInterface
{
    /** @var SuggestionContextResolverInterface[] */
    private $resolvers;

    public function __construct(iterable $resolvers)
    {
        $this->resolvers = $resolvers;
    }

    public function getConfig(): array
    {
        foreach ($this->resolvers as $resolver) {
            $context = $resolver->resolve();

            if ($context !== null) {
                return [
                    'identifier' => $context->getIdentifier(),
                    'payload' => $context->getPayload(),
                ];
            }
        }

        return [
            'identifier' => 'unknown',
        ];
    }
}
