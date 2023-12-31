<!--Pravin Mark Jayasinghe-->
<!--104182850-->
<!-- COS80021: Developing Web Applications -->
<!-- Project 2 -->

<!--b_buynow.php handles the user's request to buy an item in an online auction-->

<?php
/*check session data for seller ID
 */
session_start();
header('Content-Type: text/xml');
$HTML = "";
require_once "utility.php";


if (!isset($_SESSION["custID"])) {
    $HTML = "<br><span class='failed'>Please log in first to buy!!<span/><br/>";
} else {
    $bidderID = $_SESSION["custID"];
    if (isset($_POST["itemID"])) {
        $itemID = $_POST["itemID"];
        // $bidprice = $_POST["bidprice"];

        $r_dom = DOMDocument::load("../../data/auction.xml");
        $items = $r_dom->getElementsByTagName("ListedItem");


        foreach ($items as $r_item) {
            //read the itemID of an item that match the requested itemID
            $r_itemIDNode = $r_item->getElementsByTagName("ItemID");
            $r_itemIDNodeValue = $r_itemIDNode->item(0)->nodeValue;
            if ($r_itemIDNodeValue == $itemID) {
                //read the three nodes that are impacted by these transaction
                $r_statusNode = $r_item->getElementsByTagName("Status");
                $r_statusNodeValue = $r_statusNode->item(0)->nodeValue;

                $r_durationNode = $r_item->getElementsByTagName("Duration");
                $r_durationNodeValue = $r_durationNode->item(0)->nodeValue;

                $r_bidpriceNode = $r_item->getElementsByTagName("BidPrice");
                $r_bidpriceNodeValue = $r_bidpriceNode->item(0)->nodeValue;

                $r_buynowpriceNode = $r_item->getElementsByTagName("BuyItNowPrice");
                $r_buynowpriceNodeValue = $r_buynowpriceNode->item(0)->nodeValue;

                $r_bidderIDNode = $r_item->getElementsByTagName("BidderID");
                $r_bidderIDNodeValue = $r_bidderIDNode->item(0)->nodeValue;

                if (isDurationExpired($r_durationNodeValue)) {
                    $HTML = "<br><span class='failed'>Sorry, Auction expired!!<span/><br/>";
                } else {
                    if ($r_statusNodeValue == "sold") {
                        $HTML = "<br><span class='failed'>Sorry, the item is sold!!.<span/><br/>";
                    } else {
                        $HTML = "<br><span class='confirmed'>Thank you for purchasing Item No. $itemID<span/><br/>";
                        $r_bidpriceNode->item(0)->nodeValue = $r_buynowpriceNodeValue; //update new bid price
                        $r_bidderIDNode->item(0)->nodeValue = $bidderID; //update new bidder ID
                        $r_statusNode->item(0)->nodeValue = "sold"; //update new status
                    }
                }
            }
        }

        $savedcorrectly = $r_dom->save("../../data/auction.xml");
    }
}
echo $HTML;



?>