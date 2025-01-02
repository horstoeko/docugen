<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\output;

use horstoeko\docugen\DocGeneratorOutputBuffer;
use horstoeko\docugen\block\DocGeneratorBlockCode;
use horstoeko\docugen\model\DocGeneratorOutputModel;
use horstoeko\docugen\block\DocGeneratorBlockComment;
use horstoeko\docugen\documentation\DocGeneratorDocumentationBuilder;

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
     * Output buffer
     *
     * @var DocGeneratorOutputBuffer
     */
    protected $docGeneratorOutputBuffer;

    /**
     * Create a new instance
     *
     * @param  DocGeneratorOutputModel          $docGeneratorOutputModel
     * @param  DocGeneratorDocumentationBuilder $documentationBuilder
     * @return DocGeneratorOutputAbstract
     */
    public static function factory(DocGeneratorOutputModel $docGeneratorOutputModel, DocGeneratorDocumentationBuilder $documentationBuilder): DocGeneratorOutputAbstract
    {
        return new static($docGeneratorOutputModel, $documentationBuilder);
    }

    /**
     * Constructor (hidden)
     *
     * @param DocGeneratorOutputModel          $docGeneratorOutputModel
     * @param DocGeneratorDocumentationBuilder $documentationBuilder
     */
    final protected function __construct(DocGeneratorOutputModel $docGeneratorOutputModel, DocGeneratorDocumentationBuilder $documentationBuilder)
    {
        $this->docGeneratorOutputModel = $docGeneratorOutputModel;
        $this->documentationBuilder = $documentationBuilder;
        $this->docGeneratorOutputBuffer = DocGeneratorOutputBuffer::factory();
    }

    /**
     * Build output
     *
     * @return DocGeneratorOutputAbstract
     */
    public function build(): DocGeneratorOutputAbstract
    {
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
     * Get the lines to output
     *
     * @return array<string>
     */
    public function getRenderedLines(): array
    {
        return $this->docGeneratorOutputBuffer->getLines();
    }
}
