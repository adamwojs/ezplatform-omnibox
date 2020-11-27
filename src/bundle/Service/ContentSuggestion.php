<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service;

use eZ\Publish\API\Repository\Values\Content\Content;

final class ContentSuggestion implements Suggestion
{
    /** @var \eZ\Publish\API\Repository\Values\Content\Content */
    private $content;

    /** @var string */
    private $actionUrl;

    public function __construct(Content $content, string $actionUrl)
    {
        $this->content = $content;
        $this->actionUrl = $actionUrl;
    }

    public function getDisplayText(): string
    {
        return $this->content->getName();
    }

    public function getActionUrl(): string
    {
        return $this->actionUrl;
    }

    public function getContent(): Content
    {
        return $this->content;
    }

    public function jsonSerialize(): array
    {
        $contentType = $this->content->getContentType();

        return [
            'name' => $this->getDisplayText(),
            'actionUrl' => $this->actionUrl,
            'contentType' => $contentType->identifier,
            'parentName' => $this->getParentLocationContentName(),
        ];
    }

    private function getParentLocationContentName(): ?string
    {
        return $this->content->contentInfo
            ->getMainLocation()
            ->getParentLocation()
            ->getContent()
            ->getName() ?? null;
    }
}
