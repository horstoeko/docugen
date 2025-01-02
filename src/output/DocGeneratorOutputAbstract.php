<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\output;

use horstoeko\docugen\block\DocGeneratorBlockCode;
use horstoeko\docugen\block\DocGeneratorBlockComment;
use horstoeko\docugen\DocGeneratorConfig;
use horstoeko\docugen\DocGeneratorOutputBuffer;
use horstoeko\docugen\documentation\DocGeneratorDocumentationBuilder;
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
     * The output definition model
     *
     * @var DocGeneratorOutputModel
     */
    private $docGeneratorOutputModel;

    /**
     * List of generated documentations
     *
     * @var DocGeneratorDocumentationBuilder
     */
    private $docGeneratorDocumentationBuilder;

    /**
     * The global config
     *
     * @var DocGeneratorConfig
     */
    private $docGeneratorConfig;

    /**
     * Output buffer
     *
     * @var DocGeneratorOutputBuffer
     */
    private $docGeneratorOutputBuffer;

    /**
     * Create a new instance
     *
     * @param  DocGeneratorOutputModel          $docGeneratorOutputModel
     * @param  DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder
     * @return DocGeneratorOutputAbstract
     */
    public static function factory(DocGeneratorOutputModel $docGeneratorOutputModel, DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder, DocGeneratorConfig $docGeneratorConfig): DocGeneratorOutputAbstract
    {
        return new static($docGeneratorOutputModel, $docGeneratorDocumentationBuilder, $docGeneratorConfig);
    }

    /**
     * Constructor (hidden)
     *
     * @param DocGeneratorOutputModel          $docGeneratorOutputModel
     * @param DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder
     */
    final protected function __construct(DocGeneratorOutputModel $docGeneratorOutputModel, DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder, DocGeneratorConfig $docGeneratorConfig)
    {
        $this->docGeneratorOutputModel = $docGeneratorOutputModel;
        $this->docGeneratorDocumentationBuilder = $docGeneratorDocumentationBuilder;
        $this->docGeneratorConfig = $docGeneratorConfig;
        $this->docGeneratorOutputBuffer = DocGeneratorOutputBuffer::factory();
    }

    /**
     * Returns the associated output model
     *
     * @return DocGeneratorOutputModel
     */
    public function getDocGeneratorOutputModel(): DocGeneratorOutputModel
    {
        return $this->docGeneratorOutputModel;
    }

    /**
     * Returns the associated document builder
     *
     * @return DocGeneratorDocumentationBuilder
     */
    public function getDocGeneratorDocumentationBuilder(): DocGeneratorDocumentationBuilder
    {
        return $this->docGeneratorDocumentationBuilder;
    }

    /**
     * Returns the global configuration
     *
     * @return DocGeneratorConfig
     */
    public function getDocGeneratorConfig(): DocGeneratorConfig
    {
        return $this->docGeneratorConfig;
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
     * Build output
     *
     * @return DocGeneratorOutputAbstract
     */
    public function build(): DocGeneratorOutputAbstract
    {
        $this->beforeAllBlocks();

        foreach ($this->getDocGeneratorDocumentationBuilder()->getDocGeneratorBlockBuilders() as $block) {
            switch (true) {
                case $block->getBlockInstance() instanceof DocGeneratorBlockComment:
                    $this->renderComment($block->getBlockInstance());
                    break;
                case $block->getBlockInstance() instanceof DocGeneratorBlockCode:
                    $this->renderCode($block->getBlockInstance());
                    break;
            }
        }

        $this->afterAllBlocks();

        return $this;
    }

    /**
     * Write the output to a file
     *
     * @return DocGeneratorOutputAbstract
     */
    public function writeFile(): DocGeneratorOutputAbstract
    {
        $filenameToOutput =
            PathUtils::combinePathWithFile(
                PathUtils::combinePathWithPath(
                    $this->getDocGeneratorConfig()->getRootDirectory(),
                    $this->getDocGeneratorOutputModel()->getFilePath()
                ),
                $this->getDocGeneratorOutputModel()->getFileName()
            );

        file_put_contents(
            $filenameToOutput,
            implode(PHP_EOL, $this->getDocGeneratorOutputBuffer()->getLines())
        );

        return $this;
    }

    /**
     * Render a comment block
     *
     * @return void
     */
    abstract protected function renderComment(DocGeneratorBlockComment $docGeneratorBlockComment): void;

    /**
     * Render a code block
     *
     * @return void
     */
    abstract protected function renderCode(DocGeneratorBlockCode $docGeneratorBlockCode): void;

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
