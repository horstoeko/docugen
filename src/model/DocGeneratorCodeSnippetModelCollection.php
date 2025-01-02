<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\model;

/**
 * Class representing the a collection of code snippets
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorCodeSnippetModelCollection extends DocGeneratorAbstractModelCollection
{
    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return DocGeneratorCodeSnippetModel::class;
    }

    /**
     * Find a code snippet by it's id
     *
     * @param  string $id
     * @return DocGeneratorCodeSnippetModel|null
     */
    public function findById(string $id): ?DocGeneratorCodeSnippetModel
    {
        /**
         * @var DocGeneratorCodeSnippetModel|null $textModel
         */
        $textModel = $this->findByAttribute("id", $id);

        return $textModel;
    }
}
