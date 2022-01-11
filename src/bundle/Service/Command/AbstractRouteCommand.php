<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\DFAPath;
use AdamWojs\EzPlatformOmniboxBundle\Service\CommandSuggestion;
use AdamWojs\EzPlatformOmniboxBundle\Service\Suggestion;
use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractRouteCommand implements CommandInterface
{
    /** @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface */
    private $urlGenerator;

    /** @var string */
    private $routeName;

    public function getCommandName(): string
    {
        return static::class;
    }

    public function __construct(UrlGeneratorInterface $urlGenerator, string $routeName)
    {
        $this->urlGenerator = $urlGenerator;
        $this->routeName = $routeName;
    }

    final public function buildSuggestion(DFAPath $path, SuggestionContext $context): Suggestion
    {
        $parameters = $this->getRouteParameters($path, $context);

        return new CommandSuggestion(
            $path->join(),
            $this->urlGenerator->generate($this->routeName, $parameters)
        );
    }

    protected function getRouteParameters(DFAPath $path, SuggestionContext $context): array
    {
        return [];
    }
}
