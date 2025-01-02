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
    protected $docGeneratorBlockModel;

    /**
     * The global config
     *
     * @var DocGeneratorConfig
     */
    protected $docGeneratorConfig;

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
    protected $docGeneratorOutputBuffer;

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
     * Generate a single block
     *
     * @return DocGeneratorBlockAbstract
     */
    public function build(): DocGeneratorBlockAbstract
    {
        foreach ($this->docGeneratorBlockModel->getLines() as $blockLine) {
            $this->docGeneratorLineParser->parseLine($blockLine);
        }

        return $this;
    }

    /**
     * Returns the model of the block
     *
     * @return DocGeneratorBlockModel
     */
    public function getBlockModel(): DocGeneratorBlockModel
    {
        return $this->docGeneratorBlockModel;
    }

    /**
     * Get all the lines from the block
     *
     * @return array<string>
     */
    public function getRenderedLines(): array
    {
        return $this->docGeneratorOutputBuffer->getLines();
    }
}
