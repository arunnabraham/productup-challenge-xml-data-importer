<?php
$reader = new XMLReader;
$location = __DIR__ .'/../xml-samples/employee.xml';

$reader->open($location);
while ($reader->read()) {
    $node = $reader->expand();
    $destination = exportData($node, 'json', __DIR__ . '/../outputfiles', 'data.json');
    $reader->next();
}
$reader->close();

function processJSON($outputDir, $filename, $sourceResource)
{
    try {
        $location = $outputDir . '/' . $filename;
        if(file_exists($location))
        {
            unlink($location);
        }
        $destinationResource = fopen($location, 'a');
        $isFirstSeek = true;
        if (!is_resource($destinationResource)) {
            throw new Exception('Invalid Destination Resouces');
        }
        if (!is_resource($sourceResource)) {
            throw new Exception('Invalid Source Resouce');
        }
        rewind($sourceResource);
        while (!feof($sourceResource)) {
            $data = fgets($sourceResource);
            if ($isFirstSeek) {
                $delimiter = '[';
            } else {
                $delimiter = ',';
            }
            fwrite($destinationResource, $delimiter . $data);
            $isFirstSeek = false;
        }
        fwrite($destinationResource, ']');
    } catch (\Exception $e) {
        return false;
    }
    fclose($destinationResource);
    return true;
}
function processCSV($outputDir, $filename, $sourceResource): bool
{
    try {
        $location = $outputDir . '/' . $filename;
        $destinationResource = fopen($location, 'w');
        $isFirstLine = true;
        if (!is_resource($destinationResource)) {
            throw new Exception('Invalid Destination Resouces');
        }
        if (!is_resource($sourceResource)) {
            throw new Exception('Invalid Source Resouce');
        }
        rewind($sourceResource);
        while (!feof($sourceResource)) {
            $data = json_decode(fgets($sourceResource), true);
            if (!empty($data)) {
                $callArrayFn = $isFirstLine ? 'array_keys' : 'array_values';
                $fputStatus = fputcsv($destinationResource, $callArrayFn($data));
                if ($isFirstLine) {
                    //Insert initial values
                    fputcsv($destinationResource, array_values($data));
                }
                if ($fputStatus === false) {
                    throw new Exception('Error in csv processing');
                }
                $isFirstLine = false;
            }
        }
    } catch (\Exception $e) {
        return false;
    }
    fclose($destinationResource);
    return true;
}

function exportData(DomNode $node, string $mode, string $outputDir, string $filename): string|bool
{
    $fp = fopen('php://memory', 'rw');
    processExport($node, $fp);
    rewind($fp);
    file_put_contents($outputDir . '/' . $filename.'.ndjson',stream_get_contents($fp));
    $str = '';
    if ($mode === 'csv') {
        $status = processCSV($outputDir, $filename, $fp);
        if ($status) {
            $str = $outputDir . '/' . $filename;
        }
    }
    if ($mode === 'json') {
        $status = processJSON($outputDir, $filename, $fp);
        if ($status) {
            $str = $outputDir . '/' . $filename;
        }
    }
    fclose($fp);
    $filePathOutput = realpath($str);
    return is_string(realpath($str)) ? 'file://' . $filePathOutput : $filePathOutput;
}

function processExport($node, $fp): void
{
    processResultToStream($node, $fp);
    resetProcess();
}

function resetProcess()
{
    processResultToStream(null, null, true);
}

function processResultToStream(\DomNode|null $node, $fp, $reset = false): void
{
    static $row = 0;
    static $column = 0;
    static $result = [];

    if ($reset === true) {
        $row = 0;
        $column = 0;
        $result = [];
        return;
    }
    try {
        $nodePath = pathinfo($node->getNodePath());

        if ($node->nodeType === XML_ELEMENT_NODE) {
            if ($node->hasChildNodes()) {
                $children = getNodeChildren($node->childNodes);

                if (!empty($children)) {
                    foreach ($children as $childNode) {
                        processResultToStream($childNode, $fp);
                    }
                }
            }
        }
        if (preg_match('/^text\(\)(\[\d+])$/u', $nodePath['basename']) === 0 && $nodePath['basename'] !== 'text()') {
            if ((int)preg_match('/^(\w+)(\[\d+])$/i', $nodePath['basename']) === 0) {
                $result[$nodePath['basename']] = $node->nodeValue;
                $column++;
            } else {
                $delimiter = $row > 0 ? PHP_EOL : '';
                fputs($fp, $delimiter . json_encode($result));
                $column = 0;
                $row++;
            }
        }
    } catch (\Exception $e) {
        //echo 'Error Found';
    } finally {
        //echo 'Process end';
    }
    return;
}

function getNodeChildren(\DOMNodeList $childNodes): array
{
    $i = 0;
    $children = [];
    while ($childNodes->length > $i) {
        $children[] = $childNodes->item($i);
        $i++;
    }
    return $children;
}

echo $destination !== false ? $destination : 'No File Created';
echo PHP_EOL;
echo memory_get_peak_usage()/1024/1024;
