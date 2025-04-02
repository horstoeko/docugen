<?php

use horstoeko\docugen\DocGenerator;
use horstoeko\docugen\DocGeneratorConfig;
use horstoeko\docugen\block\DocGeneratorBlockCode;
use horstoeko\docugen\block\DocGeneratorBlockBlank;
use horstoeko\docugen\block\DocGeneratorBlockComment;
use horstoeko\docugen\output\DocGeneratorOutputAbstract;

require_once __DIR__ . "/../vendor/autoload.php";

class CustomOutputter extends DocGeneratorOutputAbstract
{
    protected function renderCommentBlock(DocGeneratorBlockComment $docGeneratorBlockComment): void
    {
        $this->getDocGeneratorOutputBuffer()->addLinesToOutputBuffer($docGeneratorBlockComment->getRenderedLines());
    }

    protected function renderCodeBlock(DocGeneratorBlockCode $docGeneratorBlockCode): void
    {
        $this->getDocGeneratorOutputBuffer()->addLineToOutputBuffer(sprintf('```%s', $docGeneratorBlockCode->getDocGeneratorBlockModel()->getLanguage()));
        $this->getDocGeneratorOutputBuffer()->addLinesToOutputBuffer($docGeneratorBlockCode->getRenderedLines());
        $this->getDocGeneratorOutputBuffer()->addLineToOutputBuffer('```');
    }

    protected function renderBlankBlock(DocGeneratorBlockBlank $docGeneratorBlockBlank): void
    {
        $this->getDocGeneratorOutputBuffer()->addLinesToOutputBuffer($docGeneratorBlockBlank->getRenderedLines());
    }
}

$config = DocGeneratorConfig::loadFromFile(__DIR__ . '/config2.json');

$generator = DocGenerator::factory($config)->build();
