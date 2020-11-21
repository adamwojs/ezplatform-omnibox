<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service;

final class SuggestionQuery
{
    public const DEFAULT_LIMIT = 10;

    /** @var QueryString */
    private $queryString;

    /** @var int */
    private $limit;

    /** @var string[]|null */
    private $types;

    public function __construct(
        QueryString $queryString,
        int $limit = self::DEFAULT_LIMIT,
        ?array $types = null
    ) {
        $this->queryString = $queryString;
        $this->limit = $limit;
        $this->types = $types;
    }

    public function getQueryString(): QueryString
    {
        return $this->queryString;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getTypes(): ?array
    {
        return $this->types;
    }
}
