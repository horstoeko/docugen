<?php

/**
 * This file is a part of horstoeko/docugen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\docugen\output;

use Mpdf\Mpdf;
use Mpdf\Config\FontVariables;
use Mpdf\Config\ConfigVariables;
use horstoeko\stringmanagement\PathUtils;

/**
 * Class representing the PDF outputter
 *
 * @category DocuGen
 * @package  DocuGen
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/docugen
 */
class DocGeneratorOutputPdf extends DocGeneratorOutputHtml
{
    /**
     * @inheritDoc
     */
    public function outputToFile(): DocGeneratorOutputAbstract
    {
        $filepath = $this->getDocGeneratorOutputModel()->getFilePathIsAbsolute()
            ? $this->getDocGeneratorOutputModel()->getFilePath()
            : PathUtils::combinePathWithPath(
                $this->getDocGeneratorConfig()->getRootDirectory(),
                $this->getDocGeneratorOutputModel()->getFilePath()
            );

        $filenameToOutput = PathUtils::combinePathWithFile($filepath, $this->getDocGeneratorOutputModel()->getFileName());

        $mpdf = $this->instanciatePdfEngine();
        $mpdf->OutputFile($filenameToOutput);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function outputToScreen(): DocGeneratorOutputAbstract
    {
        $mpdf = $this->instanciatePdfEngine();

        echo $mpdf->OutputBinaryData();

        return $this;
    }

    /**
     * Get an instance of the MPDF-Class
     *
     * @return Mpdf
     */
    private function instanciatePdfEngine(): Mpdf
    {
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $defaultFontDirectories = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $defaultFontData = $defaultFontConfig['fontdata'];

        $customFontDirectory = $this->getDocGeneratorOutputModel()->getArrayOption('fontdirectories');
        $customFontData = $this->getDocGeneratorOutputModel()->getObjectOption('fontdata');
        $customFontDefault = $this->getDocGeneratorOutputModel()->getStringOption('defaultfont', 'dejavusans');
        $customPaperSize = $this->getDocGeneratorOutputModel()->getStringOption('papersize', 'A4-P');
        $customPdfAEnabled = $this->getDocGeneratorOutputModel()->getBooleanOption('pdfa', false);

        $config = [
            'tempDir' => sys_get_temp_dir() . '/mpdf',
            'fontDir' => array_merge($defaultFontDirectories, $customFontDirectory),
            'fontdata' => $defaultFontData + $customFontData,
            'default_font' => $customFontDefault,
            'format' => $customPaperSize,
            'PDFA' => $customPdfAEnabled,
            'PDFAauto' => $customPdfAEnabled,
        ];

        $mpdf = new Mpdf($config);
        $mpdf->WriteHTML(implode(PHP_EOL, $this->getDocGeneratorOutputBuffer()->getLines()));

        return $mpdf;
    }
}
