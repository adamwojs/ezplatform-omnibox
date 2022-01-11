<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA;

final class AcceptState extends State
{
    /** @var string|null */
    private $label;

    public function __construct(?string $label = null, ?State $parent = null)
    {
        parent::__construct($parent);

        $this->label = $label;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function equalsTo(State $state): bool
    {
        if ($this === $state) {
            return true;
        }

        if ($state instanceof AcceptState) {
            return $this->label === $state->label;
        }

        return false;
    }
}
