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
        $title = "";
        $description = "";

        if ($this->getDocGeneratorOutputModel()->getTitleMode() === 1) {
            $title = $this->getDocGeneratorOutputModel()->getTitle();
        } elseif ($this->getDocGeneratorOutputModel()->getTitleMode() === 2) {
            $title = $this->getDocGeneratorDocumentationBuilder()->getDocGeneratorDocumentationModel()->getTitle();
        }

        if ($this->getDocGeneratorOutputModel()->getDescriptionMode() === 1) {
            $description = $this->getDocGeneratorOutputModel()->getDescription();
        } elseif ($this->getDocGeneratorOutputModel()->getDescriptionMode() === 2) {
            $description = $this->getDocGeneratorDocumentationBuilder()->getDocGeneratorDocumentationModel()->getDescription();
        }

        $title = trim($title);
        $description = trim($description);

        if ($title) {
            $this->getDocGeneratorOutputBuffer()->addLineToOutputBuffer(sprintf('# %s', $title));
            $this->getDocGeneratorOutputBuffer()->addEmptyLineToOutputBuffer();
        }

        if ($description) {
            $this->getDocGeneratorOutputBuffer()->addLineToOutputBuffer($description);
            $this->getDocGeneratorOutputBuffer()->addEmptyLineToOutputBuffer();
        }

        return $this;
    }
}
