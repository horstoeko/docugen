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
use RuntimeException;

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
     * The associated output model
     *
     * @var DocGeneratorOutputModel
     */
    private $docGeneratorOutputModel;

    /**
     * The configuration for the documentation generator
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
     * @param  DocGeneratorOutputModel $docGeneratorOutputModel
     * @param  DocGeneratorConfig      $docGeneratorConfig
     * @return DocGeneratorDocumentationBuilder
     */
    public static function factory(DocGeneratorOutputModel $docGeneratorOutputModel, DocGeneratorConfig $docGeneratorConfig): DocGeneratorDocumentationBuilder
    {
        return new static($docGeneratorOutputModel, $docGeneratorConfig);
    }

    /**
     * Constructor (hidden)
     *
     * @param  DocGeneratorOutputModel $docGeneratorOutputModel
     * @param  DocGeneratorConfig      $docGeneratorConfig
     * @return static
     */
    final protected function __construct(DocGeneratorOutputModel $docGeneratorOutputModel, DocGeneratorConfig $docGeneratorConfig)
    {
        $this->docGeneratorOutputModel = $docGeneratorOutputModel;
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
     * Returns the associated documentation model
     *
     * @return DocGeneratorDocumentationModel
     * @throws RuntimeException
     */
    public function getDocGeneratorDocumentationModel(): DocGeneratorDocumentationModel
    {
        return $this->getDocGeneratorConfig()->getDocumentations()->findByIdOrFail($this->getDocGeneratorOutputModel()->getDocumentationId());
    }

    /**
     * Generate the documentation
     *
     * @return DocGeneratorDocumentationBuilder
     */
    public function build(): DocGeneratorDocumentationBuilder
    {
        $docGeneratorExpressionLanguage = DocGeneratorExpressionLanguage::factory();
        $docGeneratorExpressionLanguage
            ->setVariable("documentationmodel", $this->getDocGeneratorDocumentationModel())
            ->setVariable("outputmodel", $this->getDocGeneratorOutputModel())
            ->setVariable("config", $this->getDocGeneratorConfig());

        $docGeneratorBlocks =
            array_filter(
                $this->getDocGeneratorDocumentationModel()->getBlocks(),
                function ($docGeneratorBlockId) {
                    return preg_match('/^[^#]/', $docGeneratorBlockId);
                }
            );

        $docGeneratorBlocks =
            array_map(
                function ($docGeneratorBlockId) use ($docGeneratorExpressionLanguage): string {
                    return preg_match('/^=(.*)\|(.*)$/', $docGeneratorBlockId, $docGeneratorBlockIdMatches)
                        ? ($docGeneratorExpressionLanguage->evaluatesToBooleanTrue($docGeneratorBlockIdMatches[1]) ? $docGeneratorBlockIdMatches[2] : "")
                        : $docGeneratorBlockId;
                },
                $docGeneratorBlocks
            );

        $docGeneratorBlocks =
            array_filter(
                $docGeneratorBlocks,
                function ($docGeneratorBlockId): bool {
                    return trim($docGeneratorBlockId) !== "";
                }
            );

        $docGeneratorBlockModels =
            array_map(
                function ($docGeneratorBlockId): \horstoeko\docugen\model\DocGeneratorBlockModel {
                    return $this->getDocGeneratorConfig()->getBlocks()->findByIdOrFail($docGeneratorBlockId);
                },
                $docGeneratorBlocks
            );

        $docGeneratorBlockModels =
            array_filter(
                $docGeneratorBlockModels,
                function ($docGeneratorBlockModel) use ($docGeneratorExpressionLanguage): bool {
                    if ($docGeneratorBlockModel->hasVisibleExpression() === false) {
                        return true;
                    }

                    return $docGeneratorExpressionLanguage
                        ->setVariable("blockmodel", $docGeneratorBlockModel)
                        ->evaluatesToBooleanTrue($docGeneratorBlockModel->getVisibleExpression());
                }
            );

        foreach ($docGeneratorBlockModels as $docGeneratorBlockModel) {
            $this->docGeneratorBlockBuilders[] = DocGeneratorBlockBuilder::factory($docGeneratorBlockModel, $this)->build();
        }

        DocGeneratorOutputBuilder::factory($this)->build()->output();

        return $this;
    }
}
