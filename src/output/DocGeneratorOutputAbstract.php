<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\output;

use horstoeko\docugen\DocGeneratorConfig;
use horstoeko\docugen\DocGeneratorOutputBuffer;
use horstoeko\docugen\block\DocGeneratorBlockCode;
use horstoeko\docugen\model\DocGeneratorOutputModel;
use horstoeko\docugen\block\DocGeneratorBlockComment;
use horstoeko\docugen\documentation\DocGeneratorDocumentationBuilder;
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
    protected $docGeneratorOutputModel;

    /**
     * List of generated documentations
     *
     * @var DocGeneratorDocumentationBuilder
     */
    protected $documentationBuilder;

    /**
     * The global config
     *
     * @var DocGeneratorConfig
     */
    protected $docGeneratorConfig;

    /**
     * Output buffer
     *
     * @var DocGeneratorOutputBuffer
     */
    protected $docGeneratorOutputBuffer;

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
        $this->documentationBuilder = $docGeneratorDocumentationBuilder;
        $this->docGeneratorConfig = $docGeneratorConfig;
        $this->docGeneratorOutputBuffer = DocGeneratorOutputBuffer::factory();
    }

    /**
     * Build output
     *
     * @return DocGeneratorOutputAbstract
     */
    public function build(): DocGeneratorOutputAbstract
    {
        $this->beforeAllBlocks();

        foreach ($this->documentationBuilder->getBlocks() as $block) {
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
                    $this->docGeneratorConfig->getRootDirectory(),
                    $this->docGeneratorOutputModel->getFilePath()
                ),
                $this->docGeneratorOutputModel->getFileName()
            );

        file_put_contents(
            $filenameToOutput,
            implode(PHP_EOL, $this->docGeneratorOutputBuffer->getLines())
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
