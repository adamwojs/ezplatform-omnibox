<?php

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
        foreach ($this->getEdges() as $child) {
            if ($child instanceof TextState && $child->getText() === $text) {
                return $child;
            }
        }

        return $this->addState(new TextState($text));
    }

    public function addParameter(string $name, string $type): State
    {
        foreach ($this->getEdges() as $child) {
            if ($child instanceof ParameterState &&
                $child->getName() === $name &&
                $child->getType() === $type
            ) {
                return $child;
            }
        }

        return $this->addState(new ParameterState($name, $type));
    }

    public function addAcceptState(?string $label = null): State
    {
        foreach ($this->getEdges() as $child) {
            if ($child instanceof AcceptState) {
                return $child;
            }
        }

        return $this->addState(new AcceptState($label));
    }

    private function addState(State $node): State
    {
        $node->setParent($this);
        $this->edges[] = $node;

        return $node;
    }
}
