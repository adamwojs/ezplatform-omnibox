<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
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
