<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA;

abstract class State
{
    /** @var State|null */
    private $parent;

    /** @var State|State[]|null */
    private $edges;

    public function __construct(?State $parent = null)
    {
        $this->parent = $parent;
    }

    public function getParent(): ?State
    {
        return $this->parent;
    }

    public function setParent(?State $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return State[]
     */
    public function getEdges(): array
    {
        if ($this->edges === null) {
            return [];
        }

        if ($this->edges instanceof State) {
            return [$this->edges];
        }

        return $this->edges;
    }

    public function addTextState(string $text): State
    {
        return $this->addState(new TextState($text));
    }

    public function addParameter(string $name, string $type): State
    {
        return $this->addState(new ParameterState($name, $type));
    }

    public function addAcceptState(?string $label = null): State
    {
        return $this->addState(new AcceptState($label));
    }

    public function equalsTo(State $state): bool
    {
        return $this === $state;
    }

    private function addState(State $state): State
    {
        foreach ($this->getEdges() as $child) {
            if ($child->equalsTo($state)) {
                return $child;
            }
        }

        $state->setParent($this);
        $this->edges[] = $state;

        return $state;
    }
}
