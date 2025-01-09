<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\model;

use RuntimeException;

/**
 * Class representing the a collection of documentations
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorBlockModelCollection extends DocGeneratorAbstractModelCollection
{
    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return DocGeneratorBlockModel::class;
    }

    /**
     * Find a block by it's id
     *
     * @param  string $id
     * @return DocGeneratorBlockModel|null
     */
    public function findById(string $id): ?DocGeneratorBlockModel
    {
        /**
         * @var DocGeneratorBlockModel|null $docGeneratorAbstractModel
         */
        $docGeneratorAbstractModel = $this->findByAttribute("id", $id);

        return $docGeneratorAbstractModel;
    }

    /**
     * Find a block by it's id. When not found an Exception is raised
     *
     * @param  string $id
     * @return DocGeneratorBlockModel
     * @throws RuntimeException
     */
    public function findByIdOrFail(string $id): DocGeneratorBlockModel
    {
        /**
         * @var DocGeneratorBlockModel $docGeneratorAbstractModel
         */
        $docGeneratorAbstractModel = $this->findByAttributeOrFail("id", $id);

        return $docGeneratorAbstractModel;
    }
}
