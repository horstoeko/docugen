<?php

/**
 * This file is a part of horstoeko/docugen.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\exception;

/**
 * Class representing the internal coes for DocuGen exceptions
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorExceptionCodes
{
    public const FILENOTFOUND = -2000;

    public const FILENOTREADABLE = -2001;

    public const INVALIDJSONCONTENT = -3000;
}
