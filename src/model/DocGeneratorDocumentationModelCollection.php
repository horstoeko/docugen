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
class DocGeneratorDocumentationModelCollection extends DocGeneratorAbstractModelCollection
{
    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return DocGeneratorDocumentationModel::class;
    }

    /**
     * Find a block by it's id
     *
     * @param  string $id
     * @return DocGeneratorDocumentationModel|null
     */
    public function findById(string $id): ?DocGeneratorDocumentationModel
    {
        /**
         * @var DocGeneratorDocumentationModel|null $docGeneratorAbstractModel
         */
        $docGeneratorAbstractModel = $this->findByAttribute("id", $id);

        return $docGeneratorAbstractModel;
    }

    /**
     * Find a block by it's id. When not found an Exception is raised
     *
     * @param  string $id
     * @return DocGeneratorDocumentationModel
     * @throws RuntimeException
     */
    public function findByIdOrFail(string $id): DocGeneratorDocumentationModel
    {
        /**
         * @var DocGeneratorDocumentationModel $docGeneratorAbstractModel
         */
        $docGeneratorAbstractModel = $this->findByAttributeOrFail("id", $id);

        return $docGeneratorAbstractModel;
    }
}
