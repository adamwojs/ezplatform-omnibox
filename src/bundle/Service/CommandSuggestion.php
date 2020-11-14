<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service;

final class CommandSuggestion implements Suggestion
{
    /** @var string */
    private $displayText;

    /** @var string */
    private $actionUrl;

    public function __construct(string $displayText, string $actionUrl = '')
    {
        $this->displayText = $displayText;
        $this->actionUrl = $actionUrl;
    }

    public function getDisplayText(): string
    {
        return $this->displayText;
    }

    public function getActionUrl(): string
    {
        return $this->actionUrl;
    }

    public function jsonSerialize(): array
    {
        return [
            'displayText' => $this->displayText,
            'actionUrl' => $this->actionUrl,
        ];
    }
}
