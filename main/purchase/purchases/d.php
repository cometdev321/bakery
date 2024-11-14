<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert/Update Test</title>
</head>
<body>

<h2>Test Insert and Update Operations</h2>

<form id="testForm">
    <label for="date">Date:</label>
    <input type="date" id="date" name="date" required><br><br>

    <label for="billno">Bill No:</label>
    <input type="text" id="billno" name="billno" required><br><br>

    <label for="exempted">Exempted Amount:</label>
    <input type="number" id="exempted" name="exempted" required><br><br>

    <label for="eighteen_amount">18% Amount:</label>
    <input type="number" id="eighteen_amount" name="eighteen_amount" required><br><br>

    <label for="eighteen_cgst">18% CGST:</label>
    <input type="number" id="eighteen_cgst" name="eighteen_cgst" required><br><br>

    <label for="eighteen_sgst">18% SGST:</label>
    <input type="number" id="eighteen_sgst" name="eighteen_sgst" required><br><br>

    <label for="type">Operation Type:</label>
    <select id="type" name="type" required>
        <option value="insert">Insert</option>
        <option value="update">Update</option>
    </select><br><br>

    <label for="purchaseID">Purchase ID (Only for Update):</label>
    <input type="number" id="purchaseID" name="purchaseID"><br><br>

    <button type="button" onclick="sendData()">Submit</button>
</form>

<div id="response"></div>

<script>
function sendData() {
    const formData = {
        records: [
            {
                date: document.getElementById('date').value,
                billno: document.getElementById('billno').value,
                exempted: document.getElementById('exempted').value,
                eighteen_amount: document.getElementById('eighteen_amount').value,
                eighteen_cgst: document.getElementById('eighteen_cgst').value,
                eighteen_sgst: document.getElementById('eighteen_sgst').value,
                type: document.getElementById('type').value,
                purchaseID: document.getElementById('purchaseID').value || null
            }
        ]
    };
console.log(formData)
    fetch('../../get_ajax/headpurchases/remove_item.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('response').innerText = JSON.stringify(data, null, 2);
    })
    .catch(error => {
        document.getElementById('response').innerText = 'Error: ' + error;
    });
}
</script>

</body>
</html>
