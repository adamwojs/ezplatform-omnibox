<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
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

    /** @var SuggestionContext */
    private $context;

    public function __construct(
        QueryString $queryString,
        int $limit = self::DEFAULT_LIMIT,
        ?array $types = null,
        ?SuggestionContext $context = null
    ) {
        if ($context === null) {
            $context = new SuggestionContext('unknown');
        }

        $this->queryString = $queryString;
        $this->limit = $limit;
        $this->types = $types;
        $this->context = $context;
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

    public function getContext(): SuggestionContext
    {
        return $this->context;
    }
}
