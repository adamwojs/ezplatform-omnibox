<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA;

final class TextState extends State
{
    /** @var string */
    private $text;

    public function __construct(string $text, ?State $parent = null)
    {
        parent::__construct($parent);

        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
