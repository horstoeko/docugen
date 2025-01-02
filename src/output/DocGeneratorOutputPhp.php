<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\output;

use horstoeko\docugen\block\DocGeneratorBlockCode;
use horstoeko\docugen\block\DocGeneratorBlockComment;

/**
 * Class representing the PHP outputter
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorOutputPhp extends DocGeneratorOutputAbstract
{
    /**
     * @inheritDoc
     */
    protected function renderComment(DocGeneratorBlockComment $docGeneratorBlockComment): void
    {
        $this->docGeneratorOutputBuffer->addLinesToOutputBuffer(
            array_map(
                function (string $line) {
                    return sprintf("// %s", $line);
                },
                $docGeneratorBlockComment->getRenderedLines()
            )
        );
    }

    /**
     * @inheritDoc
     */
    protected function renderCode(DocGeneratorBlockCode $docGeneratorBlockCode): void
    {
        $this->docGeneratorOutputBuffer->addLinesToOutputBuffer($docGeneratorBlockCode->getRenderedLines());
    }
}
