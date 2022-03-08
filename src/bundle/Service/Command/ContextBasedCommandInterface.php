<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;

/**
 * Mark command as context sensible.
 */
interface ContextBasedCommandInterface
{
    public function supportsContext(SuggestionContext $context): bool;
}
