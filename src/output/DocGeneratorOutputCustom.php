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
use horstoeko\docugen\DocGeneratorOutputBuffer;
use horstoeko\docugen\exception\DocGeneratorClassMustInheritFromException;
use horstoeko\docugen\exception\DocGeneratorUnknownClassException;
use horstoeko\stringmanagement\StringUtils;

/**
 * Class representing the HTML outputter
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorOutputCustom extends DocGeneratorOutputAbstract
{
    /**
     * Instance of the custom output class
     *
     * @var DocGeneratorOutputAbstract
     */
    protected $docGeneratorOutputCustomInstance;

    /**
     * Returns the internal output buffer
     *
     * @return DocGeneratorOutputBuffer
     */
    public function getDocGeneratorOutputBuffer(): DocGeneratorOutputBuffer
    {
        return $this->docGeneratorOutputCustomInstance->getDocGeneratorOutputBuffer();
    }

    /**
     * @inheritDoc
     */
    public function build(): DocGeneratorOutputAbstract
    {
        $docGeneratorOutputCustomClassname = $this->getDocGeneratorOutputModel()->getOption('class', '');

        if (StringUtils::stringIsNullOrEmpty($docGeneratorOutputCustomClassname)) {
            throw new DocGeneratorUnknownClassException("<empty>");
        }

        if (!class_exists($docGeneratorOutputCustomClassname)) {
            throw new DocGeneratorUnknownClassException($docGeneratorOutputCustomClassname);
        }

        if (!is_a($docGeneratorOutputCustomClassname, DocGeneratorOutputAbstract::class, true)) {
            throw new DocGeneratorClassMustInheritFromException($docGeneratorOutputCustomClassname, DocGeneratorOutputAbstract::class);
        }

        $this->docGeneratorOutputCustomInstance = $docGeneratorOutputCustomClassname::factory($this->getDocGeneratorOutputBuilder());

        parent::build();

        return $this;
    }

    /**
     * @inheritDoc
     */
    protected function renderCommentBlock(DocGeneratorBlockComment $docGeneratorBlockComment): void
    {
        $this->docGeneratorOutputCustomInstance->renderCommentBlock($docGeneratorBlockComment);
    }

    /**
     * @inheritDoc
     */
    protected function renderCodeBlock(DocGeneratorBlockCode $docGeneratorBlockCode): void
    {
        $this->docGeneratorOutputCustomInstance->renderCodeBlock($docGeneratorBlockCode);
    }

    /**
     * @inheritDoc
     */
    protected function renderBlankBlock(DocGeneratorBlockBlank $docGeneratorBlockBlank): void
    {
        $this->docGeneratorOutputCustomInstance->renderBlankBlock($docGeneratorBlockBlank);
    }

    /**
     * @inheritDoc
     */
    protected function beforeAllBlocks(): DocGeneratorOutputAbstract
    {
        $this->docGeneratorOutputCustomInstance->beforeAllBlocks();

        return $this;
    }

    /**
     * @inheritDoc
     */
    protected function afterAllBlocks(): DocGeneratorOutputAbstract
    {
        $this->docGeneratorOutputCustomInstance->afterAllBlocks();

        return $this;
    }
}