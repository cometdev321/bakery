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

    document.getElementById("total-" + i).value = total + gst;
    document.getElementById("gst-" + i).value = gst / 2;
    total = 0;
    gst = 0;
  }
}

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

  total_exempted.value = exemptedTotal;

  total_eighteen_amount.value = eighteenTotal;
  total_eighteen_cgst.value = eighteenCgst;
  total_eighteen_sgst.value = eighteenSgst;

  total_twelve_amount.value = twelveTotal;
  total_twelve_cgst.value = twelveCgst;
  total_twelve_sgst.value = twelveSgst;

  total_five_amount.value = fiveTotal;
  total_five_cgst.value = fiveCgst;
  total_five_sgst.value = fiveSgst;

  total_twenty_amount.value = twentyTotal;
  total_twenty_cgst.value = twentyCgst;
  total_twenty_sgst.value = twentySgst;

  total_total.value = total;
  total_gst.value = gst;
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

  purchases.value = totalPurchase;
  totalpurchaseinput.value = totalPurchaseInput;
  finaltotal.value = totalPurchase + totalPurchaseInput;
}

function callmajor() {
  horizontalTotal();
  verticalTotal();
  calculateTotal();
}
