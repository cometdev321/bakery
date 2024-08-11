<?php
 include('../../common/cnn.php');
 include('../../common/session_control.php');

if (isset($_POST['query'])) {
    $query = $conn->real_escape_string($_POST['query']);

    // Search for matching party names
    $sql = "SELECT name,mobno,id FROM tblparty WHERE name LIKE '$query%' and userID='$session' order by name  ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<ul>';
        while($row = $result->fetch_assoc()) {
            echo '<div class="suggestion-box" data-id="' . $row['id'] . '" data-mobno="' . $row['mobno'] . '">' . $row['name'] . ' </div>';
        }
        echo '</ul>';
    } else {
        // If no matching names, show an option to add new
        echo '<button type="button" onclick="addNewParty()" id="addNewPartyButton">No matching parties. Press Enter to add "' . htmlspecialchars($query, ENT_QUOTES, 'UTF-8') . '"</button>';
    }
} elseif (isset($_POST['new_party'])) {
    $new_party = $conn->real_escape_string($_POST['new_party']);

    // Check if the party already exists
    $check_sql = "SELECT * FROM tblparty WHERE name = '$new_party'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['id'];
    } else {
        // Add new party to the database
        $sql = "INSERT INTO tblparty (name, userID) VALUES ('$new_party', '$session')";
        if ($conn->query($sql) === TRUE) {
        // Get the ID of the last inserted record
        $last_id = $conn->insert_id;
        echo $last_id;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
