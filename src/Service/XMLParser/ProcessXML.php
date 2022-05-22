<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\XMLParser;

use Arunnabraham\XmlDataImporter\Service\Metadata\WriteMetadataNdJSONService;

class ProcessXML
{

    /**
     * @param resource $fp
     */
    public function processExport(\DOMNode|false $node, $fp): void
    {
        $this->processResultToStream($node, $fp);
        $this->resetProcess();
    }

    private function resetProcess(): void
    {
        $this->processResultToStream(null, null, true);
    }

    private function processResultToStream(\DomNode|null $node, $fp, bool $reset = false): void
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
                    (new WriteMetadataNdJSONService($row, $result))
                        ->writeRowDataToStream($fp);
                    $column = 0;
                    $row++;
                }
            }
        } catch (\Exception $e) {
            appLogger('error', 'Exception: ' . $e->getMessage() . PHP_EOL . 'Trace: ' . $e->getTraceAsString());
        } finally {
            appLogger('info', 'Process Ended');
        }
        return;
    }

    /**
     * @return (\DOMNode|null)[]
     *
     * @psalm-return list<\DOMNode|null>
     */
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
