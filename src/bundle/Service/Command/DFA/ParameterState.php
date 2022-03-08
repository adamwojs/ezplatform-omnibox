<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA;

final class ParameterState extends State
{
    /** @var string */
    private $name;

    /** @var string */
    private $type;

    public function __construct(string $name, string $type, ?State $parent = null)
    {
        parent::__construct($parent);

        $this->name = $name;
        $this->type = $type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function equalsTo(State $state): bool
    {
        if ($this === $state) {
            return true;
        }

        if ($state instanceof ParameterState) {
            return $this->type === $state->type && $this->name === $state->name;
        }

        return false;
    }
}
