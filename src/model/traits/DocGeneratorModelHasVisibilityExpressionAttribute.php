<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\model\traits;

use horstoeko\stringmanagement\StringUtils;

/**
 * Trait representing handling of model ID attribute
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
trait DocGeneratorModelHasVisibilityExpressionAttribute
{
    /**
     * The visibility expression
     *
     * @var string
     */
    protected $visibleExpression = "";

    /**
     * Returns the expression for calculation visibility
     *
     * @return string
     */
    public function getVisibleExpression(): string
    {
        return $this->visibleExpression;
    }

    /**
     * Returns true if a non-empty visibility expression is assigned
     *
     * @return boolean
     */
    public function hasVisibleExpression(): bool
    {
        return StringUtils::stringIsNullOrEmpty($this->getVisibleExpression()) === false;
    }
}
