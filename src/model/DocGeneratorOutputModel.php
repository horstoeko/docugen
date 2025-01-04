<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\model;

use stdClass;
use horstoeko\docugen\model\traits\DocGeneratorModelHasOptionAttribute;
use horstoeko\docugen\model\traits\DocGeneratorCommonModelAttributesTrait;

/**
 * Class representing the model for a output definition
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorOutputModel extends DocGeneratorAbstractModel
{
    use DocGeneratorCommonModelAttributesTrait;
    use DocGeneratorModelHasOptionAttribute;

    /**
     * The documentation output type
     *
     * @var string
     */
    protected $outputType = "markdown";

    /**
     * The list of documentations to output
     *
     * @var string
     */
    protected $documentationId = "";

    /**
     * The subdirectory where to store the file
     *
     * @var string
     */
    protected $filePath = "";

    /**
     * The filename to use to store
     *
     * @var string
     */
    protected $fileName = "";

    /**
     * Indicator that file path is an absolute path
     *
     * @var boolean
     */
    protected $filePathIsAbsolute = false;

    /**
     * Indicator in which way the title should be inclued
     *
     * @var integer
     */
    protected $titleMode = 0;

    /**
     * Indicator in which way the description should be inclued
     *
     * @var integer
     */
    protected $descriptionMode = 0;

    /**
     * @inheritDoc
     */
    protected function fillAttributes(stdClass $modelData): void
    {
        $this->id = $modelData->id ?? "";
        $this->title = $modelData->title ?? "";
        $this->description = $modelData->description ?? "";
        $this->outputType = $modelData->outputtype ?? "markdown";
        $this->documentationId = $modelData->documentationid ?? "";
        $this->filePath = $modelData->filepath ?? "";
        $this->fileName = $modelData->filename ?? "";
        $this->filePathIsAbsolute = $modelData->filepathisabsolute ?? false;
        $this->titleMode = $modelData->titlemode ?? 0;
        $this->descriptionMode = $modelData->descriptionmode ?? 0;
        $this->options = array_column($modelData->options ?? [], "value", "id");
    }

    /**
     * Returns the type of the output
     *
     * @return string
     */
    public function getOutputType(): string
    {
        return $this->outputType;
    }

    /**
     * Returns the ID of the associated documentation
     *
     * @return string
     */
    public function getDocumentationId(): string
    {
        return $this->documentationId;
    }

    /**
     * Returns the subdirectory where to store the file
     *
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * Returns the filename to use to store
     *
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * Returns the indicator that file path is an absolute path
     *
     * @return boolean
     */
    public function getFilePathIsAbsolute(): bool
    {
        return $this->filePathIsAbsolute;
    }

    /**
     * Returns the indicator in which way the title should be inclued
     *
     * @return integer
     */
    public function getTitleMode(): int
    {
        return $this->titleMode;
    }

    /**
     * Returns the indicator in which way the description should be inclued
     *
     * @return integer
     */
    public function getDescriptionMode(): int
    {
        return $this->descriptionMode;
    }
}
