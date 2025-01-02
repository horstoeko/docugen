<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen;

use horstoeko\docugen\model\DocGeneratorOutputModel;
use horstoeko\docugen\output\DocGeneratorOutputBuilder;
use horstoeko\docugen\model\DocGeneratorDocumentationModel;
use horstoeko\docugen\documentation\DocGeneratorDocumentationBuilder;

/**
 * Class representing the documentation generator
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGenerator
{
    /**
     * The configuration for the documentation generator
     *
     * @var DocGeneratorConfig
     */
    private $docGeneratorConfig;

    /**
     * List of generated documentations
     *
     * @var array<DocGeneratorDocumentationBuilder>
     */
    private $documentations = [];

    /**
     * List of generated outputs
     *
     * @var array<DocGeneratorOutputBuilder>
     */
    private $documentationOutputs = [];

    /**
     * Instanciate the documentation generator
     *
     * @param  DocGeneratorConfig $docGeneratorConfig
     * @return DocGenerator
     */
    public static function factory(DocGeneratorConfig $docGeneratorConfig): DocGenerator
    {
        return new DocGenerator($docGeneratorConfig);
    }

    /**
     * Constructor
     *
     * @param  DocGeneratorConfig $docGeneratorConfig
     * @return void
     */
    final protected function __construct(DocGeneratorConfig $docGeneratorConfig)
    {
        $this->docGeneratorConfig = $docGeneratorConfig;
    }

    /**
     * Build and output all documentations
     *
     * @return DocGenerator
     */
    public function build(): DocGenerator
    {
        $this->generateAllDocumentations();
        $this->outputAllDocumentations();

        return $this;
    }

    /**
     * Generate each defined documentation
     *
     * @return DocGenerator
     */
    private function generateAllDocumentations(): DocGenerator
    {
        $this->documentations = [];

        $this->docGeneratorConfig->getDocumentations()->each(
            function (DocGeneratorDocumentationModel $docGeneratorDocumentationModel): void {
                $this->generateSingleDocumentation($docGeneratorDocumentationModel);
            }
        );

        return $this;
    }

    /**
     * Generate a single documentation
     *
     * @param  DocGeneratorDocumentationModel $docGeneratorDocumentationModel
     * @return DocGenerator
     */
    private function generateSingleDocumentation(DocGeneratorDocumentationModel $docGeneratorDocumentationModel): DocGenerator
    {
        $this->documentations[] = DocGeneratorDocumentationBuilder::factory($docGeneratorDocumentationModel, $this->docGeneratorConfig)->build();

        return $this;
    }

    /**
     * Generate each defined output
     *
     * @return DocGenerator
     */
    private function outputAllDocumentations(): DocGenerator
    {
        $this->documentationOutputs = [];

        $this->docGeneratorConfig->getOutputs()->each(
            function (DocGeneratorOutputModel $docGeneratorOutputModel): void {
                $this->outputSingleDocumentation($docGeneratorOutputModel);
            }
        );

        return $this;
    }

    /**
     * Generate a single output
     *
     * @param  DocGeneratorOutputModel $docGeneratorOutputModel
     * @return DocGenerator
     */
    private function outputSingleDocumentation(DocGeneratorOutputModel $docGeneratorOutputModel): DocGenerator
    {
        $docGeneratorDocumentationBuilder = array_filter(
            $this->documentations,
            function (DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder) use ($docGeneratorOutputModel) {
                return $docGeneratorDocumentationBuilder->getDocumentationId() === $docGeneratorOutputModel->getDocumentationId();
            }
        );

        $docGeneratorDocumentationBuilder = reset($docGeneratorDocumentationBuilder);

        if ($docGeneratorDocumentationBuilder === false) {
            return $this;
        }

        $this->documentationOutputs[] = DocGeneratorOutputBuilder::factory($docGeneratorOutputModel, $docGeneratorDocumentationBuilder)->build();

        return $this;
    }

    /**
     * Get all documentations
     *
     * @return array<DocGeneratorDocumentationBuilder>
     */
    public function getAllRenderedDocumentations(): array
    {
        return $this->documentations;
    }

    /**
     * Get all documentation outputs
     *
     * @return array<DocGeneratorOutputBuilder>
     */
    public function getDocumentationOutputs(): array
    {
        return $this->documentationOutputs;
    }
}
