<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\UI\Config\SuggestionContextResolver;

use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;
use AdamWojs\EzPlatformOmniboxBundle\UI\Config\SuggestionContextResolverInterface;
use eZ\Publish\Core\MVC\Symfony\View\ContentView;
use Symfony\Component\HttpFoundation\RequestStack;

final class ContentViewSuggestionContextResolver implements SuggestionContextResolverInterface
{
    /** @var RequestStack */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function resolve(): ?SuggestionContext
    {
        $view = $this->requestStack->getMasterRequest()->get('view');

        if ($view instanceof ContentView) {
            return new SuggestionContext('content_view', [
                'contentId' => $view->getContent()->id,
                'locationId' => $view->getLocation()->id,
            ]);
        }

        return null;
    }
}
