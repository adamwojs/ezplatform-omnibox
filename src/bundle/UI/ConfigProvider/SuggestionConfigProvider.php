<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\UI\ConfigProvider;

use AdamWojs\EzPlatformOmniboxBundle\UI\UserSettings\VoiceAssistant;
use Ibexa\Contracts\AdminUi\UI\Config\ProviderInterface;
use Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException;
use Ibexa\Contracts\Core\Repository\UserPreferenceService;

final class SuggestionConfigProvider implements ProviderInterface
{
    /** @var \Ibexa\Contracts\Core\Repository\UserPreferenceService */
    private $userPreferenceService;

    public function __construct(UserPreferenceService $userPreferenceService)
    {
        $this->userPreferenceService = $userPreferenceService;
    }

    public function getConfig(): array
    {
        return [
            'suggestionProviders' => $this->getEnabledSuggestionProvider(),
            'voiceAssistant' => [
                'enabled' => $this->isVoiceAssistantEnabled(),
            ],
        ];
    }

    private function isVoiceAssistantEnabled(): bool
    {
        $value = $this->getUserPreference(
            'voice_assistant',
            VoiceAssistant::DISABLED_OPTION
        );

        return $value === VoiceAssistant::ENABLED_OPTION;
    }

    private function getEnabledSuggestionProvider(): array
    {
        $value = $this->getUserPreference('suggestion_providers');
        if ($value === null) {
            return [];
        }

        return explode(',', $value);
    }

    private function getUserPreference(string $name, $defaultValue = null)
    {
        try {
            return $this->userPreferenceService->getUserPreference($name)->value;
        } catch (NotFoundException $e) {
            return $defaultValue;
        }
    }
}
