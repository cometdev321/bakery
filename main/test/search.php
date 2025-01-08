<?php
 include('../common/cnn.php');
 include('../common/session_control.php');

if (isset($_POST['query'])) {
    $query = $conn->real_escape_string($_POST['query']);

    // Search for matching party names
    $sql = "SELECT name FROM tblparty WHERE name LIKE '$query%' order by name ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<ul>';
        while($row = $result->fetch_assoc()) {
            echo '<div class="suggestion-box">' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</div>';
        }
        echo '</ul>';
    } else {
        // If no matching names, show an option to add new
        echo '<button id="addNewPartyButton">No matching parties. Press Enter to add "' . htmlspecialchars($query, ENT_QUOTES, 'UTF-8') . '"</button>';
    }
} elseif (isset($_POST['new_party'])) {
    $new_party = $conn->real_escape_string($_POST['new_party']);

    // Add new party to database
    $sql = "INSERT INTO tblparty (name,userID) VALUES ('$new_party','$session')";
    if ($conn->query($sql) === TRUE) {
        echo "New party added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
