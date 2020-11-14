<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\ParameterResolver;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\ParameterState;
use eZ\Publish\API\Repository\LanguageService;

final class LanguageParameterResolver implements ParameterResolver
{
    /** @var \eZ\Publish\API\Repository\LanguageService */
    private $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function resolve(ParameterState $node, string $prefix): iterable
    {
        foreach ($this->languageService->loadLanguages() as $language) {
            if ($prefix === '' || strpos($language->name, $prefix) === 0) {
                yield new ParameterValue(
                    $language->name,
                    $language
                );
            }
        }

        yield from [];
    }

    public function getType(): string
    {
        return 'language';
    }
}
