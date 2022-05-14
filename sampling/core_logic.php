<?php
    if($node->nodeType === XML_ELEMENT_NODE)
    {
        $result = [];
        //var_dump($node->nodeName);
        if($node->hasChildNodes())
        {
            
            for($i=0; $i<$node->childNodes->length; $i++)
            {
                if($node->childNodes->item($i)->nodeType === XML_ELEMENT_NODE)
                {
                 //echo   $node->childNodes->item($i)->nodeName;
                 $nodeChild = $node->childNodes->item($i);
                 if($nodeChild->hasChildNodes())
                 {
                     for($j=0; $j<$nodeChild->childNodes->length; $j++)
                     {
                         if($nodeChild->childNodes->item($j)->nodeType === XML_ELEMENT_NODE)
                         {
                             if(!$nodeChild->childNodes->item($j)->hasChildNodes());
                             {
                                 $nodeKey = pathinfo($nodeChild->childNodes->item($j)->getNodePath(), PATHINFO_BASENAME);//end(explode("/",$nodeChild->childNodes->item($j)->getNodePath()));
                                 $result[$nodeKey] = $nodeChild->childNodes->item($j)->nodeValue;
                             }
                           // echo $nodeChild->childNodes->item($j)->nodeValue.PHP_EOL;
                         } else {
                            //echo $nodeChild->childNodes->item($j)->parentNode->nodeValue;
                         }
                     }
                 }
                } elseif($node->childNodes->item($i)->nodeType === XML_TEXT_NODE) {
                   // echo  $node->childNodes->item($i)->nodeValue;
                }
                if(!empty($result))
                    $data[] = $result;
            }
        }
    }