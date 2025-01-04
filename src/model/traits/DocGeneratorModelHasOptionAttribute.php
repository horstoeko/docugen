<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\model\traits;

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
    public function getStringOptions(string $option, string $default): string
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
    public function getIntegerOptions(string $option, int $default): int
    {
        return (int)$this->getOption($option, $default);
    }

    /**
     * Return a boolean option value
     *
     * @param  string  $option
     * @param  boolean $default
     * @return boolean
     */
    public function getBooleanOptions(string $option, bool $default): bool
    {
        return (bool)$this->getOption($option, $default);
    }
}
