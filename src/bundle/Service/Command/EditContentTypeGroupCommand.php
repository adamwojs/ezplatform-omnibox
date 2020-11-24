<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\DFA;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\DFAPath;
use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;
use eZ\Publish\API\Repository\Values\ContentType\ContentTypeGroup;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class EditContentTypeGroupCommand extends AbstractRouteCommand
{
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        parent::__construct($urlGenerator, 'ezplatform.content_type_group.update');
    }

    public function buildDFA(DFA $dfa, SuggestionContext $context): void
    {
        $dfa->addTextState('edit')
            ->addTextState('content')
            ->addTextState('type')
            ->addTextState('group')
            ->addParameter('content_type_group', 'content_type_group')
            ->addAcceptState($this->getCommandName());
    }

    protected function getRouteParameters(DFAPath $path, SuggestionContext $context): array
    {
        /** @var ContentTypeGroup $contentTypeGroup */
        $contentTypeGroup = $path->getParameter('content_type_group')->getValue();

        return [
            'contentTypeGroupId' => $contentTypeGroup->id,
        ];
    }
}
