<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\utils;

/**
 * Class representing helpers for array handling
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorArrayUtils
{
    /**
     * Ensure array
     *
     * @param  mixed $value
     * @return array
     */
    public static function ensureArray($value): array
    {
        return !is_array($value) ? [$value] : $value;
    }
}
