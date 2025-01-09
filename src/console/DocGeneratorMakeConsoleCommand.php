<?php

/**
 * This file is a part of horstoeko/docugen.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\console;

use horstoeko\docugen\DocGenerator;
use horstoeko\docugen\DocGeneratorConfig;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class representing the "make" console command
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorMakeConsoleCommand extends DocGeneratorBaseConsoleCommand
{
    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setName('docugen:make')
            ->setDescription('Generate the documentation')
            ->setHelp('Generate the documentation')
            ->addOption('config', null, InputOption::VALUE_REQUIRED, 'The location of the config file', '');
    }

    /**
     * @inheritDoc
     */
    protected function doExecute(): int
    {
        $docGeneratorConfig = DocGeneratorConfig::loadFromFile($this->inputInterface->getOption('config'));

        DocGenerator::factory($docGeneratorConfig)->build();

        return DocGeneratorBaseConsoleCommand::SUCCESS;
    }
}
