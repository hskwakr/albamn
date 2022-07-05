<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
;

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR12' => true,

        'align_multiline_comment' => true,
        'array_indentation' => true,
    ])
    ->setFinder($finder)
;

