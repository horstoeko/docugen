<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\model\traits;

/**
 * Trait representing handling of model lines attribute
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
trait DocGeneratorModelHasLinesAttribute
{
    /**
     * The code lines
     *
     * @var array
     */
    protected $lines = [];

    /**
     * Returns the lines
     *
     * @return array<string>
     */
    public function getLines(): array
    {
        return $this->lines;
    }
}
