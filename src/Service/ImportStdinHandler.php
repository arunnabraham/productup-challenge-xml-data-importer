<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service;

class ImportStdinHandler
{

    public function recieveAndWriteTempOfInputStream()
    {
        $inputStream = STDIN;
        //if (stream_select([&$inputStream], null, null, 0) === 1) {
        $tmpStream = tmpfile();
        while (!feof($inputStream)) {
            fwrite($tmpStream, fread(STDIN, 1), 1);
        }
        fclose(STDIN);
        return $tmpStream;
        // }
        //return null;
    }
}
