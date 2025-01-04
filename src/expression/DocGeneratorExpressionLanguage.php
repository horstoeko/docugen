<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\expression;

use Symfony\Component\DependencyInjection\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

/**
 * Class representing the expression language
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorExpressionLanguage
{
    /**
     * Defined variables
     *
     * @var array<string,mixed>
     */
    protected $variables = [];

    /**
     * Internal expression language instance
     *
     * @var ExpressionLanguage
     */
    protected $expressionLanguageInstance;

    /**
     * Create a model from data
     *
     * @return DocGeneratorExpressionLanguage
     */
    public static function factory(): DocGeneratorExpressionLanguage
    {
        return new static();
    }

    /**
     * Constructor (hidden)
     */
    final protected function __construct()
    {
        $this->expressionLanguageInstance = new ExpressionLanguage();
    }

    /**
     * Add a new variable
     *
     * @param  string $variableName
     * @param  mixed  $variableValue
     * @return DocGeneratorExpressionLanguage
     */
    public function addVariable(string $variableName, $variableValue): DocGeneratorExpressionLanguage
    {
        $this->variables[$variableName] = $variableValue;

        return $this;
    }

    /**
     * Add multiple variables
     *
     * @param  array<string,mixed> $variables
     * @return DocGeneratorExpressionLanguage
     */
    public function addVariables(array $variables): DocGeneratorExpressionLanguage
    {
        array_walk(
            $variables,
            function ($variableValue, $variableName): void {
                $this->addVariable($variableName, $variableValue);
            }
        );

        return $this;
    }

    /**
     * Clear all defined variables
     *
     * @return DocGeneratorExpressionLanguage
     */
    public function clearVariables(): DocGeneratorExpressionLanguage
    {
        $this->variables = [];

        return $this;
    }

    /**
     * Evaluate an expression
     *
     * @param  string $expression
     * @return mixed
     * @throws SyntaxError
     */
    public function evaluate(string $expression)
    {
        return $this->expressionLanguageInstance->evaluate($expression, $this->variables);
    }

    /**
     * Returns true if the expression evaluates to true
     *
     * @param  string $expression
     * @return boolean
     * @throws SyntaxError
     */
    public function evaluatesToBooleanTrue(string $expression): bool
    {
        return $this->evaluate($expression) === true;
    }

    /**
     * Returns true if the expression evaluates to false
     *
     * @param  string $expression
     * @return boolean
     * @throws SyntaxError
     */
    public function evaluatesToBooleanFalse(string $expression): bool
    {
        return $this->evaluate($expression) === false;
    }
}
