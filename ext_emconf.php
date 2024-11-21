<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Prevent language packs download',
    'description' => 'Prevent language packs download for configurable extension keys',
    'category' => 'misc',
    'author' => 'Chris Müller',
    'author_email' => 'typo3@brotkrueml.dev',
    'state' => 'stable',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => ['Brotkrueml\\PreventLangPacksDownload\\' => 'Classes']
    ],
];
