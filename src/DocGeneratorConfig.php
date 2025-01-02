<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen;

use Exception as GlobalException;
use InvalidArgumentException;
use stdClass;
use horstoeko\docugen\exception\DocGeneratorFileNotFoundException;
use horstoeko\docugen\exception\DocGeneratorFileNotReadableException;
use horstoeko\docugen\exception\DocGeneratorInvalidJsonContentException;
use horstoeko\docugen\model\DocGeneratorBlockModelCollection;
use horstoeko\docugen\model\DocGeneratorCodeSnippetModelCollection;
use horstoeko\docugen\model\DocGeneratorDocumentationModelCollection;
use horstoeko\docugen\model\DocGeneratorOutputModelCollection;
use horstoeko\docugen\model\DocGeneratorTextModelCollection;
use Swaggest\JsonSchema\Exception;
use Swaggest\JsonSchema\InvalidValue;
use Swaggest\JsonSchema\Schema;

/**
 * Class representing the configration for DocGenerator
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorConfig
{
    /**
     * Collection of all code snippets
     *
     * @var DocGeneratorCodeSnippetModelCollection
     */
    private $docGeneratorCodeSnippetModelCollection;

    /**
     * Collection of all texts
     *
     * @var DocGeneratorTextModelCollection
     */
    private $docGeneratorTextModelCollection;

    /**
     * Collection of all blocks
     *
     * @var DocGeneratorBlockModelCollection
     */
    private $docGeneratorBlockModelCollection;

    /**
     * Collection of all documentations
     *
     * @var DocGeneratorDocumentationModelCollection
     */
    private $docGeneratorDocumentationModelCollection;

    /**
     * Collection of all outputs
     *
     * @var DocGeneratorOutputModelCollection
     */
    private $docGeneratorOutputModelCollection;

    /**
     * Load a config from a file containing a JSON
     *
     * @param  string $configFilename
     * @return DocGeneratorConfig
     * @throws DocGeneratorFileNotFoundException
     * @throws DocGeneratorFileNotReadableException
     * @throws DocGeneratorInvalidJsonContentException
     * @throws InvalidArgumentException
     * @throws Exception
     * @throws InvalidValue
     * @throws GlobalException
     */
    public static function loadFromFile(string $configFilename): DocGeneratorConfig
    {
        if (!file_exists($configFilename)) {
            throw new DocGeneratorFileNotFoundException($configFilename);
        }

        $jsonContent = file_get_contents($configFilename);

        if ($jsonContent === false) {
            throw new DocGeneratorFileNotReadableException($configFilename);
        }

        return static::loadFromJson($jsonContent);
    }

    /**
     * Load a config from a string containing a JSON
     *
     * @param  string $jsonContent
     * @return DocGeneratorConfig
     * @throws DocGeneratorInvalidJsonContentException
     * @throws InvalidArgumentException
     * @throws DocGeneratorFileNotFoundException
     * @throws DocGeneratorFileNotReadableException
     * @throws Exception
     * @throws InvalidValue
     * @throws GlobalException
     */
    public static function loadFromJson(string $jsonContent): DocGeneratorConfig
    {
        return new static($jsonContent);
    }

    /**
     * Constructor (hidden)
     *
     * @param  string $jsonContent
     * @return void
     * @throws DocGeneratorInvalidJsonContentException
     * @throws InvalidArgumentException
     * @throws DocGeneratorFileNotFoundException
     * @throws DocGeneratorFileNotReadableException
     * @throws Exception
     * @throws InvalidValue
     * @throws GlobalException
     */
    final protected function __construct(string $jsonContent)
    {
        $this->setJsonContent($jsonContent);
    }

    /**
     * Get a list of the defined code snippets
     *
     * @return DocGeneratorCodeSnippetModelCollection
     */
    public function getCodeSnippets(): DocGeneratorCodeSnippetModelCollection
    {
        return $this->docGeneratorCodeSnippetModelCollection;
    }

    /**
     * Get a list of the defined text parts
     *
     * @return DocGeneratorTextModelCollection
     */
    public function getTexts(): DocGeneratorTextModelCollection
    {
        return $this->docGeneratorTextModelCollection;
    }

    /**
     * Get a list of all blocks
     *
     * @return DocGeneratorBlockModelCollection
     */
    public function getBlocks(): DocGeneratorBlockModelCollection
    {
        return $this->docGeneratorBlockModelCollection;
    }

    /**
     * Get a list of the defined documentation objects
     *
     * @return DocGeneratorDocumentationModelCollection
     */
    public function getDocumentations(): DocGeneratorDocumentationModelCollection
    {
        return $this->docGeneratorDocumentationModelCollection;
    }

    /**
     * Get a list of the defined outputs
     *
     * @return DocGeneratorOutputModelCollection
     */
    public function getOutputs(): DocGeneratorOutputModelCollection
    {
        return $this->docGeneratorOutputModelCollection;
    }

    /**
     * Try to set the JSON config as a string. Validation will run immediately.
     *
     * @param  string $jsonContent
     * @return DocGeneratorConfig
     * @throws DocGeneratorInvalidJsonContentException
     * @throws InvalidArgumentException
     * @throws DocGeneratorFileNotFoundException
     * @throws DocGeneratorFileNotReadableException
     * @throws Exception
     * @throws InvalidValue
     * @throws GlobalException
     */
    protected function setJsonContent(string $jsonContent): DocGeneratorConfig
    {
        $jsonObject = json_decode($jsonContent);

        if (json_last_error() !== JSON_ERROR_NONE || !is_object($jsonObject)) {
            throw new DocGeneratorInvalidJsonContentException();
        }

        return $this->setJsonObject($jsonObject);
    }

    /**
     * Try to set the JSON config as an object. Validation will run immediately.
     *
     * @param  stdClass $jsonObject
     * @return DocGeneratorConfig
     * @throws InvalidArgumentException
     * @throws DocGeneratorFileNotFoundException
     * @throws DocGeneratorFileNotReadableException
     * @throws Exception
     * @throws InvalidValue
     * @throws GlobalException
     */
    protected function setJsonObject(stdClass $jsonObject): DocGeneratorConfig
    {
        if (!is_object($jsonObject)) {
            throw new InvalidArgumentException("Parameter should be an object");
        }

        $this->validateJsonObject($jsonObject);

        $this->docGeneratorCodeSnippetModelCollection = DocGeneratorCodeSnippetModelCollection::factory($jsonObject->codesnippets);
        $this->docGeneratorTextModelCollection = DocGeneratorTextModelCollection::factory($jsonObject->texts);
        $this->docGeneratorBlockModelCollection = DocGeneratorBlockModelCollection::factory($jsonObject->blocks);
        $this->docGeneratorDocumentationModelCollection = DocGeneratorDocumentationModelCollection::factory($jsonObject->documentations);
        $this->docGeneratorOutputModelCollection = DocGeneratorOutputModelCollection::factory($jsonObject->outputs);

        return $this;
    }

    /**
     * Validate a JSON object against the scheme
     *
     * @param  stdClass $jsonObject
     * @return void
     * @throws DocGeneratorFileNotFoundException
     * @throws DocGeneratorFileNotReadableException
     * @throws Exception
     * @throws InvalidValue
     * @throws GlobalException
     */
    protected function validateJsonObject(stdClass $jsonObject): void
    {
        $schemaJsonFilename = __DIR__ . "/assets/configschema.json";

        if (!file_exists($schemaJsonFilename)) {
            throw new DocGeneratorFileNotFoundException($schemaJsonFilename);
        }

        $schemaJsonContent = file_get_contents($schemaJsonFilename);

        if ($schemaJsonContent === false) {
            throw new DocGeneratorFileNotReadableException($schemaJsonFilename);
        }

        Schema::import(
            json_decode($schemaJsonContent),
        )->in(
            $jsonObject
        );
    }
}
