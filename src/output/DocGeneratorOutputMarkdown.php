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
 * Class representing the markdown outputter
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorOutputMarkdown extends DocGeneratorOutputAbstract
{
    /**
     * @inheritDoc
     */
    protected function renderComment(DocGeneratorBlockComment $docGeneratorBlockComment): void
    {
        $this->docGeneratorOutputBuffer->addLinesToOutputBuffer($docGeneratorBlockComment->getRenderedLines());
    }

    /**
     * @inheritDoc
     */
    protected function renderCode(DocGeneratorBlockCode $docGeneratorBlockCode): void
    {
        $this->docGeneratorOutputBuffer->addLineToOutputBuffer(sprintf('```%s', $docGeneratorBlockCode->getBlockModel()->getLanguage()));
        $this->docGeneratorOutputBuffer->addLinesToOutputBuffer($docGeneratorBlockCode->getRenderedLines());
        $this->docGeneratorOutputBuffer->addLineToOutputBuffer('```');
    }
}
