<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\UI\ConfigProvider\SuggestionContextResolver;

use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionContext;
use AdamWojs\EzPlatformOmniboxBundle\UI\ConfigProvider\SuggestionContextResolverInterface;
use Ibexa\Core\MVC\Symfony\View\ContentView;
use Symfony\Component\HttpFoundation\RequestStack;

final class ContentViewSuggestionContextResolver implements SuggestionContextResolverInterface
{
    /** @var \Symfony\Component\HttpFoundation\RequestStack */
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
