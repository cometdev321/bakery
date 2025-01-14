<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../db.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $query = "
                SELECT 
            d.id AS delivery_id,
            lm.name AS line_man_name,
            lm.mobile AS line_man_phone,
            p.name AS product_name,
            dp.quantity AS product_quantity,
            dp.product_id
        FROM deliveries d
        INNER JOIN line_men lm ON d.line_man_id = lm.id
        INNER JOIN delivery_products dp ON dp.delivery_id = d.id
        INNER JOIN products p ON dp.product_id = p.id
        WHERE d.status = 1
        ORDER BY d.id;
        ";

    $stmt = $conn->prepare($query);
    $stmt->execute();

    $deliveries = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (!isset($deliveries[$row['delivery_id']])) {
            $deliveries[$row['delivery_id']] = [
                'id' => $row['delivery_id'],
                'lineManName' => $row['line_man_name'],
                'lineManPhone' => $row['line_man_phone'],
                'products' => []
            ];
        }
        $deliveries[$row['delivery_id']]['products'][] = [
            'id' => $row['product_id'],
            'name' => $row['product_name'],
            'quantity' => $row['product_quantity']
        ];
    }

    $response = json_encode(array_values($deliveries));
    if ($response === false) {
        echo json_encode(['error' => 'Failed to encode JSON.']);
    } else {
        echo $response;
    }
} catch (Exception $e) {
    // Log the error
    error_log("Error fetching deliveries: " . $e->getMessage());
    // Display the error message in the response
    echo json_encode(['error' => 'An error occurred while fetching deliveries. Details: ' . $e->getMessage()]);
}
?>
