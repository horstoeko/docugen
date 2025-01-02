<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\documentation;

use horstoeko\docugen\DocGeneratorConfig;
use horstoeko\docugen\block\DocGeneratorBlockBuilder;
use horstoeko\docugen\model\DocGeneratorDocumentationModel;

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
    private $cocGeneratorBlockBuilders = [];

    /**
     * Create a new instance
     *
     * @return DocGeneratorDocumentationBuilder
     */
    public static function factory(DocGeneratorDocumentationModel $docGeneratorDocumentationModel, DocGeneratorConfig $docGeneratorConfig): DocGeneratorDocumentationBuilder
    {
        return new static($docGeneratorDocumentationModel, $docGeneratorConfig);
    }

    /**
     * Constructor (hidden)
     *
     * @param  DocGeneratorDocumentationModel $docGeneratorDocumentationModel
     * @return static
     */
    final protected function __construct(DocGeneratorDocumentationModel $docGeneratorDocumentationModel, DocGeneratorConfig $docGeneratorConfig)
    {
        $this->docGeneratorDocumentationModel = $docGeneratorDocumentationModel;
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
        return $this->cocGeneratorBlockBuilders;
    }

    /**
     * Generate the documentation
     *
     * @return DocGeneratorDocumentationBuilder
     */
    public function build(): DocGeneratorDocumentationBuilder
    {
        foreach ($this->docGeneratorDocumentationModel->getBlocks() as $documentationBlockId) {
            $this->cocGeneratorBlockBuilders[] = DocGeneratorBlockBuilder::factory(
                $this->getDocGeneratorConfig()->getBlocks()->findByIdOrFail($documentationBlockId),
                $this->getDocGeneratorConfig()
            )->build();
        }

        return $this;
    }
}
