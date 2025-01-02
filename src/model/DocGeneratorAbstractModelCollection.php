<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\model;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use RuntimeException;
use Traversable;

/**
 * Class representing the base class of all model collections
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
abstract class DocGeneratorAbstractModelCollection implements ArrayAccess, IteratorAggregate
{
    /**
     * The models within this collection
     *
     * @var array
     */
    private $models = [];

    /**
     * Create a collection from data array
     *
     * @param  array $collectionData
     * @return static
     */
    public static function factory(array $collectionData)
    {
        return new static($collectionData);
    }

    /**
     * Constructor (hidden)
     *
     * @param array $collectionData
     */
    final protected function __construct(array $collectionData)
    {
        $this->buildModels($collectionData);
    }

    /**
     * Create a model instance based on the class based on the class
     * delivery by getModelClass method
     *
     * @param  array $collectionData
     * @return void
     */
    protected function buildModels(array $collectionData): void
    {
        foreach ($collectionData as $collectionDataItem) {
            $this->models[] = $this->getModelClass()::factory($collectionDataItem);
        }
    }

    /**
     * Get the class name of the model to instanciate
     *
     * @return string
     */
    abstract protected function getModelClass(): string;

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return isset($this->models[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset): mixed
    {
        return $this->models[$offset] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->models[] = $value;
        } else {
            $this->models[$offset] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset): void
    {
        unset($this->models[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->models);
    }

    /**
     * Execute a callback over each model in this collection
     *
     * @param  callable $callback
     * @return DocGeneratorAbstractModelCollection
     */
    public function each(callable $callback): DocGeneratorAbstractModelCollection
    {
        foreach ($this as $modelKey => $model) {
            if ($callback($model, $modelKey) === false) {
                break;
            }
        }

        return $this;
    }

    /**
     * Find a model by it's property and the value of the property
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return null|DocGeneratorAbstractModel
     */
    public function findByAttribute(string $attribute, $value): ?DocGeneratorAbstractModel
    {
        $result = null;

        if (!property_exists($this->getModelClass(), $attribute)) {
            return $result;
        }

        $this->each(
            function ($model) use ($attribute, $value, &$result) {
                $getterMethodName = sprintf('get%s', ucfirst($attribute));

                if (method_exists($model, $getterMethodName) && $model->$getterMethodName() == $value) {
                    $result = $model;
                    return false;
                }
            }
        );

        return $result;
    }

    /**
     * Find a model by it's property and the value of the property. If model was not found an RuntimeException is raises
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return DocGeneratorAbstractModel
     * @throws RuntimeException
     */
    public function findByAttributeOrFail(string $attribute, $value): DocGeneratorAbstractModel
    {
        $model = $this->findByAttribute($attribute, $value);

        if (is_null($model)) {
            throw new \RuntimeException("Model not found");
        }

        return $model;
    }
}
