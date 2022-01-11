<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Lexer\LexerInterface;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\ParameterResolver\ParameterResolverRegistry;

final class DFAVisitorFactory
{
    /** @var \AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\ParameterResolver\ParameterResolverRegistry */
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
