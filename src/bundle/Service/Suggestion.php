<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service;

use JsonSerializable;

interface Suggestion extends JsonSerializable
{
    public function getDisplayText(): string;

    public function getActionUrl(): string;
}
