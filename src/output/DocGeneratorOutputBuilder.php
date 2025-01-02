<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\output;

use horstoeko\docugen\DocGeneratorConfig;
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
     * The creator config
     *
     * @var DocGeneratorConfig
     */
    protected $docGeneratorConfig;

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
     * @param  DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder
     * @param  DocGeneratorConfig               $docGeneratorConfig
     * @return DocGeneratorOutputBuilder
     */
    public static function factory(DocGeneratorOutputModel $docGeneratorOutputModel, DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder, DocGeneratorConfig $docGeneratorConfig): DocGeneratorOutputBuilder
    {
        return new static($docGeneratorOutputModel, $docGeneratorDocumentationBuilder, $docGeneratorConfig);
    }

    /**
     * Constructor (hidden)
     *
     * @param  DocGeneratorOutputModel          $docGeneratorOutputModel
     * @param  DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder
     * @param  DocGeneratorConfig               $docGeneratorConfig
     * @return void
     */
    final protected function __construct(DocGeneratorOutputModel $docGeneratorOutputModel, DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder, DocGeneratorConfig $docGeneratorConfig)
    {
        $this->docGeneratorOutputModel = $docGeneratorOutputModel;
        $this->documentationBuilder = $docGeneratorDocumentationBuilder;
        $this->docGeneratorConfig = $docGeneratorConfig;
    }

    /**
     * Build output
     *
     * @return DocGeneratorOutputBuilder
     */
    public function build(): DocGeneratorOutputBuilder
    {
        $outputClassName = sprintf('horstoeko\docugen\output\DocGeneratorOutput%s', ucFirst($this->docGeneratorOutputModel->getOutputType()));

        $this->outputInstance = $outputClassName::factory(
            $this->docGeneratorOutputModel,
            $this->documentationBuilder,
            $this->docGeneratorConfig
        )->build()->writeFile();

        return $this;
    }

    /**
     * Get model of the output
     *
     * @return DocGeneratorOutputModel
     */
    public function getOutputModel(): DocGeneratorOutputModel
    {
        return $this->docGeneratorOutputModel;
    }

    /**
     * Get ID of the output
     *
     * @return string
     */
    public function getOutputId(): string
    {
        return $this->getOutputModel()->getId();
    }
}
