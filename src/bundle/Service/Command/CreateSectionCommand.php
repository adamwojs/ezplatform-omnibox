<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\DFA;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\DFAPath;
use AdamWojs\EzPlatformOmniboxBundle\Service\CommandSuggestion;
use AdamWojs\EzPlatformOmniboxBundle\Service\Suggestion;
use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class CreateSectionCommand implements CommandInterface
{
    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function buildSuggestion(DFAPath $path, SuggestionContext $context): Suggestion
    {
        return new CommandSuggestion(
            $path->join(),
            $this->urlGenerator->generate('ezplatform.section.create')
        );
    }

    public function buildDFA(DFA $dfa, SuggestionContext $context): void
    {
        // Create section
        $dfa->addTextState('create')->addTextState('section')->addAcceptState(self::class);
    }
}
