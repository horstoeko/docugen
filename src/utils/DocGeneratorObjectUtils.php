<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\utils;

/**
 * Class representing helpers for object handling
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorObjectUtils
{
    /**
     * Convert an object recursively to an associate array
     *
     * @param  mixed $object
     * @return mixed
     */
    public static function objectToArray($object)
    {
        if (is_object($object) || is_array($object)) {
            $ret = (array) $object;

            foreach ($ret as &$item) {
                $item = static::objectToArray($item);
            }

            return $ret;
        }

        return $object;
    }
}
