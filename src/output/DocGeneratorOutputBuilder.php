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
    private $docGeneratorOutputModel;

    /**
     * List of generated documentations
     *
     * @var DocGeneratorDocumentationBuilder
     */
    private $docGeneratorDocumentationBuilder;

    /**
     * The creator config
     *
     * @var DocGeneratorConfig
     */
    private $docGeneratorConfig;

    /**
     * Output instance
     *
     * @var DocGeneratorOutputAbstract
     */
    private $docGeneratorOutputAbstract;

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
        $this->docGeneratorDocumentationBuilder = $docGeneratorDocumentationBuilder;
        $this->docGeneratorConfig = $docGeneratorConfig;
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
     * Get the block instance (object)
     *
     * @return DocGeneratorOutputAbstract
     */
    public function getOutputInstance(): DocGeneratorOutputAbstract
    {
        return $this->docGeneratorOutputAbstract;
    }

    /**
     * Generate a single output
     *
     * @return DocGeneratorOutputBuilder
     */
    public function build(): DocGeneratorOutputBuilder
    {
        $outputClassName =
            sprintf(
                'horstoeko\docugen\output\DocGeneratorOutput%s',
                ucFirst($this->getDocGeneratorOutputModel()->getOutputType())
            );

        $this->docGeneratorOutputAbstract =
            $outputClassName::factory(
                $this->getDocGeneratorOutputModel(),
                $this->getDocGeneratorDocumentationBuilder(),
                $this->getDocGeneratorConfig()
            )->build()->writeFile();

        return $this;
    }
}
