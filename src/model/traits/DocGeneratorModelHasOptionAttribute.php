<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\model\traits;

use horstoeko\docugen\utils\DocGeneratorObjectUtils;

/**
 * Trait representing handling of model option attribute
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
trait DocGeneratorModelHasOptionAttribute
{
    /**
     * The options
     *
     * @var array<string, mixed>
     */
    protected $options = [];

    /**
     * Return the options
     *
     * @return array<string, mixed>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Returns true if an option exists, otherwise false
     *
     * @param  string $option
     * @return boolean
     */
    public function hasOption(string $option): bool
    {
        return isset($this->options[$option]);
    }

    /**
     * Get a single option
     *
     * @param  string $option
     * @param  mixed  $default
     * @return mixed
     */
    public function getOption(string $option, $default)
    {
        return $this->getOptions()[$option] ?? $default;
    }

    /**
     * Return a string option value
     *
     * @param  string $option
     * @param  string $default
     * @return string
     */
    public function getStringOption(string $option, string $default = ""): string
    {
        return (string)$this->getOption($option, $default);
    }

    /**
     * Return a integer option value
     *
     * @param  string  $option
     * @param  integer $default
     * @return integer
     */
    public function getIntegerOption(string $option, int $default = 0): int
    {
        return (int)$this->getOption($option, $default);
    }

    /**
     * Return a float option value
     *
     * @param  string $option
     * @param  float  $default
     * @return float
     */
    public function getFloatOption(string $option, float $default = 0.0): float
    {
        return (float)$this->getOption($option, $default);
    }

    /**
     * Return a boolean option value
     *
     * @param  string  $option
     * @param  boolean $default
     * @return boolean
     */
    public function getBooleanOption(string $option, bool $default = false): bool
    {
        return (bool)$this->getOption($option, $default);
    }

    /**
     * Return a array option value
     *
     * @param  string $option
     * @param  array  $default
     * @return array
     */
    public function getArrayOption(string $option, array $default = []): array
    {
        return (array)$this->getOption($option, $default);
    }

    /**
     * Return a object option value
     *
     * @param  string $option
     * @param  array  $default
     * @return array
     */
    public function getObjectOption(string $option, array $default = []): array
    {
        return DocGeneratorObjectUtils::objectToArray($this->getOption($option, $default));
    }
}
