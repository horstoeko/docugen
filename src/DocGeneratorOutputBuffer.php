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
     * @return void
     */
    public function addLineToOutputBuffer(string $line): void
    {
        $this->lines[] = $line;
    }

    /**
     * Add multiple lines to the output buffer
     *
     * @param  array<string> $lines
     * @return void
     */
    public function addLinesToOutputBuffer(array $lines): void
    {
        foreach ($lines as $line) {
            $this->addLineToOutputBuffer($line);
        }
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
}
