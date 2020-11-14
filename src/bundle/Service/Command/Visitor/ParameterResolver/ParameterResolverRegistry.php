<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\ParameterResolver;

use ArrayIterator;
use Iterator;
use IteratorAggregate;

final class ParameterResolverRegistry implements IteratorAggregate
{
    /** @var ParameterResolver[] */
    private $resolvers;

    public function __construct(iterable $resolvers)
    {
        $this->resolvers = $resolvers;
    }

    public function hasResolver(string $type): bool
    {
        return $this->findResolver($type) !== null;
    }

    public function getResolver(string $type): ParameterResolver
    {
        return $this->findResolver($type);
    }

    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->resolvers);
    }

    private function findResolver(string $type): ?ParameterResolver
    {
        foreach ($this->resolvers as $resolver) {
            if ($resolver->getType() === $type) {
                return $resolver;
            }
        }

        return null;
    }
}
