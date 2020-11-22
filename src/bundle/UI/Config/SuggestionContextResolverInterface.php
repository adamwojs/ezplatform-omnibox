<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\UI\Config;

use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;

interface SuggestionContextResolverInterface
{
    public function resolve(): ?SuggestionContext;
}
