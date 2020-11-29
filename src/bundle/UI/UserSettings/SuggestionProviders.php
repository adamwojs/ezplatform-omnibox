<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\UI\UserSettings;

use AdamWojs\EzPlatformOmniboxBundle\Form\Transformer\StringToArrayTransformer;
use AdamWojs\EzPlatformOmniboxBundle\Form\Type\SuggestionProviderChoiceType;
use EzSystems\EzPlatformUser\UserSetting\FormMapperInterface;
use EzSystems\EzPlatformUser\UserSetting\ValueDefinitionInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class SuggestionProviders implements ValueDefinitionInterface, FormMapperInterface
{
    private const STORAGE_VALUE_DELIMITER = ',';

    /** @var \Symfony\Contracts\Translation\TranslatorInterface */
    private $translator;

    /**
     * @param \Symfony\Contracts\Translation\TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getName(): string
    {
        return $this->getTranslatedName();
    }

    public function getDescription(): string
    {
        return $this->getTranslatedDescription();
    }

    public function getDisplayValue(string $storageValue): string
    {
        $labels = [];
        foreach (explode(self::STORAGE_VALUE_DELIMITER, $storageValue) as $value) {
            $labels[] = $this->translator->trans(
                /** @Ignore */
                'settings.suggestion_providers.value.' . $value,
                [],
                'user_settings'
            );
        }

        return implode(', ', $labels);
    }

    public function getDefaultValue(): string
    {
        return '';
    }

    public function mapFieldForm(FormBuilderInterface $formBuilder, ValueDefinitionInterface $value): FormBuilderInterface
    {
        $form = $formBuilder->create(
            'value',
            SuggestionProviderChoiceType::class,
            [
                'label' => $this->getDescription(),
                'expanded' => true,
                'multiple' => true,
            ]
        );

        $form->addModelTransformer(new StringToArrayTransformer(self::STORAGE_VALUE_DELIMITER));

        return $form;
    }

    private function getTranslatedName(): string
    {
        return $this->translator->trans(
            /** @Desc("Suggestion providers") */
            'settings.suggestion_providers.value.title',
            [],
            'user_settings'
        );
    }

    private function getTranslatedDescription(): string
    {
        return $this->translator->trans(
            /** @Desc("Enabled suggestion providers") */
            'settings.suggestion_providers.value.description',
            [],
            'user_settings'
        );
    }
}
