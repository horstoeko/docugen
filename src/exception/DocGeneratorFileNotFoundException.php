<?php

/**
 * This file is a part of horstoeko/docugen.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\exception;

use Throwable;

/**
 * Class representing an exception for missing a file
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorFileNotFoundException extends DocGeneratorBaseException
{
    /**
     * Constructor
     *
     * @param string         $filename
     * @param Throwable|null $throwable
     */
    public function __construct(string $filename, ?Throwable $throwable = null)
    {
        parent::__construct(sprintf("The file %s was not found", $filename), DocGeneratorExceptionCodes::FILENOTFOUND, $throwable);
    }
}
