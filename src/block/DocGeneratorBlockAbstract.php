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
     * @param  DocGeneratorBlockModel $docGeneratorBlockModel
     * @return static
     */
    public static function factory(DocGeneratorBlockModel $docGeneratorBlockModel, DocGeneratorConfig $docGeneratorConfig)
    {
        return new static($docGeneratorBlockModel, $docGeneratorConfig);
    }

    /**
     * Constructor (hidden)
     *
     * @param DocGeneratorBlockModel $docGeneratorBlockModel
     */
    final protected function __construct(DocGeneratorBlockModel $docGeneratorBlockModel, DocGeneratorConfig $docGeneratorConfig)
    {
        $this->docGeneratorBlockModel = $docGeneratorBlockModel;
        $this->docGeneratorConfig = $docGeneratorConfig;
        $this->docGeneratorOutputBuffer = DocGeneratorOutputBuffer::factory();
        $this->docGeneratorLineParser = DocGeneratorLineParser::factory($this->docGeneratorConfig, $this->docGeneratorOutputBuffer);
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
     * Generate a single block
     *
     * @return DocGeneratorBlockAbstract
     */
    abstract public function build(): DocGeneratorBlockAbstract;

    /**
     * Get all the lines from the block
     *
     * @return array<string>
     */
    public function getRenderedLines(): array
    {
        return $this->getDocGeneratorOutputBuffer()->getLines();
    }
}
