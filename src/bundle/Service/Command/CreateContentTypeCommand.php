<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\DFA;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\DFAPath;
use AdamWojs\EzPlatformOmniboxBundle\Service\CommandSuggestion;
use AdamWojs\EzPlatformOmniboxBundle\Service\Suggestion;
use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;
use eZ\Publish\API\Repository\Values\ContentType\ContentTypeGroup;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class CreateContentTypeCommand implements CommandInterface
{
    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function getCommandName(): string
    {
        return self::class;
    }

    public function buildDFA(DFA $dfa, SuggestionContext $context): void
    {
        // Create content type (default content type group)
        $dfa->addTextState('create')
            ->addTextState('content')
            ->addTextState('type')
            ->addTextState('in')
            ->addParameter('content_type_group', 'content_type_group')
            ->addTextState('group')
            ->addAcceptState($this->getCommandName());
    }

    public function buildSuggestion(DFAPath $path, SuggestionContext $context): Suggestion
    {
        /** @var ContentTypeGroup $contentTypeGroup */
        $contentTypeGroup = $path->getParameter('content_type_group')->getValue();

        return new CommandSuggestion(
            $path->join(),
            $this->urlGenerator->generate('ezplatform.content_type.add', [
                'contentTypeGroupId' => $contentTypeGroup->id,
            ])
        );
    }
}
