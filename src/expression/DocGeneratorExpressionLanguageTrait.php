<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\expression;

use Symfony\Component\ExpressionLanguage\SyntaxError;

/**
 * Trait representing the support of expression language
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
trait DocGeneratorExpressionLanguageTrait
{
    /**
     * Evaluate an expression
     *
     * @param  string $expression
     * @param  array  $variables
     * @return mixed
     * @throws SyntaxError
     */
    public function evaluate(string $expression, array $variables)
    {
        return DocGeneratorExpressionLanguage::factory()->addVariables($variables)->evaluate($expression);
    }

    /**
     * Returns true if the expression evaluates to true
     *
     * @param  string $expression
     * @param  array  $variables
     * @return bool
     * @throws SyntaxError
     */
    public function evaluatesToBooleanTrue(string $expression, array $variables): bool
    {
        return $this->evaluate($expression, $variables) === true;
    }

    /**
    * Returns true if the expression evaluates to false
      *
     * @param  string $expression
     * @param  array  $variables
     * @return bool
     * @throws SyntaxError
     */
    public function evaluatesToBooleanFalse(string $expression, array $variables): bool
    {
        return $this->evaluate($expression, $variables) === false;
    }
}
