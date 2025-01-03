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
    private $docGeneratorBlockModel;

    /**
     * The global config
     *
     * @var DocGeneratorConfig
     */
    private $docGeneratorConfig;

    /**
     * Block instance
     *
     * @var DocGeneratorBlockAbstract
     */
    private $docGeneratorBlockAbstract;

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
     * Returns the associated block model
     *
     * @return DocGeneratorBlockModel
     */
    public function getDocGeneratorBlockModel(): DocGeneratorBlockModel
    {
        return $this->docGeneratorBlockModel;
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

        $this->docGeneratorBlockAbstract =
            $blockClassName::factory(
                $this->getDocGeneratorBlockModel(),
                $this->getDocGeneratorConfig()
            )->build();

        return $this;
    }
}
