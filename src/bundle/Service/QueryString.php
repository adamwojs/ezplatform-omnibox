<?php

declare(strict_types=1);

namespace AdamWojs\EzPlatformOmniboxBundle\Service;

use Symfony\Component\String\AbstractString;
use function Symfony\Component\String\s;

final class QueryString
{
    /** @var AbstractString */
    private $query;

    public function __construct(string $query)
    {
        $this->query = $this->normalize(s($query));
    }

    public function toString(): string
    {
        return $this->query->toString();
    }

    public function isEmpty(): bool
    {
        return $this->query->isEmpty();
    }

    public function isPrefixOf(string $haystack): bool
    {
        return s($haystack)->lower()->startsWith($this->query);
    }

    public function hasCommonPrefixWith(string $str): bool
    {
        return $this->getCommonPrefixLengthWith($str) > 0;
    }

    public function getCommonPrefixLengthWith(string $str): int
    {
        if ($str === '' | $this->query->isEmpty()) {
            return 0;
        }

        $a = $this->query->chunk();
        $b = $this->normalize(s($str))->chunk();

        $c = min(count($a), count($b));
        for ($i = 0; $i < $c; ++$i) {
            if (!$a[$i]->equalsTo($b[$i])) {
                break;
            }
        }

        return $i;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    private function normalize(AbstractString $string): AbstractString
    {
        return $string->trim()->lower();
    }
}
