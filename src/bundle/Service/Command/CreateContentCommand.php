<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\DFA;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\DFAPath;
use AdamWojs\EzPlatformOmniboxBundle\Service\CommandSuggestion;
use AdamWojs\EzPlatformOmniboxBundle\Service\Suggestion;
use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;
use Ibexa\Contracts\Core\Repository\Values\ContentType\ContentType;
use Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class CreateContentCommand implements CommandInterface, ContextBasedCommandInterface
{
    /** @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface */
    private $urlGenerator;

    /** @var \Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface */
    private $configResolver;

    public function __construct(UrlGeneratorInterface $urlGenerator, ConfigResolverInterface $configResolver)
    {
        $this->urlGenerator = $urlGenerator;
        $this->configResolver = $configResolver;
    }

    public function getCommandName(): string
    {
        return self::class;
    }

    public function buildDFA(DFA $dfa, SuggestionContext $context): void
    {
        // Create content <ContentType>
        $dfa
            ->addTextState('create')
            ->addTextState('content')
            ->addParameter('content_type', 'content_type')
            ->addAcceptState($this->getCommandName());
    }

    public function buildSuggestion(DFAPath $path, SuggestionContext $context): Suggestion
    {
        /** @var \Ibexa\Contracts\Core\Repository\Values\ContentType\ContentType $contentType */
        $contentType = $path->getParameter('content_type')->getValue();

        return new CommandSuggestion(
            $path->join(),
            $this->urlGenerator->generate(
                'ibexa.content.create.proxy',
                [
                    'parentLocationId' => $context->get('locationId'),
                    'languageCode' => $this->getDefaultLanguageCode(),
                    'contentTypeIdentifier' => $contentType->identifier,
                ]
            )
        );
    }

    public function supportsContext(SuggestionContext $context): bool
    {
        return $context->isA('content_view');
    }

    private function getDefaultLanguageCode(): string
    {
        return $this->configResolver->getParameter('languages')[0];
    }
}
