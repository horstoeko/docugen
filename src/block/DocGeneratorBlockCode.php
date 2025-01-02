<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\block;

/**
 * Class representing a code documentation block
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorBlockCode extends DocGeneratorBlockAbstract
{
    /**
     * @inheritDoc
     */
    public function build(): DocGeneratorBlockAbstract
    {
        foreach ($this->getDocGeneratorBlockModel()->getLines() as $blockLine) {
            $this->getDocGeneratorLineParser()->parseLine($blockLine);
        }

        return $this;
    }
}
