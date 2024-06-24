// Excel export function
document.getElementById("exportButton").addEventListener("click", function () {
  exportTableToCSV("sales_transactions.csv");
});

function exportTableToCSV(filename) {
  var csv = [];
  var rows = document.querySelectorAll("table tr");

  for (var i = 0; i < rows.length; i++) {
    var row = [],
      cols = rows[i].querySelectorAll("td, th");

    for (var j = 0; j < cols.length; j++) {
      // Clean data by removing special characters and formatting
      var cellData = cols[j].innerText.trim();
      cellData = cleanData(cellData);
      row.push(cellData);
    }

    csv.push(row.join(","));
  }

  // Download CSV
  downloadCSV(csv.join("\n"), filename);
}

function cleanData(data) {
  // Remove currency symbols, arrows, or any special characters
  // Example: Removing ₹ symbol, and ↓ symbol
  return data.replace(/₹/g, "").replace(/↓/g, "").trim();
}

function downloadCSV(csv, filename) {
  var csvFile;
  var downloadLink;

  // CSV file
  csvFile = new Blob([csv], { type: "text/csv" });

  // Download link
  downloadLink = document.createElement("a");

  // File name
  downloadLink.download = filename;

  // Create a link to the file
  downloadLink.href = window.URL.createObjectURL(csvFile);

  // Hide link
  downloadLink.style.display = "none";

  // Add the link to the DOM
  document.body.appendChild(downloadLink);

  // Click the link
  downloadLink.click();
}

// PDF export function
document.getElementById("pdfButton").addEventListener("click", function () {
  exportTableToPDF("sales_transactions.pdf");
});

function exportTableToPDF(filename) {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  var rows = document.querySelectorAll("table tr");
  var tableData = [];

  for (var i = 0; i < rows.length; i++) {
    var row = [],
      cols = rows[i].querySelectorAll("td, th");

    for (var j = 0; j < cols.length; j++) {
      var cellData = cols[j].innerText.trim();
      cellData = cleanData(cellData);
      row.push(cellData);
    }

    tableData.push(row);
  }

  // Add table data to PDF
  doc.autoTable({
    head: [tableData[0]], // Use the first row as the header
    body: tableData.slice(1), // Use the rest of the rows as the body
  });

  // Save the PDF
  doc.save(filename);
}
