<?php
header('Content-Type: application/json');

// Database connection
include('../db.php'); // Replace with your database connection file

// Check if either line_man_id or delivery_id is provided
if (!isset($_GET['line_man_id']) && !isset($_GET['delivery_id'])) {
    echo json_encode(['success' => false, 'message' => 'Either Line man ID or Delivery ID is required.']);
    exit;
}

$line_man_id = isset($_GET['line_man_id']) ? intval($_GET['line_man_id']) : null;
$delivery_id = isset($_GET['delivery_id']) ? intval($_GET['delivery_id']) : null;

try {
    if ($line_man_id) {
        // Query to fetch deliveries by line_man_id
        $query = "
            SELECT 
                d.id AS delivery_id,
                SUM(dp.quantity * p.price) AS total_amount
            FROM 
                deliveries d
            INNER JOIN 
                delivery_products dp ON d.id = dp.delivery_id
            INNER JOIN 
                products p ON dp.product_id = p.id
            WHERE 
                d.line_man_id = :line_man_id
            GROUP BY 
                d.id
        ";
        
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':line_man_id', $line_man_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch delivery records
        $deliveries = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'data' => $deliveries]);

    } elseif ($delivery_id) {
        // Query to fetch a single delivery by delivery_id
        $query = "
            SELECT 
                d.id AS delivery_id,
                SUM(dp.quantity * p.price) AS total_amount
            FROM 
                deliveries d
            INNER JOIN 
                delivery_products dp ON d.id = dp.delivery_id
            INNER JOIN 
                products p ON dp.product_id = p.id
            WHERE 
                d.id = :delivery_id
            GROUP BY 
                d.id
        ";
        
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':delivery_id', $delivery_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch delivery record
        $delivery = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($delivery) {
            echo json_encode(['success' => true, 'data' => [$delivery]]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Delivery not found.']);
        }
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to fetch deliveries. Error: ' . $e->getMessage()]);
}

$conn = null; // Close the connection
?>
