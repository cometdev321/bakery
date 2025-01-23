<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); // Add DELETE here
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once '../db.php'; // Your database connection file

try {
    // Write the query to get all retail shops
    $query = "SELECT * FROM retail_shops";
    $stmt = $conn->query($query); // Execute the query

    // Check if we fetched any data
    $shops = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // If no shops found, return an empty array with success status
    if ($shops) {
        echo json_encode(["success" => true, "shops" => $shops]);
    } else {
        echo json_encode(["success" => false, "message" => "No shops found"]);
    }

} catch (PDOException $exception) {
    // Handle query execution errors
    echo json_encode(["success" => false, "message" => "Error data: " . $exception->getMessage()]);
}
?>
