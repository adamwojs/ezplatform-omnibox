<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\DFA;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\DFAPath;
use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;
use eZ\Publish\API\Repository\Values\Content\Language;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class EditLanguageCommand extends AbstractRouteCommand
{
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        parent::__construct($urlGenerator, 'ezplatform.language.edit');
    }

    public function buildDFA(DFA $dfa, SuggestionContext $context): void
    {
        $dfa->addTextState('edit')
            ->addTextState('language')
            ->addParameter('language', 'language')
            ->addAcceptState($this->getCommandName());
    }

    protected function getRouteParameters(DFAPath $path, SuggestionContext $context): array
    {
        /** @var Language $language */
        $language = $path->getParameter('language')->getValue();

        return [
            'languageId' => $language->id,
        ];
    }
}
