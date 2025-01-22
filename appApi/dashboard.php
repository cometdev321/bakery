<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once './db.php'; // Include your database connection script

$response = [];

// Check if the request method is GET and driver_id is provided
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['driver_id'])) {
    $driver_id = $_GET['driver_id'];

    // Validate the driver_id
    if ($driver_id) {
        try {
            // Fetch the assigned deliveries for the driver from the delivery_product_updates table
            $delivery_stmt = $conn->prepare("
                SELECT 
                    dpu.id AS update_id,
                    dpu.delivery_id, 
                    p.id AS product_id,
                    p.name AS product_name,
                    p.hsn AS product_hsn,
                    p.price AS product_price,
                    dpu.original_quantity,
                    dpu.updated_quantity,
                    (p.price * dpu.updated_quantity) AS total_price,
                    dpu.delivery_status
                FROM delivery_product_updates dpu
                JOIN deliveries d ON dpu.delivery_id = d.id
                JOIN products p ON dpu.product_id = p.id
                WHERE d.line_man_id = :line_man_id AND d.status = 1
            ");
            $delivery_stmt->bindValue(':line_man_id', $driver_id, PDO::PARAM_INT);
            $delivery_stmt->execute();
            $deliveries = $delivery_stmt->fetchAll(PDO::FETCH_ASSOC);

            // Initialize an array to group deliveries by delivery_id
            $grouped_deliveries = [];

            foreach ($deliveries as $delivery) {
                if (!isset($grouped_deliveries[$delivery['delivery_id']])) {
                    $grouped_deliveries[$delivery['delivery_id']] = [
                        'delivery_id' => $delivery['delivery_id'],
                        'products' => [],
                        'individual_total' => 0
                    ];
                }

                // Add product to the grouped delivery
                $grouped_deliveries[$delivery['delivery_id']]['products'][] = [
                    'product_id' => $delivery['product_id'],
                    'product_name' => $delivery['product_name'],
                    'product_hsn' => $delivery['product_hsn'],
                    'product_price' => $delivery['product_price'],
                    'original_quantity' => $delivery['original_quantity'],
                    'updated_quantity' => $delivery['updated_quantity'],
                    'total_price' => $delivery['total_price'],
                    'delivery_status' => $delivery['delivery_status']
                ];

                // Add the total price to the individual total for this delivery
                $grouped_deliveries[$delivery['delivery_id']]['individual_total'] += $delivery['total_price'];
            }

            // Flatten the grouped deliveries into an array
            $unique_deliveries = array_values($grouped_deliveries);

            // Prepare response with deliveries
            $response = [
                'success' => true,
                'deliveries' => $unique_deliveries // Deliveries for the driver
            ];
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ];
        }
    } else {
        $response = [
            'success' => false,
            'message' => 'Driver ID is required'
        ];
    }
} else {
    $response = [
        'success' => false,
        'message' => 'Invalid request method or missing driver ID'
    ];
}

// Send the response as JSON
echo json_encode($response);
?>
