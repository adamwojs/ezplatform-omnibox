<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Form\Type;

use AdamWojs\EzPlatformOmniboxBundle\Service\SuggestionProviderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

final class SuggestionProviderChoiceType extends AbstractType
{
    /** @var TranslatorInterface */
    private $translator;

    /** @var SuggestionProviderInterface[] */
    private $providers;

    public function __construct(TranslatorInterface $translator, iterable $providers)
    {
        $this->translator = $translator;
        $this->providers = $providers;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => $this->getDefaultChoices(),
            'choice_label' => function ($choice, $key, $value): string {
                return $this->translator->trans(
                    /** @Ignore */
                    'settings.suggestion_providers.value.' . $value,
                    [],
                    'user_settings'
                );
            },
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    private function getDefaultChoices(): array
    {
        $choices = [];
        foreach ($this->providers as $identifier => $provider) {
            $choices[$identifier] = $identifier;
        }

        return $choices;
    }
}
