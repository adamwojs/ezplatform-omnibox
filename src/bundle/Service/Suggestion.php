<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service;

use eZ\Publish\API\Repository\Values\ValueObject;
use JsonSerializable;

class Suggestion extends ValueObject implements JsonSerializable
{
    /** @var string */
    public $text;

    /** @var string|null */
    public $actionUrl;

    public function __construct(string $text, ?string $actionUrl = null)
    {
        parent::__construct();

        $this->text = $text;
        $this->actionUrl = $actionUrl;
    }

    public function jsonSerialize(): array
    {
        return [
            'text' => $this->text,
            'actionUrl' => $this->actionUrl,
        ];
    }
}
