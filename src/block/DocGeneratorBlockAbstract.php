<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\block;

use horstoeko\docugen\DocGeneratorConfig;
use horstoeko\docugen\DocGeneratorLineParser;
use horstoeko\docugen\DocGeneratorOutputBuffer;
use horstoeko\docugen\model\DocGeneratorBlockModel;
use horstoeko\docugen\model\DocGeneratorOutputModel;
use horstoeko\docugen\block\DocGeneratorBlockBuilder;

/**
 * Class representing an abstract documentation block
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
abstract class DocGeneratorBlockAbstract
{
    /**
     * The calling block builder
     *
     * @var DocGeneratorBlockBuilder
     */
    private $docGeneratorBlockBuilder;

    /**
     * Line parser
     *
     * @var DocGeneratorLineParser
     */
    private $docGeneratorLineParser;

    /**
     * The output buffer
     *
     * @var DocGeneratorOutputBuffer
     */
    private $docGeneratorOutputBuffer;

    /**
     * Return new instance of DocGeneratorBlockAbstract
     *
     * @param  DocGeneratorBlockBuilder $docGeneratorBlockBuilder
     * @return static
     */
    public static function factory(DocGeneratorBlockBuilder $docGeneratorBlockBuilder)
    {
        return new static($docGeneratorBlockBuilder);
    }

    /**
     * Constructor (hidden)
     *
     * @param DocGeneratorBlockBuilder $docGeneratorBlockBuilder
     */
    final protected function __construct(DocGeneratorBlockBuilder $docGeneratorBlockBuilder)
    {
        $this->docGeneratorBlockBuilder = $docGeneratorBlockBuilder;
        $this->docGeneratorOutputBuffer = DocGeneratorOutputBuffer::factory();
        $this->docGeneratorLineParser = DocGeneratorLineParser::factory($this->getDocGeneratorConfig(), $this->getDocGeneratorOutputBuffer());
    }

    /**
     * Returns the calling block builder
     *
     * @return DocGeneratorBlockBuilder
     */
    public function getDocGeneratorBlockBuilder(): DocGeneratorBlockBuilder
    {
        return $this->docGeneratorBlockBuilder;
    }

    /**
     * Returns the internal line parser
     *
     * @return DocGeneratorLineParser
     */
    public function getDocGeneratorLineParser(): DocGeneratorLineParser
    {
        return $this->docGeneratorLineParser;
    }

    /**
     * Returns the internal output buffer
     *
     * @return DocGeneratorOutputBuffer
     */
    public function getDocGeneratorOutputBuffer(): DocGeneratorOutputBuffer
    {
        return $this->docGeneratorOutputBuffer;
    }

    /**
     * Returns the associated block model
     *
     * @return DocGeneratorBlockModel
     */
    public function getDocGeneratorBlockModel(): DocGeneratorBlockModel
    {
        return $this->getDocGeneratorBlockBuilder()->getDocGeneratorBlockModel();
    }

    /**
     * Returns the global configuration
     *
     * @return DocGeneratorConfig
     */
    public function getDocGeneratorConfig(): DocGeneratorConfig
    {
        return $this->getDocGeneratorBlockBuilder()->getDocGeneratorConfig();
    }

    /**
     * Get all the lines from the block
     *
     * @return array<string>
     */
    public function getRenderedLines(): array
    {
        return $this->getDocGeneratorOutputBuffer()->getLines();
    }

    /**
     * Generate a single block
     *
     * @return DocGeneratorBlockAbstract
     */
    abstract public function build(): DocGeneratorBlockAbstract;
}
