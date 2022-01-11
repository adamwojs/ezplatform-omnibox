<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA;

final class TextState extends State
{
    /** @var string */
    private $text;

    public function __construct(string $text, ?State $parent = null)
    {
        parent::__construct($parent);

        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function equalsTo(State $state): bool
    {
        if ($this === $state) {
            return true;
        }

        if ($state instanceof TextState) {
            return mb_strtolower($this->getText()) === mb_strtolower($state->getText());
        }

        return false;
    }
}
