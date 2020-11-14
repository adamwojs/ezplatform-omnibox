<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA;

final class PlaceholderNode extends Node
{
    /** @var string */
    private $name;

    public function __construct(string $name, ?Node $parent = null)
    {
        parent::__construct($parent);

        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
