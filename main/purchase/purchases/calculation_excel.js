function calculatefive(i) {
  // Read the amount from the <td> textContent
  var amount = parseFloat(
    document.getElementById("five_amount-" + i).textContent
  );
  const percentage = 0.05;
  let result = Math.round(((amount * percentage) / 2) * 100) / 100;
  document.getElementById("five_cgst-" + i).textContent = result; // Update textContent of CGST
  document.getElementById("five_sgst-" + i).textContent = result; // Update textContent of SGST
  callmajor();
}

function calculatetwelve(i) {
  var amount = parseFloat(
    document.getElementById("twelve_amount-" + i).textContent
  );
  const percentage = 0.12;
  let result = Math.round(((amount * percentage) / 2) * 100) / 100;
  document.getElementById("twelve_cgst-" + i).textContent = result;
  document.getElementById("twelve_sgst-" + i).textContent = result;
  callmajor();
}

function calculateighteen(i) {
  var amount = parseFloat(
    document.getElementById("eighteen_amount-" + i).textContent
  );
  const percentage = 0.18;
  let result = Math.round(((amount * percentage) / 2) * 100) / 100;
  document.getElementById("eighteen_cgst-" + i).textContent = result;
  document.getElementById("eighteen_sgst-" + i).textContent = result;
  callmajor();
}

function calculatetwenty(i) {
  var amount = parseFloat(
    document.getElementById("twenty_amount-" + i).textContent
  );
  const percentage = 0.28;
  let result = Math.round(((amount * percentage) / 2) * 100) / 100;
  document.getElementById("twenty_cgst-" + i).textContent = result;
  document.getElementById("twenty_sgst-" + i).textContent = result;
  callmajor();
}

function horizontalTotal() {
  var table = document.getElementById("Purchase-list");
  var tableRowcount = table.rows.length;
  const firstRow = table.rows[tableRowcount - 1];
  const rowId = firstRow.getAttribute("id");
  const rowNumber = rowId.replace(/\D/g, "");
  var total = 0;
  var gst = 0;
  for (var i = 1; i <= rowNumber; i++) {
    if (!document.getElementById("exempted-" + i)) {
      continue;
    }
    total +=
      parseFloat(document.getElementById("exempted-" + i).textContent) || 0;
    total +=
      parseFloat(document.getElementById("eighteen_amount-" + i).textContent) ||
      0;
    total +=
      parseFloat(document.getElementById("eighteen_igst-" + i).textContent) ||
      0;
    gst +=
      parseFloat(document.getElementById("eighteen_cgst-" + i).textContent) ||
      0;
    gst +=
      parseFloat(document.getElementById("eighteen_sgst-" + i).textContent) ||
      0;

    total +=
      parseFloat(document.getElementById("twelve_amount-" + i).textContent) ||
      0;
    gst +=
      parseFloat(document.getElementById("twelve_cgst-" + i).textContent) || 0;
    gst +=
      parseFloat(document.getElementById("twelve_sgst-" + i).textContent) || 0;

    total +=
      parseFloat(document.getElementById("five_amount-" + i).textContent) || 0;
    gst +=
      parseFloat(document.getElementById("five_cgst-" + i).textContent) || 0;
    gst +=
      parseFloat(document.getElementById("five_sgst-" + i).textContent) || 0;

    total +=
      parseFloat(document.getElementById("twenty_amount-" + i).textContent) ||
      0;
    gst +=
      parseFloat(document.getElementById("twenty_cgst-" + i).textContent) || 0;
    gst +=
      parseFloat(document.getElementById("twenty_sgst-" + i).textContent) || 0;

    var ro = parseFloat(document.getElementById("ro-" + i).textContent) || 0;
    var RowTotal = total + gst + ro;
    document.getElementById("total-" + i).textContent = RowTotal.toFixed(2);
    document.getElementById("gst-" + i).textContent = (gst / 2).toFixed(2); // Update GST textContent
    total = 0;
    gst = 0;
  }
}
let TotalBeforeRound = 0;
let GstBeforeRound = 0;

function verticalTotal() {
  var table = document.getElementById("Purchase-list");
  var tableRowcount = table.rows.length;
  const firstRow = table.rows[tableRowcount - 1];
  const rowId = firstRow.getAttribute("id");
  const rowNumber = rowId.replace(/\D/g, "");
  var exemptedTotal = 0;

  var eighteenTotal = 0;
  var eighteenIgst = 0;
  var eighteenCgst = 0;
  var eighteenSgst = 0;

  var twelveTotal = 0;
  var twelveCgst = 0;
  var twelveSgst = 0;

  var fiveTotal = 0;
  var fiveCgst = 0;
  var fiveSgst = 0;

  var twentyTotal = 0;
  var twentyCgst = 0;
  var twentySgst = 0;

  var total = 0;
  var gst = 0;
  for (var i = 1; i <= rowNumber; i++) {
    if (!document.getElementById("exempted-" + i)) {
      continue;
    }
    exemptedTotal +=
      parseFloat(document.getElementById("exempted-" + i).textContent) || 0;

    eighteenTotal +=
      parseFloat(document.getElementById("eighteen_amount-" + i).textContent) ||
      0;
    eighteenIgst +=
      parseFloat(document.getElementById("eighteen_igst-" + i).textContent) ||
      0;
    eighteenCgst +=
      parseFloat(document.getElementById("eighteen_cgst-" + i).textContent) ||
      0;
    eighteenSgst +=
      parseFloat(document.getElementById("eighteen_sgst-" + i).textContent) ||
      0;

    twelveTotal +=
      parseFloat(document.getElementById("twelve_amount-" + i).textContent) ||
      0;
    twelveCgst +=
      parseFloat(document.getElementById("twelve_cgst-" + i).textContent) || 0;
    twelveSgst +=
      parseFloat(document.getElementById("twelve_sgst-" + i).textContent) || 0;

    fiveTotal +=
      parseFloat(document.getElementById("five_amount-" + i).textContent) || 0;
    fiveCgst +=
      parseFloat(document.getElementById("five_cgst-" + i).textContent) || 0;
    fiveSgst +=
      parseFloat(document.getElementById("five_sgst-" + i).textContent) || 0;

    twentyTotal +=
      parseFloat(document.getElementById("twenty_amount-" + i).textContent) ||
      0;
    twentyCgst +=
      parseFloat(document.getElementById("twenty_cgst-" + i).textContent) || 0;
    twentySgst +=
      parseFloat(document.getElementById("twenty_sgst-" + i).textContent) || 0;

    total += parseFloat(document.getElementById("total-" + i).textContent) || 0;
    gst += parseFloat(document.getElementById("gst-" + i).textContent) || 0;
  }

  // Function to round values to nearest integer
  function roundToInteger(num) {
    return Math.round(num);
  }
  TotalBeforeRound =
    exemptedTotal + eighteenTotal + twelveTotal + fiveTotal + twentyTotal;

  GstBeforeRound =
    eighteenCgst +
    eighteenSgst +
    twelveCgst +
    twelveSgst +
    fiveCgst +
    fiveSgst +
    twentyCgst +
    twentySgst;

  total_exempted.textContent = roundToInteger(exemptedTotal);

  total_eighteen_amount.textContent = roundToInteger(eighteenTotal);
  total_eighteen_cgst.textContent = roundToInteger(eighteenCgst);
  total_eighteen_sgst.textContent = roundToInteger(eighteenSgst);

  total_twelve_amount.textContent = roundToInteger(twelveTotal);
  total_twelve_cgst.textContent = roundToInteger(twelveCgst);
  total_twelve_sgst.textContent = roundToInteger(twelveSgst);

  total_five_amount.textContent = roundToInteger(fiveTotal);
  total_five_cgst.textContent = roundToInteger(fiveCgst);
  total_five_sgst.textContent = roundToInteger(fiveSgst);

  total_twenty_amount.textContent = roundToInteger(twentyTotal);
  total_twenty_cgst.textContent = roundToInteger(twentyCgst);
  total_twenty_sgst.textContent = roundToInteger(twentySgst);

  total_total.textContent = roundToInteger(total);
  total_gst.textContent = gst.toFixed(2);
}

function calculateTotal() {
  var totalPurchase = 0;
  var totalPurchaseInput = 0;
  var finalTotal = 0;

  totalPurchase += parseFloat(total_exempted.textContent) || 0;
  totalPurchase += parseFloat(total_eighteen_amount.textContent) || 0;
  totalPurchaseInput += parseFloat(total_eighteen_cgst.textContent) || 0;
  totalPurchaseInput += parseFloat(total_eighteen_sgst.textContent) || 0;

  totalPurchase += parseFloat(total_twelve_amount.textContent) || 0;
  totalPurchaseInput += parseFloat(total_twelve_cgst.textContent) || 0;
  totalPurchaseInput += parseFloat(total_twelve_sgst.textContent) || 0;

  totalPurchase += parseFloat(total_five_amount.textContent) || 0;
  totalPurchaseInput += parseFloat(total_five_cgst.textContent) || 0;
  totalPurchaseInput += parseFloat(total_five_sgst.textContent) || 0;

  totalPurchase += parseFloat(total_twenty_amount.textContent) || 0;
  totalPurchaseInput += parseFloat(total_twenty_cgst.textContent) || 0;
  totalPurchaseInput += parseFloat(total_twenty_sgst.textContent) || 0;

  purchases.textContent = TotalBeforeRound.toFixed(2);
  totalpurchaseinput.textContent = GstBeforeRound.toFixed(2);
  finaltotal.textContent = (TotalBeforeRound + GstBeforeRound).toFixed(2);

  purchases.textContent = TotalBeforeRound.toFixed(2);
  totalpurchaseinput.textContent =
    parseFloat(document.getElementById("total_gst").textContent) * 2;
  purchaseValue = parseFloat(document.getElementById("purchases").textContent);
  purchaseInput = parseFloat(
    document.getElementById("totalpurchaseinput").textContent
  );
  finaltotal.textContent = (purchaseValue + purchaseInput).toFixed(2);
}
