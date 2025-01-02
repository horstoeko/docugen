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
use horstoeko\docugen\block\DocGeneratorBlockAbstract;

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
    protected $docGeneratorBlockModel;

    /**
     * The global config
     *
     * @var DocGeneratorConfig
     */
    protected $docGeneratorConfig;

    /**
     * Block instance
     *
     * @var DocGeneratorBlockAbstract
     */
    protected $blockInstance;

    /**
     * Create a new instance of DocGeneratorBlockBuilder
     *
     * @param  DocGeneratorBlockModel $docGeneratorBlockModel
     * @param  DocGeneratorConfig     $docGeneratorConfig
     * @return DocGeneratorBlockBuilder
     */
    public static function factory(DocGeneratorBlockModel $docGeneratorBlockModel, DocGeneratorConfig $docGeneratorConfig): DocGeneratorBlockBuilder
    {
        return new static($docGeneratorBlockModel, $docGeneratorConfig);
    }

    /**
     * Constructor (hidden)
     *
     * @param DocGeneratorBlockModel $docGeneratorBlockModel
     * @param DocGeneratorConfig     $docGeneratorConfig
     */
    final protected function __construct(DocGeneratorBlockModel $docGeneratorBlockModel, DocGeneratorConfig $docGeneratorConfig)
    {
        $this->docGeneratorBlockModel = $docGeneratorBlockModel;
        $this->docGeneratorConfig = $docGeneratorConfig;
    }

    /**
     * Generate a single block
     *
     * @return DocGeneratorBlockBuilder
     */
    public function build(): DocGeneratorBlockBuilder
    {
        /**
         * @var DocGeneratorBlockAbstract $blockClassName
         */
        $blockClassName = sprintf('horstoeko\docugen\block\DocGeneratorBlock%s', ucFirst($this->docGeneratorBlockModel->getType()));

        $this->blockInstance = $blockClassName::factory($this->docGeneratorBlockModel, $this->docGeneratorConfig)->build();

        return $this;
    }

    /**
     * Get model of the block
     *
     * @return DocGeneratorBlockModel
     */
    public function getBlockModel(): DocGeneratorBlockModel
    {
        return $this->docGeneratorBlockModel;
    }

    /**
     * Get ID of the block
     *
     * @return string
     */
    public function getBlockId(): string
    {
        return $this->getBlockModel()->getId();
    }

    /**
     * Get the block instance (object)
     *
     * @return DocGeneratorBlockAbstract
     */
    public function getBlockInstance(): DocGeneratorBlockAbstract
    {
        return $this->blockInstance;
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
}
