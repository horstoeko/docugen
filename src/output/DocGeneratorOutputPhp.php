<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\output;

use horstoeko\docugen\block\DocGeneratorBlockCode;
use horstoeko\docugen\block\DocGeneratorBlockBlank;
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
    protected function renderCommentBlock(DocGeneratorBlockComment $docGeneratorBlockComment): void
    {
        $this->getDocGeneratorOutputBuffer()->addLinesToOutputBuffer(
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
    protected function renderCodeBlock(DocGeneratorBlockCode $docGeneratorBlockCode): void
    {
        $this->getDocGeneratorOutputBuffer()->addLinesToOutputBuffer($docGeneratorBlockCode->getRenderedLines());
    }

    /**
     * @inheritDoc
     */
    protected function renderBlankBlock(DocGeneratorBlockBlank $docGeneratorBlockBank): void
    {
        $this->getDocGeneratorOutputBuffer()->addLinesToOutputBuffer($docGeneratorBlockBank->getRenderedLines());
    }

    /**
     * @inheritDoc
     */
    protected function beforeAllBlocks(): DocGeneratorOutputAbstract
    {
        $this->getDocGeneratorOutputBuffer()->addLineToOutputBuffer("<?php\n");

        return $this;
    }
}
