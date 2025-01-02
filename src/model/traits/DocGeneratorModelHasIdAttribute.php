<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\model\traits;

/**
 * Trait representing handling of model ID attribute
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
trait DocGeneratorModelHasIdAttribute
{
    /**
     * The block id
     *
     * @var string
     */
    protected $id = "";

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
     * Check if the given $id matches the current model ID attribute
     *
     * @param  string $id
     * @return boolean
     */
    public function isId(string $id): bool
    {
        return strcasecmp($this->getId(), $id) === 0;
    }
}
