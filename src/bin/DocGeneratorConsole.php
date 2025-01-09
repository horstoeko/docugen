<?php

use Composer\InstalledVersions as ComposerInstalledVersions;
use horstoeko\docugen\console\DocGeneratorMakeConsoleCommand;
use Symfony\Component\Console\Application;

$autoloadFiles = [
    __DIR__ . '/../../vendor/autoload.php',
    __DIR__ . '/vendor/autoload.php',
];

foreach ($autoloadFiles as $autoloadFile) {
    if (file_exists($autoloadFile)) {
        include_once $autoloadFile;
        break;
    }
}

$app = new Application('DocGenerator', ComposerInstalledVersions::getVersion('horstoeko/docugen'));
$app->add(new DocGeneratorMakeConsoleCommand());
$app->run();
