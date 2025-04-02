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
 * Class representing an exception for an unknown class
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorClassMustInheritFromException extends DocGeneratorBaseException
{
    /**
     * Constructor
     *
     * @param string         $classname
     * @param string         $inheritFromClassname
     * @param Throwable|null $throwable
     */
    public function __construct(string $classname, string $inheritFromClassname, ?Throwable $throwable = null)
    {
        parent::__construct(sprintf("The class %s must inherit from %s", $classname, $inheritFromClassname), DocGeneratorExceptionCodes::CLASSMUSTINHERITFROM, $throwable);
    }
}
