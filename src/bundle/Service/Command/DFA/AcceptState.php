<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA;

final class AcceptState extends State
{
    /** @var string|null */
    private $label;

    public function __construct(?string $label = null, ?State $parent = null)
    {
        parent::__construct($parent);

        $this->label = $label;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }
}
