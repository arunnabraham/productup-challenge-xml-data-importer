<?php
declare(strict_types=1);
namespace Arunnabraham\XmlDataImporter\Service\XMLParser;



class ProcessXML {

    public function processExport($node, $fp): void
    {
        $this->processResultToStream($node, $fp);
        $this->resetProcess();
    }

    private function resetProcess()
    {
        $this->processResultToStream(null, null, true);
    }

    private function processResultToStream(\DomNode|null $node, $fp, $reset = false): void
    {
        static $row = 0;
        static $column = 0;
        static $result = [];

        if ($reset === true || empty($node)) {
            $row = 0;
            $column = 0;
            $result = [];
            return;
        }
        try {
            $nodePath = pathinfo($node->getNodePath());

            if ($node->nodeType === XML_ELEMENT_NODE) {
                if ($node->hasChildNodes()) {
                    $children = $this->getNodeChildren($node->childNodes);

                    if (!empty($children)) {
                        foreach ($children as $childNode) {
                            $this->processResultToStream($childNode, $fp);
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
                    //file_put_contents(__DIR__ . '/temp.ndjson', json_encode($result) . PHP_EOL, FILE_APPEND);
                    $column = 0;
                    $row++;
                }
            }
        } catch (\Exception $e) {
            appLogger('error', 'Exception: '.$e->getMessage().PHP_EOL.'Trace: '.$e->getTraceAsString());
        } finally {
            appLogger('info', 'Process Ended');
        }
        return;
    }

    private function getNodeChildren(\DOMNodeList $childNodes): array
    {
        $i = 0;
        $children = [];
        while ($childNodes->length > $i) {
            $children[] = $childNodes->item($i);
            $i++;
        }
        return $children;
    }
}