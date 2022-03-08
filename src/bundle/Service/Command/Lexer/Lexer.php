<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Lexer;

use ArrayIterator;
use Iterator;

final class Lexer implements LexerInterface, \IteratorAggregate
{
    /** @var string */
    private $input;

    /** @var Token[] */
    private $tokens = [];

    /** @var int|null */
    private $position;

    /** @var Token|null */
    private $current;

    /** @var Token|null */
    private $next;

    /** @var array|null */
    private $stack;

    public function consume(): Token
    {
        if ($this->next !== null) {
            $this->current = $this->next;
            $this->next = $this->tokens[++$this->position] ?? null;
        }

        return $this->current;
    }

    public function isEOF(): bool
    {
        return $this->next === null || $this->next->isA(Token::TYPE_EOF);
    }

    public function peek(): ?Token
    {
        return $this->next;
    }

    public function getInput(): string
    {
        return $this->input;
    }

    public function tokenize(string $input): void
    {
        $this->reset();

        $this->input = $input;
        $this->tokens = [];
        foreach ($this->split($input) as $match) {
            [$value, $position] = $match;
            $value = trim($value);

            if ($value === '') {
                // Skip whitespaces
                continue;
            }

            $this->tokens[] = new Token(
                Token::TYPE_WORD,
                $value,
                $position
            );
        }

        $this->tokens[] = new Token(Token::TYPE_EOF);
        $this->next = $this->tokens[0] ?? null;
    }

    public function pushState(): void
    {
        array_push($this->stack, [
            $this->position,
            $this->current,
            $this->next,
        ]);
    }

    public function popState(): void
    {
        [$this->position, $this->current, $this->next] = array_pop($this->stack);
    }

    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->tokens);
    }

    private function reset(): void
    {
        $this->position = 0;
        $this->next = null;
        $this->current = null;
        $this->stack = [];
    }

    private function split(string $input): array
    {
        $flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE;

        return preg_split('/\s+/iu', $input, -1, $flags);
    }
}
