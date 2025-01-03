<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\model;

use stdClass;
use horstoeko\docugen\model\traits\DocGeneratorModelHasLinesAttribute;
use horstoeko\docugen\model\traits\DocGeneratorCommonModelAttributesTrait;

/**
 * Class representing the model for a text constant
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorTextModel extends DocGeneratorAbstractModel
{
    use DocGeneratorCommonModelAttributesTrait;
    use DocGeneratorModelHasLinesAttribute;

    /**
     * @inheritDoc
     */
    protected function fillAttributes(stdClass $modelData): void
    {
        $this->id = $modelData->id ?? "";
        $this->title = $modelData->title ?? "";
        $this->description = $modelData->description ?? "";
        $this->lines = $modelData->lines ?? [];
    }
}
