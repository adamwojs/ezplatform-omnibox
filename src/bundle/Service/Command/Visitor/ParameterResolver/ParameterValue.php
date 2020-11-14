<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor\ParameterResolver;

use eZ\Publish\API\Repository\Values\ValueObject;

final class ParameterValue
{
    /** @var string */
    private $label;

    /** @var ValueObject */
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
