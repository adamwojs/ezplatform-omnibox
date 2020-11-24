<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\DFA;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\DFAPath;
use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;
use eZ\Publish\API\Repository\Values\ObjectState\ObjectStateGroup;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class EditObjectStateGroupCommand extends AbstractRouteCommand
{
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        parent::__construct($urlGenerator, 'ezplatform.object_state.group.update');
    }

    public function buildDFA(DFA $dfa, SuggestionContext $context): void
    {
        $dfa->addTextState('edit')
            ->addTextState('object')
            ->addTextState('group')
            ->addParameter('object_state_group', 'object_state_group')
            ->addAcceptState($this->getCommandName());
    }

    protected function getRouteParameters(DFAPath $path, SuggestionContext $context): array
    {
        /** @var ObjectStateGroup $objectStateGroup */
        $objectStateGroup = $path->getParameter('object_state_group')->getValue();

        return [
            'objectStateGroupId' => $objectStateGroup->id,
        ];
    }
}
