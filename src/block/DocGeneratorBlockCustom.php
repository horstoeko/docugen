<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\block;

use horstoeko\docugen\DocGeneratorLineParser;
use horstoeko\docugen\DocGeneratorOutputBuffer;
use horstoeko\docugen\exception\DocGeneratorClassMustInheritFromException;
use horstoeko\docugen\exception\DocGeneratorUnknownClassException;
use horstoeko\docugen\model\DocGeneratorBlockModel;
use horstoeko\stringmanagement\StringUtils;

/**
 * Class representing an empty block
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorBlockCustom extends DocGeneratorBlockAbstract
{
    /**
     * Instance of the custom output class
     *
     * @var DocGeneratorBlockAbstract
     */
    protected $docGeneratorBlockCustomInstance;

    /**
     * Returns the internal output buffer
     *
     * @return DocGeneratorOutputBuffer
     */
    public function getDocGeneratorOutputBuffer(): DocGeneratorOutputBuffer
    {
        return $this->docGeneratorBlockCustomInstance->getDocGeneratorOutputBuffer();
    }

    /**
     * @inheritDoc
     */
    public function build(): DocGeneratorBlockAbstract
    {
        $docGeneratorBlockCustomClassname = $this->getDocGeneratorBlockModel()->getOption('class', '');

        if (StringUtils::stringIsNullOrEmpty($docGeneratorBlockCustomClassname)) {
            throw new DocGeneratorUnknownClassException("<empty>");
        }

        if (!class_exists($docGeneratorBlockCustomClassname)) {
            throw new DocGeneratorUnknownClassException($docGeneratorBlockCustomClassname);
        }

        if (!is_a($docGeneratorBlockCustomClassname, DocGeneratorBlockAbstract::class, true)) {
            throw new DocGeneratorClassMustInheritFromException($docGeneratorBlockCustomClassname, DocGeneratorBlockAbstract::class);
        }

        $this->docGeneratorBlockCustomInstance = $docGeneratorBlockCustomClassname::factory($this->getDocGeneratorBlockBuilder());
        $this->docGeneratorBlockCustomInstance->build();

        return $this;
    }
}
