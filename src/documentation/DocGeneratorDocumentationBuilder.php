<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\documentation;

use horstoeko\docugen\DocGeneratorConfig;
use horstoeko\docugen\model\DocGeneratorOutputModel;
use horstoeko\docugen\block\DocGeneratorBlockBuilder;
use horstoeko\docugen\output\DocGeneratorOutputBuilder;
use horstoeko\docugen\model\DocGeneratorDocumentationModel;
use horstoeko\docugen\expression\DocGeneratorExpressionLanguage;

/**
 * Class representing the generator for a single documentation
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorDocumentationBuilder
{
    /**
     * The documentation to handle
     *
     * @var DocGeneratorDocumentationModel
     */
    private $docGeneratorDocumentationModel;

    /**
     * The associated output model
     *
     * @var DocGeneratorOutputModel
     */
    private $docGeneratorOutputModel;

    /**
     * The creator config
     *
     * @var DocGeneratorConfig
     */
    private $docGeneratorConfig;

    /**
     * Blocks collected
     *
     * @var array<DocGeneratorBlockBuilder>
     */
    private $docGeneratorBlockBuilders = [];

    /**
     * Create a new instance
     *
     * @return DocGeneratorDocumentationBuilder
     */
    public static function factory(DocGeneratorDocumentationModel $docGeneratorDocumentationModel, DocGeneratorOutputModel $docGeneratorOutputModel, DocGeneratorConfig $docGeneratorConfig): DocGeneratorDocumentationBuilder
    {
        return new static($docGeneratorDocumentationModel, $docGeneratorOutputModel, $docGeneratorConfig);
    }

    /**
     * Constructor (hidden)
     *
     * @param  DocGeneratorDocumentationModel $docGeneratorDocumentationModel
     * @return static
     */
    final protected function __construct(DocGeneratorDocumentationModel $docGeneratorDocumentationModel, DocGeneratorOutputModel $docGeneratorOutputModel, DocGeneratorConfig $docGeneratorConfig)
    {
        $this->docGeneratorDocumentationModel = $docGeneratorDocumentationModel;
        $this->docGeneratorOutputModel = $docGeneratorOutputModel;
        $this->docGeneratorConfig = $docGeneratorConfig;
    }

    /**
     * Returns the associated documentation model
     *
     * @return DocGeneratorDocumentationModel
     */
    public function getDocGeneratorDocumentationModel(): DocGeneratorDocumentationModel
    {
        return $this->docGeneratorDocumentationModel;
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
     * Returns the global configuration
     *
     * @return DocGeneratorConfig
     */
    public function getDocGeneratorConfig(): DocGeneratorConfig
    {
        return $this->docGeneratorConfig;
    }

    /**
     * Get all blocks in this documentation
     *
     * @return array<DocGeneratorBlockBuilder>
     */
    public function getDocGeneratorBlockBuilders(): array
    {
        return $this->docGeneratorBlockBuilders;
    }

    /**
     * Generate the documentation
     *
     * @return DocGeneratorDocumentationBuilder
     */
    public function build(): DocGeneratorDocumentationBuilder
    {
        $docGeneratorBlockModels =
            array_map(
                function ($docGeneratorBlockModelId) {
                    return $this->getDocGeneratorConfig()->getBlocks()->findByIdOrFail($docGeneratorBlockModelId);
                },
                $this->docGeneratorDocumentationModel->getBlocks()
            );

        $docGeneratorBlockModels =
            array_filter(
                $docGeneratorBlockModels,
                function ($docGeneratorBlockModel) {
                    if ($docGeneratorBlockModel->hasVisibleExpression() === false) {
                        return true;
                    }

                    $docGeneratorExpressionLanguage = DocGeneratorExpressionLanguage::factory();
                    $docGeneratorExpressionLanguage->addVariable("documentationmodel", $this->getDocGeneratorDocumentationModel());
                    $docGeneratorExpressionLanguage->addVariable("blockmodel", $docGeneratorBlockModel);
                    $docGeneratorExpressionLanguage->addVariable("outputmodel", $this->getDocGeneratorOutputModel());
                    $docGeneratorExpressionLanguage->addVariable("config", $this->getDocGeneratorConfig());

                    return $docGeneratorExpressionLanguage->evaluatesToBooleanTrue($docGeneratorBlockModel->getVisibleExpression());
                }
            );

        foreach ($docGeneratorBlockModels as $docGeneratorBlockModel) {
            $this->docGeneratorBlockBuilders[] = DocGeneratorBlockBuilder::factory(
                $docGeneratorBlockModel,
                $this
            )->build();
        }

        DocGeneratorOutputBuilder::factory(
            $this->getDocGeneratorOutputModel(),
            $this
        )->build()->writeFile();

        return $this;
    }
}
