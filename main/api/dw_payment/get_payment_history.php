<?php
header('Content-Type: application/json');

// Database connection
include('../db.php'); // Replace with your database connection file

try {
    // Query to fetch payment history, including line man details and trip information
    $query = "
        SELECT 
            pr.id,
            lm.name AS lineManName,
            lm.mobile AS lineManPhone,
            pr.delivery_id,
            pr.amount_paid AS amount,
            pr.payment_date AS date
        FROM 
            payment_records pr
        INNER JOIN 
            deliveries t ON pr.delivery_id = t.id  -- Join payment_records with deliveries table
        INNER JOIN 
            line_men lm ON t.line_man_id = lm.id  -- Join deliveries with line_men table
        ORDER BY 
            pr.payment_date DESC
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Fetch all payment records
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return payment records as JSON
    echo json_encode($payments);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to fetch payment history. Error: ' . $e->getMessage()]);
}

$conn = null; // Close the database connection
?>
