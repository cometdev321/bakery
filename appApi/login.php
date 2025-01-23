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
                    // Prepare response with the driver id
                    $response = [
                        'success' => true,
                        'message' => 'Login successful',
                        'driver_id' => $user['id'], // Return the driver id
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
