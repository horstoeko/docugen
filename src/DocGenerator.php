<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen;

use horstoeko\docugen\config\DocGeneratorConfig;
use horstoeko\docugen\model\DocGeneratorOutputModel;
use horstoeko\docugen\builder\DocGeneratorDocumentationBuilder;

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
     * Build documentations
     *
     * @return DocGenerator
     */
    public function build(): DocGenerator
    {
        $this->generateAllDocumentations();

        return $this;
    }

    /**
     * Build all documentations
     *
     * @return DocGenerator
     */
    public function generateAllDocumentations(): DocGenerator
    {
        $this->getDocGeneratorConfig()->getOutputs()->each(
            function (DocGeneratorOutputModel $docGeneratorOutputModel): void {
                $this->generateSingleDocumentations($docGeneratorOutputModel);
            }
        );

        return $this;
    }

    /**
     * Build a single documentation
     *
     * @param  DocGeneratorOutputModel $docGeneratorOutputModel
     * @return DocGenerator
     */
    protected function generateSingleDocumentations(DocGeneratorOutputModel $docGeneratorOutputModel): DocGenerator
    {
        DocGeneratorDocumentationBuilder::factory(
            $docGeneratorOutputModel,
            $this->getDocGeneratorConfig()
        )->build();

        return $this;
    }
}
