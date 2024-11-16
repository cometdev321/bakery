function calculatefive(i) {
  var amount = parseFloat(document.getElementById("five_amount-" + i).value);
  const percentage = 0.05;
  let result = Math.round(((amount * percentage) / 2) * 100) / 100;
  document.getElementById("five_cgst-" + i).value = result;
  document.getElementById("five_sgst-" + i).value = result;
  callmajor();
}

function calculatetwelve(i) {
  var amount = parseFloat(document.getElementById("twelve_amount-" + i).value);
  const percentage = 0.12;
  let result = Math.round(((amount * percentage) / 2) * 100) / 100;
  document.getElementById("twelve_cgst-" + i).value = result;
  document.getElementById("twelve_sgst-" + i).value = result;
  callmajor();
}

function calculateighteen(i) {
  var amount = parseFloat(
    document.getElementById("eighteen_amount-" + i).value
  );
  const percentage = 0.18;
  let result = Math.round(((amount * percentage) / 2) * 100) / 100;
  document.getElementById("eighteen_cgst-" + i).value = result;
  document.getElementById("eighteen_sgst-" + i).value = result;
  callmajor();
}

function calculatetwenty(i) {
  var amount = parseFloat(document.getElementById("twenty_amount-" + i).value);
  const percentage = 0.28;
  let result = Math.round(((amount * percentage) / 2) * 100) / 100;
  document.getElementById("twenty_cgst-" + i).value = result;
  document.getElementById("twenty_sgst-" + i).value = result;
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
    total += parseFloat(document.getElementById("exempted-" + i)?.value) || 0;

    total +=
      parseFloat(document.getElementById("eighteen_amount-" + i)?.value) || 0;
    gst +=
      parseFloat(document.getElementById("eighteen_cgst-" + i)?.value) || 0;
    gst +=
      parseFloat(document.getElementById("eighteen_sgst-" + i)?.value) || 0;

    total +=
      parseFloat(document.getElementById("twelve_amount-" + i)?.value) || 0;
    gst += parseFloat(document.getElementById("twelve_cgst-" + i)?.value) || 0;
    gst += parseFloat(document.getElementById("twelve_sgst-" + i)?.value) || 0;

    total +=
      parseFloat(document.getElementById("five_amount-" + i)?.value) || 0;
    gst += parseFloat(document.getElementById("five_cgst-" + i)?.value) || 0;
    gst += parseFloat(document.getElementById("five_sgst-" + i)?.value) || 0;

    total +=
      parseFloat(document.getElementById("twenty_amount-" + i)?.value) || 0;
    gst += parseFloat(document.getElementById("twenty_cgst-" + i)?.value) || 0;
    gst += parseFloat(document.getElementById("twenty_sgst-" + i)?.value) || 0;

    document.getElementById("total-" + i).value = (total + gst).toFixed(2);
    document.getElementById("gst-" + i).value = (gst / 2).toFixed(2);
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
      parseFloat(document.getElementById("exempted-" + i)?.value) || 0;
    eighteenTotal +=
      parseFloat(document.getElementById("eighteen_amount-" + i)?.value) || 0;
    eighteenCgst +=
      parseFloat(document.getElementById("eighteen_cgst-" + i)?.value) || 0;
    eighteenSgst +=
      parseFloat(document.getElementById("eighteen_sgst-" + i)?.value) || 0;
    twelveTotal +=
      parseFloat(document.getElementById("twelve_amount-" + i)?.value) || 0;
    twelveCgst +=
      parseFloat(document.getElementById("twelve_cgst-" + i)?.value) || 0;
    twelveSgst +=
      parseFloat(document.getElementById("twelve_sgst-" + i)?.value) || 0;
    fiveTotal +=
      parseFloat(document.getElementById("five_amount-" + i)?.value) || 0;
    fiveCgst +=
      parseFloat(document.getElementById("five_cgst-" + i)?.value) || 0;
    fiveSgst +=
      parseFloat(document.getElementById("five_sgst-" + i)?.value) || 0;
    twentyTotal +=
      parseFloat(document.getElementById("twenty_amount-" + i)?.value) || 0;
    twentyCgst +=
      parseFloat(document.getElementById("twenty_cgst-" + i)?.value) || 0;
    twentySgst +=
      parseFloat(document.getElementById("twenty_sgst-" + i)?.value) || 0;
    total += parseFloat(document.getElementById("total-" + i)?.value) || 0;
    gst += parseFloat(document.getElementById("gst-" + i)?.value) || 0;
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
  // Assign rounded values to respective fields
  document.getElementById("total_exempted").value =
    roundToInteger(exemptedTotal);
  document.getElementById("total_eighteen_amount").value =
    roundToInteger(eighteenTotal);
  document.getElementById("total_eighteen_cgst").value =
    roundToInteger(eighteenCgst);
  document.getElementById("total_eighteen_sgst").value =
    roundToInteger(eighteenSgst);
  document.getElementById("total_twelve_amount").value =
    roundToInteger(twelveTotal);
  document.getElementById("total_twelve_cgst").value =
    roundToInteger(twelveCgst);
  document.getElementById("total_twelve_sgst").value =
    roundToInteger(twelveSgst);
  document.getElementById("total_five_amount").value =
    roundToInteger(fiveTotal);
  document.getElementById("total_five_cgst").value = roundToInteger(fiveCgst);
  document.getElementById("total_five_sgst").value = roundToInteger(fiveSgst);
  document.getElementById("total_twenty_amount").value =
    roundToInteger(twentyTotal);
  document.getElementById("total_twenty_cgst").value =
    roundToInteger(twentyCgst);
  document.getElementById("total_twenty_sgst").value =
    roundToInteger(twentySgst);

  document.getElementById("total_total").value = roundToInteger(total);
  document.getElementById("total_gst").value = gst.toFixed(2);
}

function calculateTotal() {
  var totalPurchase = 0;
  var totalPurchaseInput = 0;
  var finalTotal = 0;

  totalPurchase += parseFloat(total_exempted.value) || 0;
  totalPurchase += parseFloat(total_eighteen_amount.value) || 0;
  totalPurchaseInput += parseFloat(total_eighteen_cgst.value) || 0;
  totalPurchaseInput += parseFloat(total_eighteen_sgst.value) || 0;

  totalPurchase += parseFloat(total_twelve_amount.value) || 0;
  totalPurchaseInput += parseFloat(total_twelve_cgst.value) || 0;
  totalPurchaseInput += parseFloat(total_twelve_sgst.value) || 0;

  totalPurchase += parseFloat(total_five_amount.value) || 0;
  totalPurchaseInput += parseFloat(total_five_cgst.value) || 0;
  totalPurchaseInput += parseFloat(total_five_sgst.value) || 0;

  totalPurchase += parseFloat(total_twenty_amount.value) || 0;
  totalPurchaseInput += parseFloat(total_twenty_cgst.value) || 0;
  totalPurchaseInput += parseFloat(total_twenty_sgst.value) || 0;

  purchases.value = TotalBeforeRound.toFixed(2);
  totalpurchaseinput.value = GstBeforeRound.toFixed(2);
  finaltotal.value = (TotalBeforeRound + GstBeforeRound).toFixed(2);
}

function callmajor() {
  horizontalTotal();
  verticalTotal();
  calculateTotal();
}
