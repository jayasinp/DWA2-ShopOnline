<!--Pravin Mark Jayasinghe-->
<!--104182850-->
<!-- COS80021: Developing Web Applications -->
<!-- Project 2 -->

<!--utility.php generates unique ID for new auction item and checks if auction has expired-->

<?php
/*
 */

function getUniqueID($fileName, $itemNodeName, $itemIDNodeName)
{
    $xdoc = new DomDocument("1.0");
    $xdoc->Load($fileName);
    $ItemsNode = $xdoc->documentElement;
    $items = $xdoc->getElementsByTagName($itemNodeName);

    $idArray = [];
    foreach ($items as $node) {
        $itemIDNode = $node->getElementsByTagName($itemIDNodeName);
        $itemID = $itemIDNode->item(0)->nodeValue;
        $itemID = (int) $itemID;
        array_push($idArray, $itemID);
    }
    rsort($idArray);
    $result = ($idArray[0]) + 1;

    return $result;
}

function isDurationExpired($durTimeStr)
{
    $cdate = date("Y-m-d");
    $ctime = date("H:i:s");
    $currTimeStr = $cdate . " " . $ctime;
    $currTime = strtotime($currTimeStr);
    $durTime = strtotime($durTimeStr);
    $diff = $durTime - $currTime;
    if ($diff > 0) {
        return false;
    } else {
        return true;
    }

}


?>