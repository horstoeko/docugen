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
 * Class representing an exception for an invalid JSON
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorInvalidJsonContentException extends DocGeneratorBaseException
{
    /**
     * Constructor
     *
     * @param Throwable|null $throwable
     */
    public function __construct(?Throwable $throwable = null)
    {
        parent::__construct(sprintf('The JSON could not be parsed properly. %s', json_last_error_msg()), DocGeneratorExceptionCodes::INVALIDJSONCONTENT, $throwable);
    }
}
