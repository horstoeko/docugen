<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\output;

use horstoeko\docugen\builder\DocGeneratorDocumentationBuilder;
use horstoeko\docugen\config\DocGeneratorConfig;
use horstoeko\docugen\exception\DocGeneratorUnknownClassException;
use horstoeko\docugen\model\DocGeneratorOutputModel;

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
     * List of generated documentations
     *
     * @var DocGeneratorDocumentationBuilder
     */
    private $docGeneratorDocumentationBuilder;

    /**
     * Output instance
     *
     * @var DocGeneratorOutputAbstract
     */
    private $docGeneratorOutputAbstract;

    /**
     * Create a new instance
     *
     * @param  DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder
     * @return DocGeneratorOutputBuilder
     */
    public static function factory(DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder): DocGeneratorOutputBuilder
    {
        return new static($docGeneratorDocumentationBuilder);
    }

    /**
     * Constructor (hidden)
     *
     * @param  DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder
     * @return void
     */
    final protected function __construct(DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder)
    {
        $this->docGeneratorDocumentationBuilder = $docGeneratorDocumentationBuilder;
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
     * Returns the associated output model
     *
     * @return DocGeneratorOutputModel
     */
    public function getDocGeneratorOutputModel(): DocGeneratorOutputModel
    {
        return $this->getDocGeneratorDocumentationBuilder()->getDocGeneratorOutputModel();
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
        $docGeneratorOutputClassNamespace =
            $this->getDocGeneratorOutputModel()->getOption('classnamespace', 'horstoeko\docugen\output');

        $docGeneratorOutputClassBasename =
            $this->getDocGeneratorOutputModel()->getOption('classnamebase', 'DocGeneratorOutput');

        $docGeneratorOutputClassName =
            sprintf(
                '%s\%s%s',
                $docGeneratorOutputClassNamespace,
                $docGeneratorOutputClassBasename,
                ucFirst($this->getDocGeneratorOutputModel()->getOutputType())
            );

        if (!class_exists($docGeneratorOutputClassName)) {
            throw new DocGeneratorUnknownClassException($docGeneratorOutputClassName);
        }

        $this->docGeneratorOutputAbstract = $docGeneratorOutputClassName::factory($this)->build();

        return $this;
    }

    /**
     * Generate the output as a file
     *
     * @return DocGeneratorOutputBuilder
     */
    public function output(): DocGeneratorOutputBuilder
    {
        $this->getOutputInstance()->output();

        return $this;
    }
}
