<?php

return Ibexa\CodeStyle\PhpCsFixer\InternalConfigFactory::build()
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
