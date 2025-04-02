<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\output;

use horstoeko\docugen\block\DocGeneratorBlockBlank;
use horstoeko\docugen\block\DocGeneratorBlockBuilder;
use horstoeko\docugen\block\DocGeneratorBlockCode;
use horstoeko\docugen\block\DocGeneratorBlockComment;
use horstoeko\docugen\DocGeneratorConfig;
use horstoeko\docugen\DocGeneratorOutputBuffer;
use horstoeko\docugen\documentation\DocGeneratorDocumentationBuilder;
use horstoeko\docugen\model\DocGeneratorDocumentationModel;
use horstoeko\docugen\model\DocGeneratorOutputModel;
use horstoeko\stringmanagement\PathUtils;

/**
 * Class representing the abstract outputter
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
abstract class DocGeneratorOutputAbstract
{
    /**
     * The calling output builder
     *
     * @var DocGeneratorOutputBuilder
     */
    private $docGeneratorOutputBuilder;

    /**
     * Output buffer
     *
     * @var DocGeneratorOutputBuffer
     */
    private $docGeneratorOutputBuffer;

    /**
     * Create a new instance
     *
     * @param  DocGeneratorOutputBuilder $docGeneratorOutputBuilder
     * @return DocGeneratorOutputAbstract
     */
    public static function factory(DocGeneratorOutputBuilder $docGeneratorOutputBuilder): DocGeneratorOutputAbstract
    {
        return new static($docGeneratorOutputBuilder);
    }

    /**
     * Constructor (hidden)
     *
     * @param DocGeneratorOutputBuilder $docGeneratorOutputBuilder
     */
    final protected function __construct(DocGeneratorOutputBuilder $docGeneratorOutputBuilder)
    {
        $this->docGeneratorOutputBuilder = $docGeneratorOutputBuilder;
        $this->docGeneratorOutputBuffer = DocGeneratorOutputBuffer::factory();
    }

    /**
     * Returns the associated output builder
     *
     * @return DocGeneratorOutputBuilder
     */
    public function getDocGeneratorOutputBuilder(): DocGeneratorOutputBuilder
    {
        return $this->docGeneratorOutputBuilder;
    }

    /**
     * Returns the internal output buffer
     *
     * @return DocGeneratorOutputBuffer
     */
    public function getDocGeneratorOutputBuffer(): DocGeneratorOutputBuffer
    {
        return $this->docGeneratorOutputBuffer;
    }

    /**
     * Returns the associated document builder
     *
     * @return DocGeneratorDocumentationBuilder
     */
    public function getDocGeneratorDocumentationBuilder(): DocGeneratorDocumentationBuilder
    {
        return $this->getDocGeneratorOutputBuilder()->getDocGeneratorDocumentationBuilder();
    }

    /**
     * Returns the associated output model
     *
     * @return DocGeneratorOutputModel
     */
    public function getDocGeneratorOutputModel(): DocGeneratorOutputModel
    {
        return $this->getDocGeneratorOutputBuilder()->getDocGeneratorOutputModel();
    }

    /**
     * Returns the documentation model
     *
     * @return DocGeneratorDocumentationModel
     */
    public function getDocGeneratorDocumentationModel(): DocGeneratorDocumentationModel
    {
        return $this->getDocGeneratorDocumentationBuilder()->getDocGeneratorDocumentationModel();
    }

    /**
     * Returns the list of documentation blocks
     *
     * @return array<DocGeneratorBlockBuilder>
     */
    public function getDocGeneratorBlockBuilders(): array
    {
        return $this->getDocGeneratorDocumentationBuilder()->getDocGeneratorBlockBuilders();
    }

    /**
     * Returns the global configuration
     *
     * @return DocGeneratorConfig
     */
    public function getDocGeneratorConfig(): DocGeneratorConfig
    {
        return $this->getDocGeneratorDocumentationBuilder()->getDocGeneratorConfig();
    }

    /**
     * Build output
     *
     * @return DocGeneratorOutputAbstract
     */
    public function build(): DocGeneratorOutputAbstract
    {
        $this->beforeAllBlocks();

        foreach ($this->getDocGeneratorBlockBuilders() as $docGeneratorBlockBuilder) {
            if ($docGeneratorBlockBuilder->getBlockInstance() instanceof DocGeneratorBlockComment) {
                $this->renderCommentBlock($docGeneratorBlockBuilder->getBlockInstance());
            } elseif ($docGeneratorBlockBuilder->getBlockInstance() instanceof DocGeneratorBlockCode) {
                $this->renderCodeBlock($docGeneratorBlockBuilder->getBlockInstance());
            } elseif ($docGeneratorBlockBuilder->getBlockInstance() instanceof DocGeneratorBlockBlank) {
                $this->renderBlankBlock($docGeneratorBlockBuilder->getBlockInstance());
            }
        }

        $this->afterAllBlocks();

        return $this;
    }

    /**
     * Output to a specific destination (see outputdestination property)
     *
     * @return DocGeneratorOutputAbstract
     */
    public function output(): DocGeneratorOutputAbstract
    {
        if ($this->getDocGeneratorOutputModel()->getOutputDestination() === 0) {
            return $this->outputToFile();
        }

        if ($this->getDocGeneratorOutputModel()->getOutputDestination() === 1) {
            return $this->outputToScreen();
        }

        return $this;
    }

    /**
     * Generate the output to a file
     *
     * @return DocGeneratorOutputAbstract
     */
    public function outputToFile(): DocGeneratorOutputAbstract
    {
        $filepath = $this->getDocGeneratorOutputModel()->getFilePathIsAbsolute() ? $this->getDocGeneratorOutputModel()->getFilePath() : PathUtils::combinePathWithPath($this->getDocGeneratorConfig()->getRootDirectory(), $this->getDocGeneratorOutputModel()->getFilePath());

        $filenameToOutput = PathUtils::combinePathWithFile($filepath, $this->getDocGeneratorOutputModel()->getFileName());

        file_put_contents(
            $filenameToOutput,
            implode(PHP_EOL, $this->getDocGeneratorOutputBuffer()->getLines())
        );

        return $this;
    }

    /**
     * Generate the output to STDOUT
     *
     * @return DocGeneratorOutputAbstract
     */
    public function outputToScreen(): DocGeneratorOutputAbstract
    {
        echo implode(PHP_EOL, $this->getDocGeneratorOutputBuffer()->getLines());

        return $this;
    }

    /**
     * Render a comment block
     *
     * @param  DocGeneratorBlockComment $docGeneratorBlockComment
     * @return void
     */
    abstract protected function renderCommentBlock(DocGeneratorBlockComment $docGeneratorBlockComment): void;

    /**
     * Render a code block
     *
     * @param  DocGeneratorBlockCode $docGeneratorBlockCode
     * @return void
     */
    abstract protected function renderCodeBlock(DocGeneratorBlockCode $docGeneratorBlockCode): void;

    /**
     * Render a blank block
     *
     * @param  DocGeneratorBlockBlank $docGeneratorBlockBlank
     * @return void
     */
    abstract protected function renderBlankBlock(DocGeneratorBlockBlank $docGeneratorBlockBlank): void;

    /**
     * Do something before rendering all blocks
     *
     * @return DocGeneratorOutputAbstract
     */
    protected function beforeAllBlocks(): DocGeneratorOutputAbstract
    {
        return $this;
    }

    /**
     * Do something after rendering all blocks
     *
     * @return DocGeneratorOutputAbstract
     */
    protected function afterAllBlocks(): DocGeneratorOutputAbstract
    {
        return $this;
    }
}
