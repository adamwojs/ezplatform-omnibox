<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\DFA;
use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Non parameterized route based command.
 */
final class NonArgRouteCommand extends AbstractRouteCommand
{
    /** @var string */
    private $commandName;

    /** @var string */
    private $commandText;

    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        string $commandName,
        string $commandText,
        string $routeName
    ) {
        parent::__construct($urlGenerator, $routeName);

        $this->commandText = $commandText;
        $this->commandName = $commandName;
    }

    public function getCommandName(): string
    {
        return $this->commandName;
    }

    public function buildDFA(DFA $dfa, SuggestionContext $context): void
    {
        $node = $dfa;
        foreach (explode(' ', $this->commandText) as $word) {
            $node = $node->addTextState($word);
        }

        $node->addAcceptState($this->getCommandName());
    }
}
