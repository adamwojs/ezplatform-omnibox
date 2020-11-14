<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA;

final class TextNode extends Node
{
    /** @var string */
    private $text;

    public function __construct(string $text, ?Node $parent = null)
    {
        parent::__construct($parent);

        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
