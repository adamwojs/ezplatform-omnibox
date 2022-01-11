<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service;

use JsonSerializable;

interface Suggestion extends JsonSerializable
{
    public function getDisplayText(): string;

    public function getActionUrl(): string;
}
