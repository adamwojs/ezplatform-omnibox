<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Lexer;

final class Token
{
    public const TYPE_NONE = '<none>';
    public const TYPE_WORD = '<word>';
    public const TYPE_EOF = '<eof>';

    /** @var string */
    private $type;

    /** @var string */
    private $value;

    /** @var int */
    private $position;

    public function __construct(string $type, string $value = '', int $position = -1)
    {
        $this->type = $type;
        $this->value = $value;
        $this->position = $position;
    }

    public function isA(string $type): bool
    {
        return $this->type === $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function __toString(): string
    {
        if ($this->value !== null) {
            return "{$this->value} ({$this->type})";
        }

        return "{$this->type}";
    }
}
