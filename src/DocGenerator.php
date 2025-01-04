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
    private $docGeneratorDocumentationBuilders = [];

    /**
     * List of generated outputs
     *
     * @var array<DocGeneratorOutputBuilder>
     */
    private $docGeneratorOutputBuilders = [];

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
     * Returns the global configuration
     *
     * @return DocGeneratorConfig
     */
    public function getDocGeneratorConfig(): DocGeneratorConfig
    {
        return $this->docGeneratorConfig;
    }

    /**
     * Build and output all documentations
     *
     * @return DocGenerator
     */
    public function build(): DocGenerator
    {
        $this->generateAllDocumentations();
        $this->generateAllDocumentationOutputs();
        $this->writeAllDocumentationOutputs();

        return $this;
    }

    /**
     * Generate each defined documentation
     *
     * @return DocGenerator
     */
    private function generateAllDocumentations(): DocGenerator
    {
        $this->docGeneratorDocumentationBuilders = [];

        $this->getDocGeneratorConfig()->getDocumentations()->each(
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
        $this->docGeneratorDocumentationBuilders[] =
            DocGeneratorDocumentationBuilder::factory(
                $docGeneratorDocumentationModel,
                $this->getDocGeneratorConfig()
            )->build();

        return $this;
    }

    /**
     * Generate each defined output
     *
     * @return DocGenerator
     */
    private function generateAllDocumentationOutputs(): DocGenerator
    {
        $this->docGeneratorOutputBuilders = [];

        $this->getDocGeneratorConfig()->getOutputs()->each(
            function (DocGeneratorOutputModel $docGeneratorOutputModel): void {
                $this->generateSingleDocumentationOutput($docGeneratorOutputModel);
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
    private function generateSingleDocumentationOutput(DocGeneratorOutputModel $docGeneratorOutputModel): DocGenerator
    {
        $docGeneratorDocumentationBuilder = array_filter(
            $this->docGeneratorDocumentationBuilders,
            function (DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder) use ($docGeneratorOutputModel) {
                return $docGeneratorDocumentationBuilder->getDocGeneratorDocumentationModel()->isId($docGeneratorOutputModel->getDocumentationId());
            }
        );

        $docGeneratorDocumentationBuilder = reset($docGeneratorDocumentationBuilder);

        if ($docGeneratorDocumentationBuilder === false) {
            return $this;
        }

        $this->docGeneratorOutputBuilders[] =
            DocGeneratorOutputBuilder::factory(
                $docGeneratorOutputModel,
                $docGeneratorDocumentationBuilder
            )->build();

        return $this;
    }

    /**
     * Write each defined output
     *
     * @return DocGenerator
     */
    private function writeAllDocumentationOutputs(): DocGenerator
    {
        foreach ($this->docGeneratorOutputBuilders as $docGeneratorOutputBuilder) {
            $this->writeSingleDocumentationOutput($docGeneratorOutputBuilder);
        }

        return $this;
    }

    /**
     * Write a single defined output
     *
     * @param DocGeneratorOutputBuilder $docGeneratorOutputBuilder
     * @return DocGenerator
     */
    private function writeSingleDocumentationOutput(DocGeneratorOutputBuilder $docGeneratorOutputBuilder): DocGenerator
    {
        $docGeneratorOutputBuilder->getOutputInstance()->writeFile();

        return $this;
    }
}
