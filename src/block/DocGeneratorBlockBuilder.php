<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\block;

use horstoeko\docugen\DocGeneratorConfig;
use horstoeko\docugen\model\DocGeneratorBlockModel;
use horstoeko\docugen\model\DocGeneratorOutputModel;
use horstoeko\docugen\block\DocGeneratorBlockAbstract;
use horstoeko\docugen\builder\DocGeneratorDocumentationBuilder;
use horstoeko\docugen\exception\DocGeneratorUnknownClassException;

/**
 * Class representing a builder for a documentation block
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorBlockBuilder
{
    /**
     * The block to handle
     *
     * @var DocGeneratorBlockModel
     */
    private $docGeneratorBlockModel;

    /**
     * The calling documentation build
     *
     * @var DocGeneratorDocumentationBuilder
     */
    private $docGeneratorDocumentationBuilder;

    /**
     * Block instance
     *
     * @var DocGeneratorBlockAbstract
     */
    private $docGeneratorBlockAbstract;

    /**
     * Create a new instance of DocGeneratorBlockBuilder
     *
     * @param  DocGeneratorBlockModel           $docGeneratorBlockModel
     * @param  DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder
     * @return DocGeneratorBlockBuilder
     */
    public static function factory(DocGeneratorBlockModel $docGeneratorBlockModel, DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder): DocGeneratorBlockBuilder
    {
        return new static($docGeneratorBlockModel, $docGeneratorDocumentationBuilder);
    }

    /**
     * Constructor (hidden)
     *
     * @param DocGeneratorBlockModel           $docGeneratorBlockModel
     * @param DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder
     */
    final protected function __construct(DocGeneratorBlockModel $docGeneratorBlockModel, DocGeneratorDocumentationBuilder $docGeneratorDocumentationBuilder)
    {
        $this->docGeneratorBlockModel = $docGeneratorBlockModel;
        $this->docGeneratorDocumentationBuilder = $docGeneratorDocumentationBuilder;
    }

    /**
     * Returns the associated block model
     *
     * @return DocGeneratorBlockModel
     */
    public function getDocGeneratorBlockModel(): DocGeneratorBlockModel
    {
        return $this->docGeneratorBlockModel;
    }

    /**
     * Returns the calling documentation builder
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
        return $this->getDocGeneratorDocumentationBuilder()->getDocGeneratorConfig();
    }

    /**
     * Get the block instance (object)
     *
     * @return DocGeneratorBlockAbstract
     */
    public function getBlockInstance(): DocGeneratorBlockAbstract
    {
        return $this->docGeneratorBlockAbstract;
    }

    /**
     * Get the lines to output
     *
     * @return array<string>
     */
    public function getRenderedLines(): array
    {
        return $this->getBlockInstance()->getRenderedLines();
    }

    /**
     * Generate a single block
     *
     * @return DocGeneratorBlockBuilder
     */
    public function build(): DocGeneratorBlockBuilder
    {
        $blockClassName =
            sprintf(
                'horstoeko\docugen\block\DocGeneratorBlock%s',
                ucFirst($this->getDocGeneratorBlockModel()->getType())
            );

        if (!class_exists($blockClassName)) {
            throw new DocGeneratorUnknownClassException($blockClassName);
        }

        $this->docGeneratorBlockAbstract = $blockClassName::factory($this)->build();

        return $this;
    }
}
