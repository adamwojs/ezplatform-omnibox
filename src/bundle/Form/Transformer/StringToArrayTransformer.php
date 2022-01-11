<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;

final class StringToArrayTransformer implements DataTransformerInterface
{
    /** @var string */
    private $delimiter;

    public function __construct(string $separator)
    {
        $this->delimiter = $separator;
    }

    public function transform($value): ?array
    {
        if ($value === null) {
            return null;
        }

        return explode($this->delimiter, $value);
    }

    public function reverseTransform($value): ?string
    {
        if ($value === null) {
            return null;
        }

        return implode($this->delimiter, $value);
    }
}
