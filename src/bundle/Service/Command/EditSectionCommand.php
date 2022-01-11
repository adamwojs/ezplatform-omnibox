<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\DFA;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\DFAPath;
use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class EditSectionCommand extends AbstractRouteCommand
{
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        parent::__construct($urlGenerator, 'ibexa.section.update');
    }

    public function buildDFA(DFA $dfa, SuggestionContext $context): void
    {
        $dfa->addTextState('edit')
            ->addTextState('section')
            ->addParameter('section', 'section')
            ->addAcceptState($this->getCommandName());
    }

    protected function getRouteParameters(DFAPath $path, SuggestionContext $context): array
    {
        /** @var \Ibexa\Contracts\Core\Repository\Values\Content\Section $section */
        $section = $path->getParameter('section')->getValue();

        return [
            'sectionId' => $section->id,
        ];
    }
}
