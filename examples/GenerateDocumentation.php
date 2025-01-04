<?php

use horstoeko\docugen\DocGenerator;
use horstoeko\docugen\DocGeneratorConfig;

require_once __DIR__ . "/../vendor/autoload.php";

$config = DocGeneratorConfig::loadFromFile(__DIR__ . '/config2.json');

$generator = DocGenerator::factory($config)->build();

/*
foreach ($generator->getDocumentations() as $documentation) {
    foreach ($documentation->getBlocks() as $block) {
        echo get_class($block) . PHP_EOL;
        foreach($block->getLines() as $line) {
            echo $line . PHP_EOL;
        }
    }
}
*/

//print_r($generator->getDocumentationOutputs()[0]->getRenderedLines());
