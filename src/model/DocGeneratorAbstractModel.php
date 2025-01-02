<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\model;

use stdClass;

/**
 * Class representing the base class of all models
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
abstract class DocGeneratorAbstractModel
{
    /**
     * Create a model from data
     *
     * @param  stdClass $modelData
     * @return DocGeneratorAbstractModel
     */
    public static function factory(stdClass $modelData): DocGeneratorAbstractModel
    {
        return new static($modelData);
    }

    /**
     * Constructor (hidden)
     *
     * @param stdClass $modelData
     */
    final protected function __construct(stdClass $modelData)
    {
        $this->fillAttributes($modelData);
    }

    /**
     * Fill the model attributes by $modelData
     *
     * @param  stdClass $modelData
     * @return void
     */
    abstract protected function fillAttributes(stdClass $modelData): void;
}
