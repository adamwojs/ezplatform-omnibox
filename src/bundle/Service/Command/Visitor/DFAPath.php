<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\AcceptState;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\State;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\ParameterState;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\TextState;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\ParameterResolver\ParameterValue;
use ArrayIterator;
use Iterator;
use IteratorAggregate;

final class DFAPath implements IteratorAggregate
{
    /** @var State[] */
    private $path;

    /** @var AcceptState */
    private $acceptState;

    /** @var ParameterValue[] */
    private $parameters = [];

    public function __construct(AcceptState $state)
    {
        $this->acceptState = $state;
        $this->path = [$state];
    }

    public function getAcceptState(): AcceptState
    {
        return $this->acceptState;
    }

    public function getPath(): array
    {
        return $this->path;
    }

    public function prepend(State $segment): self
    {
        array_unshift($this->path, $segment);

        return $this;
    }

    public function append(State $segment): self
    {
        array_push($this->parameters, $segment);

        return $this;
    }

    /**
     * @return ParameterValue[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getParameter(string $name): ParameterValue
    {
        return $this->parameters[$name];
    }

    public function addParameter(string $name, ParameterValue $value): void
    {
        $this->parameters[$name] = $value;
    }

    public function join(string $glue = ' '): string
    {
        $pieces = [];
        foreach ($this->path as $node) {
            if ($node instanceof TextState) {
                $pieces[] = $node->getText();
                continue;
            }

            if ($node instanceof ParameterState) {
                $pieces[] = $this->getParameter($node->getName())->getLabel();
                continue;
            }
        }

        return implode($glue, $pieces);
    }

    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->path);
    }
}
