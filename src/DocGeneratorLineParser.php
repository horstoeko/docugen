<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen;

use horstoeko\docugen\DocGeneratorConfig;

/**
 * Class representing a line parser
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorLineParser
{
    /**
     * The creator config
     *
     * @var DocGeneratorConfig
     */
    protected $docGeneratorConfig;

    /**
     * Output buffer
     *
     * @var DocGeneratorOutputBuffer
     */
    private $docGeneratorOutputBuffer;

    /**
     * Create a new instance
     *
     * @return DocGeneratorLineParser
     */
    public static function factory(DocGeneratorConfig $docGeneratorConfig, DocGeneratorOutputBuffer $docGeneratorOutputBuffer): DocGeneratorLineParser
    {
        return new static($docGeneratorConfig, $docGeneratorOutputBuffer);
    }

    /**
     * Constructor (hidden)
     *
     * @param  DocGeneratorOutputBuffer $docGeneratorOutputBuffer
     * @return static
     */
    final protected function __construct(DocGeneratorConfig $docGeneratorConfig, DocGeneratorOutputBuffer $docGeneratorOutputBuffer)
    {
        $this->docGeneratorOutputBuffer = $docGeneratorOutputBuffer;
        $this->docGeneratorConfig = $docGeneratorConfig;
    }

    /**
     * Parse a line
     *
     * @param  string $line
     * @return void
     */
    public function parseLine(string $line): void
    {
        if ($this->mustIncludeCodeSnippet($line)) {
            return;
        }

        if ($this->mustIncludeText($line)) {
            return;
        }

        $this->docGeneratorOutputBuffer->addLineToOutputBuffer($line);
    }

    /**
     * Parse code snippted includes
     *
     * @param  mixed $line
     * @return boolean
     */
    protected function mustIncludeCodeSnippet($line): bool
    {
        if (!preg_match('/^@CS:(\w+)(:\d+)?(:\d+)?$/', $line, $matches)) {
            return false;
        }

        $includeCodeSnippetId = $matches[1];
        $includeCodeSnippetModel = $this->docGeneratorConfig->getCodeSnippets()->findById($includeCodeSnippetId);

        if (is_null($includeCodeSnippetModel)) {
            return false;
        }

        $includeCodeSnippetFromLine = isset($matches[2]) ? (int)ltrim($matches[2], ':') : 1;
        $includeCodeSnippetToLine = isset($matches[3]) ? (int)ltrim($matches[3], ':') : count($includeCodeSnippetModel->getLines());

        $lines = array_slice(
            $includeCodeSnippetModel->getLines(),
            $includeCodeSnippetFromLine - 1,
            $includeCodeSnippetToLine - $includeCodeSnippetFromLine + 1
        );

        $this->docGeneratorOutputBuffer->addLinesToOutputBuffer($lines);

        return true;
    }

    /**
     * Parse text includes
     *
     * @param  mixed $line
     * @return boolean
     */
    protected function mustIncludeText($line): bool
    {
        if (!preg_match('/^@TXT:(\w+)(:\d+)?(:\d+)?$/', $line, $matches)) {
            return false;
        }

        $includeTextId = $matches[1];
        $includeTextModel = $this->docGeneratorConfig->getTexts()->findById($includeTextId);

        if (is_null($includeTextModel)) {
            return false;
        }

        $includeTextFromLine = isset($matches[2]) ? (int)ltrim($matches[2], ':') : 1;
        $includeTextToLine = isset($matches[3]) ? (int)ltrim($matches[3], ':') : count($includeTextModel->getLines());

        $lines = array_slice(
            $includeTextModel->getLines(),
            $includeTextFromLine - 1,
            $includeTextToLine - $includeTextFromLine + 1
        );

        do {
            $hasReplacedSomething = false;
            foreach ($lines as $lineKey => $lineValue) {
                $hasReplacedSomething = $hasReplacedSomething || $this->hasReplacedTextPart($lineValue);
                $lines[$lineKey] = $lineValue;
            }
        } while ($hasReplacedSomething);

        $this->docGeneratorOutputBuffer->addLinesToOutputBuffer($lines);

        return true;
    }

    protected function hasReplacedTextPart(&$line): bool
    {
        if (!preg_match('/@TXTPART:(\w+)(:\d+)?/', $line, $matches)) {
            return false;
        }

        $line = preg_replace_callback(
            '/@TXTPART:(\w+)(:\d+)?/',
            function ($matches) {
                $indexWithinLines = isset($matches[2]) ? (int)ltrim($matches[2], ':') : 0;
                $partTextModel = $this->docGeneratorConfig->getTexts()->findById($matches[1]);

                if (is_null($partTextModel)) {
                    return $matches[0];
                }

                if (empty($partTextModel->getLines())) {
                    return $matches[0];
                }

                return trim($partTextModel->getLines()[$indexWithinLines]);
            },
            $line
        );

        return true;
    }
}
