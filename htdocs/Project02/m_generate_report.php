<!--Pravin Mark Jayasinghe-->
<!--104182850-->
<!-- COS80021: Developing Web Applications -->
<!-- Project 2 -->

<!--m_generate_report.php generates a list of auction items-->
<?php


header('Content-Type: text/xml');

$xmlDoc = new DomDocument;
$xmlDoc->load("../../data/auction.xml");
$xslDoc = new DomDocument;
$xslDoc->load("../../data/auction.xsl");
$proc = new XSLTProcessor;
$proc->importStyleSheet($xslDoc);
echo $proc->transformToXML($xmlDoc);
removeSoldandFailed();


function removeSoldandFailed()
{

    $r_dom = DOMDocument::load("../../data/auction.xml");
    $itemsList = $r_dom->getElementsByTagName("ListedItem");


    $nodesToRemove = [];
    foreach ($itemsList as $node) {
        $r_statusNode = $node->getElementsByTagName("Status");
        $r_statusNodeValue = $r_statusNode->item(0)->nodeValue;
        if (($r_statusNodeValue == 'sold') || ($r_statusNodeValue == 'failed')) {
            array_push($nodesToRemove, $node);
        }
    }

    foreach ($nodesToRemove as $node) {
        $node->parentNode->removeChild($node);
    }

    $savedcorrectly = $r_dom->save("../../data/auction.xml");
}



?>