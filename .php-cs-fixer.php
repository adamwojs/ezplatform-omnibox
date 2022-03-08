<?php

return (new Ibexa\CodeStyle\PhpCsFixer\Config())
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__ . '/src')
            ->exclude([
                'bin/.travis',
                'doc',
                'vendor',
            ])
            ->files()->name('*.php')
    )
;
