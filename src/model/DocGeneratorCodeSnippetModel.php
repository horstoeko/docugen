<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\model;

use stdClass;

/**
 * Class representing the model for a code snippet
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorCodeSnippetModel extends DocGeneratorAbstractModel
{
    /**
     * The codesnippet id
     *
     * @var string
     */
    protected $id = "";

    /**
     * The codesnippet title
     *
     * @var string
     */
    protected $title = "";

    /**
     * The codesnippet description
     *
     * @var string
     */
    protected $description = "";

    /**
     * The code lines
     *
     * @var array
     */
    protected $lines = [];

    /**
     * @inheritDoc
     */
    protected function fillAttributes(stdClass $modelData): void
    {
        $this->id = $modelData->id;
        $this->title = $modelData->title;
        $this->description = $modelData->description;
        $this->lines = $modelData->lines;
    }

    /**
     * Returns the Id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Returns the title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns the description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Returns the lines
     *
     * @return array<string>
     */
    public function getLinesToRender(): array
    {
        return $this->lines;
    }
}
