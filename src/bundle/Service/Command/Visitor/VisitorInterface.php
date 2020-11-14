<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service\Command\Visitor;

use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\AcceptState;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\ParameterState;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\DFA;
use AdamWojs\EzPlatformOmniboxBundle\Service\Command\DFA\TextState;

interface VisitorInterface
{
    public function visitRootNode(DFA $node);

    public function visitTextNode(TextState $node);

    public function visitParameterNode(ParameterState $node);

    public function visitAcceptNode(AcceptState $node);
}
