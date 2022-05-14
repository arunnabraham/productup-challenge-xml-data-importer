<?php
$reader = new XMLReader;
$location = 'file:///home/arun/work/Intreview/ProductsUp/productup-challenge-xml-data-importer/xml-samples/employee.xml'; //__DIR__ .'/../xml-samples/employee.xml';
$reader->open($location);
while ($reader->read()) {
    $node = $reader->expand();
    $data = getNodeResult($node);
    $reader->next();
}
$reader->close();

function getNodeResult(\DomNode $node, $isChild = false)
{
    $nodePath = pathinfo($node->getNodePath());
    if ($node->nodeType === XML_ELEMENT_NODE) {
        if ($node->hasChildNodes()) {
            $children = getNodeChildren($node->childNodes);

            if (!empty($children)) {
                foreach ($children as $childNode) {
                    getNodeResult($childNode);
                }
            }
        } else {
            echo $nodePath['basename'] . '|~ => ~|' . $node->nodeValue.PHP_EOL;
        }
    } else {
        if ($nodePath['basename'] === 'text()') {
            echo $nodePath['dirname'] . '|~ => ~|' . $node->nodeValue.PHP_EOL;
        }
    }
    return $data ?? [];
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

echo json_encode($data);
