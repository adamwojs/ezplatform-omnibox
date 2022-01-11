<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\AcceptState;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\DFA;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\ParameterState;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\State;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\TextState;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Lexer\LexerInterface;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Lexer\Token;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\ParameterResolver\ParameterResolverRegistry;
use RuntimeException;

final class DFAVisitor implements VisitorInterface
{
    /** @var \AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\ParameterResolver\ParameterResolverRegistry */
    private $parameterResolverRegistry;

    /** @var \AdamWojs\EzPlatformOmniboxBundle\Service\Command\Lexer\LexerInterface */
    private $lexer;

    public function __construct(
        ParameterResolverRegistry $parameterResolverRegistry,
        LexerInterface $lexer
    ) {
        $this->parameterResolverRegistry = $parameterResolverRegistry;
        $this->lexer = $lexer;
    }

    /**
     * @return DFAPath[]
     */
    public function visitRootNode(DFA $node): iterable
    {
        foreach ($node->getEdges() as $child) {
            yield from $this->visit($child);
        }
    }

    /**
     * @return DFAPath[]
     */
    public function visitTextNode(TextState $node): iterable
    {
        $predict = $this->lexer->isEOF();

        $this->lexer->pushState();

        $token = $this->lexer->consume();
        if ($predict || ($token->isA(Token::TYPE_WORD) && strpos($node->getText(), $token->getValue()) === 0)) {
            foreach ($node->getEdges() as $state) {
                foreach ($this->visit($state) as $path) {
                    yield $path->prepend($node);
                }
            }
        }

        $this->lexer->popState();
    }

    /**
     * @return DFAPath[]
     */
    public function visitParameterNode(ParameterState $node): iterable
    {
        $this->lexer->pushState();

        $empty = true;

        $token = $this->lexer->consume();
        $prefix = $token ? $token->getValue() : '';

        foreach ($this->resolveParameter($node, $prefix) as $parameterValue) {
            $empty = false;

            foreach ($node->getEdges() as $child) {
                foreach ($this->visit($child) as $path) {
                    $path->addParameter($node->getName(), $parameterValue);

                    yield $path->prepend($node);
                }
            }
        }

        $this->lexer->popState();

        if ($empty) {
            yield from [];
        }
    }

    /**
     * @return DFAPath[]
     */
    public function visitAcceptNode(AcceptState $node): iterable
    {
        yield new DFAPath($node);
    }

    /**
     * @return DFAPath[]
     */
    private function visit(State $node): iterable
    {
        if ($node instanceof TextState) {
            return $this->visitTextNode($node);
        }

        if ($node instanceof ParameterState) {
            return $this->visitParameterNode($node);
        }

        if ($node instanceof AcceptState) {
            return $this->visitAcceptNode($node);
        }

        throw new RuntimeException('Unknown node type: ' . get_class($node));
    }

    /**
     * @return \Ibexa\Contracts\Core\Repository\Values\ValueObject[]
     */
    private function resolveParameter(ParameterState $node, string $prefix): iterable
    {
        return $this
            ->parameterResolverRegistry
            ->getResolver($node->getType())
            ->resolve($node, $prefix);
    }
}
