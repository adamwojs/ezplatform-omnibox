<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Lexer;

interface LexerInterface
{
    /**
     * Returns analyzed input string.
     */
    public function getInput(): string;

    /**
     * Analyze given string.
     */
    public function tokenize(string $input): void;

    /**
     * Consume and return current token.
     */
    public function consume(): Token;

    /**
     * Returns next token (if available) without moving internal token stream pointer.
     */
    public function peek(): ?Token;

    /**
     * Returns true if there is no more tokens available in the stream.
     */
    public function isEOF(): bool;

    /**
     * Push current lexer state.
     */
    public function pushState(): void;

    /**
     * Pop lexer state.
     */
    public function popState(): void;
}
