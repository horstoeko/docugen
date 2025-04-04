<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen;

/**
 * Class representing a output buffer
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorOutputBuffer
{
    /**
     * Internal output buffer
     *
     * @var array<string>
     */
    protected $lines = [];

    /**
     * Create a new instance
     *
     * @return DocGeneratorOutputBuffer
     */
    public static function factory(): DocGeneratorOutputBuffer
    {
        return new static();
    }

    /**
     * Constructor (hidden)
     *
     * @return static
     */
    final protected function __construct()
    {
        // Nothing here
    }

    /**
     * Add a single line to the output buffer
     *
     * @param  string $line
     * @return DocGeneratorOutputBuffer
     */
    public function addLineToOutputBuffer(string $line): DocGeneratorOutputBuffer
    {
        $this->lines[] = $line;

        return $this;
    }

    /**
     * Add multiple lines to the output buffer
     *
     * @param  array<string> $lines
     * @return DocGeneratorOutputBuffer
     */
    public function addLinesToOutputBuffer(array $lines): DocGeneratorOutputBuffer
    {
        foreach ($lines as $line) {
            $this->addLineToOutputBuffer($line);
        }

        return $this;
    }

    /**
     * Add an empty line to the output buffer
     *
     * @return DocGeneratorOutputBuffer
     */
    public function addEmptyLineToOutputBuffer(): DocGeneratorOutputBuffer
    {
        return $this->addLineToOutputBuffer('');
    }

    /**
     * Get all the lines in the buffer
     *
     * @return array<string>
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    /**
     * Set all lines
     *
     * @param  array<string> $lines
     * @return DocGeneratorOutputBuffer
     */
    public function setLines(array $lines): DocGeneratorOutputBuffer
    {
        $this->lines = $lines;

        return $this;
    }

    /**
     * Get all the lines in the buffer as a single string
     *
     * @return string
     */
    public function getLinesAsString(): string
    {
        return implode(PHP_EOL, $this->lines);
    }

    /**
     * Set all lines from a single string
     *
     * @param  string $lines
     * @return DocGeneratorOutputBuffer
     */
    public function setLinesFromString(string $lines): DocGeneratorOutputBuffer
    {
        $this->lines = explode(PHP_EOL, $lines);

        return $this;
    }

    /**
     * Process lines via a callback
     *
     * @param  callable $callBack
     * @return DocGeneratorOutputBuffer
     */
    public function processLines(callable $callBack): DocGeneratorOutputBuffer
    {
        $this->lines = array_map($callBack, $this->lines);

        return $this;
    }

    /**
     * Prepend lines to buffer
     *
     * @param  array $lines
     * @return DocGeneratorOutputBuffer
     */
    public function prependLines(array $lines): DocGeneratorOutputBuffer
    {
        array_unshift($this->lines, ...$lines);

        return $this;
    }

    /**
     * Append lines to buffer
     *
     * @param  array $lines
     * @return DocGeneratorOutputBuffer
     */
    public function appendLines(array $lines): DocGeneratorOutputBuffer
    {
        $this->lines = array_merge($this->lines, $lines);

        return $this;
    }
}
