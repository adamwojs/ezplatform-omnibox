<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\DFA;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\DFAPath;
use AdamWojs\EzPlatformOmniboxBundle\Service\CommandSuggestion;
use AdamWojs\EzPlatformOmniboxBundle\Service\Suggestion;
use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;
use eZ\Publish\API\Repository\Values\ContentType\ContentType;
use eZ\Publish\Core\MVC\ConfigResolverInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class CreateContentCommand implements CommandInterface, ContextBasedCommandInterface
{
    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    /** @var ConfigResolverInterface */
    private $configResolver;

    public function __construct(UrlGeneratorInterface $urlGenerator, ConfigResolverInterface $configResolver)
    {
        $this->urlGenerator = $urlGenerator;
        $this->configResolver = $configResolver;
    }

    public function buildDFA(DFA $dfa, SuggestionContext $context): void
    {
        // Create content <ContentType>
        $dfa
            ->addTextState('create')
            ->addTextState('content')
            ->addParameter('content_type', 'content_type')
            ->addAcceptState(self::class);
    }

    public function buildSuggestion(DFAPath $path, SuggestionContext $context): Suggestion
    {
        /** @var ContentType $contentType */
        $contentType = $path->getParameter('content_type')->getValue();

        return new CommandSuggestion(
            $path->join(),
            $this->urlGenerator->generate(
                'ezplatform.content.create.proxy',
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
