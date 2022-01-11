<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\ParameterResolver;

use Ibexa\Contracts\Core\Repository\Values\ValueObject;

final class ParameterValue
{
    /** @var string */
    private $label;

    /** @var \Ibexa\Contracts\Core\Repository\Values\ValueObject */
    private $value;

    public function __construct(string $label, ValueObject $value)
    {
        $this->label = $label;
        $this->value = $value;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getValue(): ValueObject
    {
        return $this->value;
    }
}
