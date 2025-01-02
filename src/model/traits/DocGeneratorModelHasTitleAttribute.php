<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\model\traits;

/**
 * Trait representing handling of model title attribute
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
trait DocGeneratorModelHasTitleAttribute
{
    /**
     * The block title
     *
     * @var string
     */
    protected $title = "";

    /**
     * Returns the title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
