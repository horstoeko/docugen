<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\model;

use stdClass;
use horstoeko\docugen\model\traits\DocGeneratorCommonModelAttributesTrait;

/**
 * Class representing the model for a documentation
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorDocumentationModel extends DocGeneratorAbstractModel
{
    use DocGeneratorCommonModelAttributesTrait;

    /**
     * The code lines
     *
     * @var array
     */
    protected $blocks = [];

    /**
     * @inheritDoc
     */
    protected function fillAttributes(stdClass $modelData): void
    {
        $this->id = $modelData->id;
        $this->title = $modelData->title;
        $this->description = $modelData->description;
        $this->blocks = $modelData->blocks;
    }

    /**
     * Returns the lines
     *
     * @return array<string>
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }
}
