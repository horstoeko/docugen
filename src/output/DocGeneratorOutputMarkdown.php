<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\output;

use horstoeko\docugen\block\DocGeneratorBlockBlank;
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
    protected function renderCommentBlock(DocGeneratorBlockComment $docGeneratorBlockComment): void
    {
        $this->getDocGeneratorOutputBuffer()->addLinesToOutputBuffer($docGeneratorBlockComment->getRenderedLines());
    }

    /**
     * @inheritDoc
     */
    protected function renderCodeBlock(DocGeneratorBlockCode $docGeneratorBlockCode): void
    {
        $this->getDocGeneratorOutputBuffer()->addLineToOutputBuffer(sprintf('```%s', $docGeneratorBlockCode->getDocGeneratorBlockModel()->getLanguage()));
        $this->getDocGeneratorOutputBuffer()->addLinesToOutputBuffer($docGeneratorBlockCode->getRenderedLines());
        $this->getDocGeneratorOutputBuffer()->addLineToOutputBuffer('```');
    }

    /**
     * @inheritDoc
     */
    protected function renderBlankBlock(DocGeneratorBlockBlank $docGeneratorBlockBlank): void
    {
        $this->getDocGeneratorOutputBuffer()->addLinesToOutputBuffer($docGeneratorBlockBlank->getRenderedLines());
    }

    /**
     * @inheritDoc
     */
    protected function beforeAllBlocks(): DocGeneratorOutputAbstract
    {
        $this->getDocGeneratorOutputBuffer()->addLineToOutputBuffer(sprintf('# %s', $this->getDocGeneratorDocumentationBuilder()->getDocGeneratorDocumentationModel()->getTitle()));
        $this->getDocGeneratorOutputBuffer()->addEmptyLineToOutputBuffer();
        $this->getDocGeneratorOutputBuffer()->addLineToOutputBuffer($this->getDocGeneratorDocumentationBuilder()->getDocGeneratorDocumentationModel()->getDescription());
        $this->getDocGeneratorOutputBuffer()->addEmptyLineToOutputBuffer();

        return $this;
    }
}
