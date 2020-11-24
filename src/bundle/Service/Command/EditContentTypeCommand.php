<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\DFA;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\DFAPath;
use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;
use eZ\Publish\API\Repository\Values\ContentType\ContentType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class EditContentTypeCommand extends AbstractRouteCommand
{
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        parent::__construct($urlGenerator, 'ezplatform.content_type.edit');
    }

    public function getCommandName(): string
    {
        return self::class;
    }

    public function buildDFA(DFA $dfa, SuggestionContext $context): void
    {
        $dfa->addTextState('edit')
            ->addTextState('content')
            ->addTextState('type')
            ->addParameter('content_type', 'content_type')
            ->addAcceptState($this->getCommandName());
    }

    protected function getRouteParameters(DFAPath $path, SuggestionContext $context): array
    {
        /** @var ContentType $contentType */
        $contentType = $path->getParameter('content_type')->getValue();

        return [
            'contentTypeId' => $contentType->id,
            'contentTypeGroupId' => $contentType->contentTypeGroups[0]->id,
        ];
    }
}
