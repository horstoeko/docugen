<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\output;

use horstoeko\docugen\model\DocGeneratorOutputModel;
use horstoeko\docugen\documentation\DocGeneratorDocumentationBuilder;

/**
 * Class representing the generator for a single documentation
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorOutputBuilder
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
     * Output instance
     *
     * @var DocGeneratorOutputAbstract
     */
    protected $outputInstance;

    /**
     * Create a new instance
     *
     * @param  DocGeneratorOutputModel          $docGeneratorOutputModel
     * @param  DocGeneratorDocumentationBuilder $documentationBuilder
     * @return DocGeneratorOutputBuilder
     */
    public static function factory(DocGeneratorOutputModel $docGeneratorOutputModel, DocGeneratorDocumentationBuilder $documentationBuilder): DocGeneratorOutputBuilder
    {
        return new static($docGeneratorOutputModel, $documentationBuilder);
    }

    /**
     * Constructor (hidden)
     *
     * @param  DocGeneratorOutputModel          $docGeneratorOutputModel
     * @param  DocGeneratorDocumentationBuilder $documentationBuilder
     * @return void
     */
    final protected function __construct(DocGeneratorOutputModel $docGeneratorOutputModel, DocGeneratorDocumentationBuilder $documentationBuilder)
    {
        $this->docGeneratorOutputModel = $docGeneratorOutputModel;
        $this->documentationBuilder = $documentationBuilder;
    }

    /**
     * Build output
     *
     * @return DocGeneratorOutputBuilder
     */
    public function build(): DocGeneratorOutputBuilder
    {
        $outputClassName = sprintf('horstoeko\docugen\output\DocGeneratorOutput%s', ucFirst($this->docGeneratorOutputModel->getOutputType()));

        $this->outputInstance = $outputClassName::factory($this->docGeneratorOutputModel, $this->documentationBuilder)->build();

        return $this;
    }

    /**
     * Returns the output model
     *
     * @return DocGeneratorOutputModel
     */
    public function getOutputModel(): DocGeneratorOutputModel
    {
        return $this->docGeneratorOutputModel;
    }

    /**
     * Get the ID of the output definition
     *
     * @return string
     */
    public function getOutputId(): string
    {
        return $this->getOutputModel()->getId();
    }

    /**
     * Get the output instance (object)
     *
     * @return DocGeneratorOutputAbstract
     */
    public function getOutputInstance(): DocGeneratorOutputAbstract
    {
        return $this->outputInstance;
    }

    /**
     * Get the lines to output
     *
     * @return array<string>
     */
    public function getRenderedLines(): array
    {
        return $this->getOutputInstance()->getRenderedLines();
    }
}
