<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once './db.php'; // Include your database connection script

$response = [];

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate input
    if (isset($input['mobileNumber']) && isset($input['password'])) {
        $mobile_number = $input['mobileNumber']; // Use mobileNumber key from frontend
        $password = $input['password'];

        try {
            // Prepare a statement to check the credentials
            $stmt = $conn->prepare("SELECT id, name, mobile, role, status FROM line_men WHERE mobile = :mobile AND password = :password");
            $stmt->bindValue(':mobile', $mobile_number, PDO::PARAM_STR);  // Bind the mobile number
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);  // Bind the password
            $stmt->execute();

            // Check if a matching record is found
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Check if the user's status is active
                if ($user['status'] == 1) {
                    // Fetch the assigned deliveries for the driver (where status = 1, already delivered)
                    $delivery_stmt = $conn->prepare("
                        SELECT 
                            d.id AS delivery_id, 
                            p.id AS product_id,
                            p.name AS product_name,
                            p.price AS product_price,
                            dp.quantity AS product_quantity,
                            (p.price * dp.quantity) AS total_price
                        FROM deliveries d
                        JOIN delivery_products dp ON d.id = dp.delivery_id
                        JOIN products p ON dp.product_id = p.id
                        WHERE d.line_man_id = :line_man_id AND d.status = 1
                    ");
                    $delivery_stmt->bindValue(':line_man_id', $user['id'], PDO::PARAM_INT);
                    $delivery_stmt->execute();
                    $deliveries = $delivery_stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Initialize an array to group deliveries by delivery_id
                    $grouped_deliveries = [];

                    foreach ($deliveries as $delivery) {
                        // Group deliveries by delivery_id
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
                            'product_price' => $delivery['product_price'],
                            'product_quantity' => $delivery['product_quantity'],
                            'total_price' => $delivery['total_price']
                        ];

                        // Add the total price to the individual total
                        $grouped_deliveries[$delivery['delivery_id']]['individual_total'] += $delivery['total_price'];
                    }

                    // Flatten the grouped deliveries into an array
                    $unique_deliveries = array_values($grouped_deliveries);

                    // Prepare response
                    $response = [
                        'success' => true,
                        'message' => 'Login successful',
                        'employee' => $user,  // Include user data
                        'token' => bin2hex(random_bytes(16)), // Generate a random token
                        'deliveries' => $unique_deliveries // Include unique deliveries
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'Account is inactive. Please contact support.'
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Invalid mobile number or password'
                ];
            }
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ];
        }
    } else {
        $response = [
            'success' => false,
            'message' => 'Mobile number and password are required'
        ];
    }
} else {
    $response = [
        'success' => false,
        'message' => 'Invalid request method'
    ];
}

// Send the response as JSON
echo json_encode($response);
?>
