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
use horstoeko\docugen\model\traits\DocGeneratorModelHasOptionAttribute;
use horstoeko\docugen\model\traits\DocGeneratorCommonModelAttributesTrait;
use horstoeko\docugen\model\traits\DocGeneratorModelHasVisibilityExpressionAttribute;

/**
 * Class representing the model for a documentation
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorBlockModel extends DocGeneratorAbstractModel
{
    use DocGeneratorCommonModelAttributesTrait;
    use DocGeneratorModelHasLinesAttribute;
    use DocGeneratorModelHasOptionAttribute;
    use DocGeneratorModelHasVisibilityExpressionAttribute;

    /**
     * The block type
     *
     * @var string
     */
    protected $type = "comment";

    /**
     * The language
     *
     * @var string
     */
    protected $language = "php";

    /**
     * @inheritDoc
     */
    protected function fillAttributes(stdClass $modelData): void
    {
        $this->id = $modelData->id ?? "";
        $this->title = $modelData->title ?? "";
        $this->description = $modelData->description ?? "";
        $this->type = $modelData->type ?? "comment";
        $this->language = $modelData->language ?? "php";
        $this->lines = $modelData->lines ?? [];
        $this->options = array_column($modelData->options ?? [], "value", "id");
        $this->visibleExpression = $modelData->visibleexpression ?? "";
    }

    /**
     * Returns the type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Returns the programming language (only for code blocks)
     *
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }
}
