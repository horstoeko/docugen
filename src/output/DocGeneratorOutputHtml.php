<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\output;

use League\CommonMark\GithubFlavoredMarkdownConverter;

/**
 * Class representing the HTML outputter
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorOutputHtml extends DocGeneratorOutputMarkdown
{
    /**
     * @inheritDoc
     */
    protected function afterAllBlocks(): DocGeneratorOutputAbstract
    {
        $converter = new GithubFlavoredMarkdownConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $this->getDocGeneratorOutputBuffer()->processLines(
            function (string $line) use ($converter) {
                return $converter->convert($line);
            }
        );

        return $this;
    }
}
