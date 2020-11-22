<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\DFA;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\DFAPath;
use AdamWojs\EzPlatformOmniboxBundle\Service\CommandSuggestion;
use AdamWojs\EzPlatformOmniboxBundle\Service\Suggestion;
use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;
use eZ\Publish\API\Repository\ContentTypeService;
use eZ\Publish\API\Repository\Values\ContentType\ContentTypeGroup;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class CreateContentTypeCommand implements CommandInterface
{
    /** @var \eZ\Publish\API\Repository\ContentTypeService */
    private $contentTypeService;

    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    public function __construct(ContentTypeService $contentTypeService, UrlGeneratorInterface $urlGenerator)
    {
        $this->contentTypeService = $contentTypeService;
        $this->urlGenerator = $urlGenerator;
    }

    public function buildDFA(DFA $dfa, SuggestionContext $context): void
    {
        // Create content type
        $dfa->addTextState('create')->addTextState('content')->addTextState('type')->addAcceptState(self::class);
    }

    public function buildSuggestion(DFAPath $path, SuggestionContext $context): Suggestion
    {
        return new CommandSuggestion(
            $path->join(),
            $this->urlGenerator->generate('ezplatform.content_type.add', [
                'contentTypeGroupId' => $this->getDefaultContentTypeGroup()->id,
            ])
        );
    }

    private function getDefaultContentTypeGroup(): ContentTypeGroup
    {
        return $this->contentTypeService->loadContentTypeGroupByIdentifier('Content');
    }
}
