<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Lexer\LexerInterface;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\ParameterResolver\ParameterResolverRegistry;

final class DFAVisitorFactory
{
    /** @var ParameterResolverRegistry */
    private $parameterResolverRegistry;

    public function __construct(ParameterResolverRegistry $parameterResolverRegistry)
    {
        $this->parameterResolverRegistry = $parameterResolverRegistry;
    }

    public function createVisitor(LexerInterface $lexer): DFAVisitor
    {
        return new DFAVisitor($this->parameterResolverRegistry, $lexer);
    }
}
