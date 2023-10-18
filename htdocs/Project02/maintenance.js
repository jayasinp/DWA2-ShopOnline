/**
 * Pravin Mark Jayasinghe
 * COS80021: Developing Web Applications
 * Project 2
 * maintenance.js allows admins to view processed auction items and produce reports
 */

"use strict";

var xHRObject = false;

if (window.XMLHttpRequest) xHRObject = new XMLHttpRequest();
else if (window.ActiveXObject)
  xHRObject = new ActiveXObject("Microsoft.XMLHTTP");

function generateReport() {
  //translated from XML to XSL
  xHRObject.open("POST", "m_generate_report.php", true);
  xHRObject.setRequestHeader(
    "Content-Type",
    "application/x-www-form-urlencoded"
  );
  xHRObject.onreadystatechange = getData;
  xHRObject.send();
}

function getData() {
  //translated from XML to XSL
  if (xHRObject.readyState == 4 && xHRObject.status == 200) {
    var serverResponse = xHRObject.responseText;
    var spantag = document.getElementById("report");
    spantag.innerHTML = serverResponse;
  }
}

function processAuctionItems() {
  xHRObject.open("POST", "m_process_auction_items.php", true);
  xHRObject.setRequestHeader(
    "Content-Type",
    "application/x-www-form-urlencoded"
  );
  xHRObject.onreadystatechange = getConfirmation;
  xHRObject.send();
}

function getConfirmation() {
  if (xHRObject.readyState == 4 && xHRObject.status == 200) {
    document.getElementById("processAuctionItemsConfirmation").innerHTML =
      xHRObject.responseText;
  }
}
