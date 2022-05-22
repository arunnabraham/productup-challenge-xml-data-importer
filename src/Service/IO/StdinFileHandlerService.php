<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\IO;

class StdinFileHandlerService
{
    /**
     * @return false|resource
     */
    public function recieveAndWriteTempOfInputStream()
    {
        $inputStream = STDIN;
        $tmpStream = tmpfile();
        while (!feof($inputStream)) {
            fwrite($tmpStream, fread(STDIN, 1), 1);
        }
        fclose($inputStream);
        return $tmpStream;
    }
}
