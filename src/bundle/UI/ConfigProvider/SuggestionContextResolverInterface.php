<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\UI\ConfigProvider;

use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;

interface SuggestionContextResolverInterface
{
    public function resolve(): ?SuggestionContext;
}
