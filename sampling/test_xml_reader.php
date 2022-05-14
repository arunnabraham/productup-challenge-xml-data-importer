<?php
$reader = new XMLReader;
$location = 'file:///home/arun/work/Intreview/ProductsUp/productup-challenge-xml-data-importer/xml-samples/employee.xml'; //__DIR__ .'/../xml-samples/employee.xml';
//echo strlen(file_get_contents($location))/1024;
$reader->open($location);
while ($reader->read()) {
    $node = $reader->expand();
    $strData = getNodeData($node);
    $reader->next();
}
$reader->close();

function getNodeData($node): string
{
    $fp = fopen('php://memory', 'rw');
    putNodeResultToStream($node,$fp);
    rewind($fp);
    $str = stream_get_contents($fp);
    var_dump(explode(PHP_EOL.'[###]', $str));
    fclose($fp);
    return $str;
}

function putNodeResultToStream(\DomNode $node,$fp): void
{
    $nodePath = pathinfo($node->getNodePath());
    if ($node->nodeType === XML_ELEMENT_NODE) {
        if ($node->hasChildNodes()) {
            $children = getNodeChildren($node->childNodes);

            if (!empty($children)) {
                foreach ($children as $childNode) {
                    putNodeResultToStream($childNode, $fp);
                }
            }
        } else {
           // $result[$nodePath['basename']] = $node->nodeValue;
            fputs($fp, $nodePath['basename'] . '|~ => ~|' . $node->nodeValue);
        }
        fputs($fp,PHP_EOL.'[####]');
    } else {
        if ($nodePath['basename'] === 'text()') {
            $nodePathSplit = explode("/", $nodePath['dirname']);
            fputs($fp, end($nodePathSplit) . '|~ => ~|' . $node->nodeValue);
           // $result[end($nodePathSplit)] = $node->nodeValue;
            unset($nodePathSplit);
        }
    }
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

//echo $strData;