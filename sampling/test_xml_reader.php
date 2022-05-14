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
    putNodeResultToStream($node, $fp);
    rewind($fp);
    $str = stream_get_contents($fp);
    var_dump(explode(PHP_EOL, $str));
    fclose($fp);
    return $str;
}

function putNodeResultToStream(\DomNode $node, $fp): void
{
    $nodePath = pathinfo($node->getNodePath());

    if ($node->nodeType === XML_ELEMENT_NODE) {
        if ($node->hasChildNodes()) {
            $children = getNodeChildren($node->childNodes);

            if (!empty($children)) {
                foreach ($children as $childNode) {
                    putNodeResultToStream($childNode, $fp);
                }
                /*
                SEPARATOR NODE START;
                 */
                //rewind($fp);
                //echo stream_get_contents($fp);

                $nodePathBaseName = pathinfo($node->getNodePath(), PATHINFO_BASENAME);
               if(!empty($node->nextSibling->nodeName))
               {
                   if((int)preg_match('/^(\w+)(\[\d+])$/i',$nodePathBaseName)===0) //parent path ignore
                   {
                      /* if($init===0){
                       echo $node->nodeName; //header
                       } else {
                           $node->nodeValue; //rows
                       } */
                       fputs($fp,$node->nodeValue.'[:-:]');
                   } else {
                       fputs($fp,PHP_EOL);
                   }
               }
                //file_put_contents('text.test', PHP_EOL.stream_get_contents($fp), FILE_APPEND);
                //ftruncate($fp,0);
                /*
                SEPARATOR NODE START;
                 */
            }
        } else {
            // $result[$nodePath['basename']] = $node->nodeValue;
          /*  if (strlen(trim($node->nodeValue)) > 0) {
                fputs($fp, $nodePath['basename'] . '|~ => ~|');
            } */
        }
    } else {
       /* if ($nodePath['basename'] === 'text()') {
            if (strlen(trim($node->nodeValue)) > 0) {
                $nodePathSplit = explode("/", $nodePath['dirname']);
                fputs($fp, end($nodePathSplit) . '|~ => ~|' . $node->nodeValue);
                // $result[end($nodePathSplit)] = $node->nodeValue;
                unset($nodePathSplit);
            }
        } */
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