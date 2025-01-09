<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\expression;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

/**
 * Class representing the expression language provider for DocuGenerator
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorExpressionFunctionProvider implements ExpressionFunctionProviderInterface
{
    /**
     * @inheritDoc
     */
    public function getFunctions(): array
    {
        return [
            ExpressionFunction::fromPhp('trim'),
            ExpressionFunction::fromPhp('ltrim'),
            ExpressionFunction::fromPhp('rtrim'),
            ExpressionFunction::fromPhp('str_pad'),
            ExpressionFunction::fromPhp('str_contains'),
            ExpressionFunction::fromPhp('str_ends_with'),
            ExpressionFunction::fromPhp('str_starts_with'),
            ExpressionFunction::fromPhp('str_repeat'),
            ExpressionFunction::fromPhp('str_replace'),
            ExpressionFunction::fromPhp('str_ireplace'),
            ExpressionFunction::fromPhp('strpos'),
            ExpressionFunction::fromPhp('stripos'),
            ExpressionFunction::fromPhp('strcmp'),
            ExpressionFunction::fromPhp('strcasecmp'),
            ExpressionFunction::fromPhp('strtolower'),
            ExpressionFunction::fromPhp('strtoupper'),
            ExpressionFunction::fromPhp('substr'),
            ExpressionFunction::fromPhp('count'),
        ];
    }
}
