<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service;

final class SuggestionContext
{
    /** @var string */
    private $identifier;

    /** @var array */
    private $payload;

    public function __construct(string $identifier, array $payload = [])
    {
        $this->identifier = $identifier;
        $this->payload = $payload;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function isA(string $identifier): bool
    {
        return $this->identifier === $identifier;
    }

    public function has(string $key): bool
    {
        return isset($this->payload[$key]);
    }

    public function get(string $key, $default = null)
    {
        return $this->payload[$key] ?? $default;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }
}
