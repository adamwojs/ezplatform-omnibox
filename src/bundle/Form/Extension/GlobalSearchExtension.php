<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Form\Extension;

use Ibexa\AdminUi\Form\Type\Search\GlobalSearchType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class GlobalSearchExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('query', TextType::class, [
            'required' => false,
            'attr' => [
                'data-enable-omnibox' => true,
            ],
        ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [GlobalSearchType::class];
    }
}
