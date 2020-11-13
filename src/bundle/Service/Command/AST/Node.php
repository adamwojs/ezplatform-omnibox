<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\AST;

abstract class Node
{
    /** @var Node|null */
    private $parent;

    /** @var Node|Node[]|null */
    private $children;

    public function __construct(?Node $parent = null)
    {
        $this->parent = $parent;
    }

    public function getParent(): ?Node
    {
        return $this->parent;
    }

    public function setParent(?Node $parent): void
    {
        $this->parent = $parent;
    }

    public function isRoot(): bool
    {
        return $this->parent === null;
    }

    public function isLeaf(): bool
    {
        return !$this->hasChildren();
    }

    public function hasChildren(): bool
    {
        return !empty($this->children);
    }

    /**
     * @return Node[]
     */
    public function getChildren(): array
    {
        if ($this->children === null) {
            return [];
        }

        if ($this->children instanceof Node) {
            return [$this->children];
        }

        return $this->children;
    }

    public function addTextChild(string $text): Node
    {
        foreach ($this->getChildren() as $child) {
            if ($child instanceof TextNode && $child->getText() === $text) {
                return $child;
            }
        }

        return $this->addChild(new TextNode($text));
    }

    public function addPlaceholder(string $name): Node
    {
        foreach ($this->getChildren() as $child) {
            if ($child instanceof PlaceholderNode && $child->getName() === $name) {
                return $child;
            }
        }

        return $this->addChild(new PlaceholderNode($name));
    }

    public function addEpsilon(): Node
    {
        foreach ($this->getChildren() as $child) {
            if ($child instanceof EpsilonNode) {
                return $child;
            }
        }

        return $this->addChild(new EpsilonNode());
    }

    public function addChild(Node $node): Node
    {
        $node->setParent($this);
        $this->children[] = $node;

        return $node;
    }
}
