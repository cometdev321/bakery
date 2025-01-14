<?php
header('Content-Type: application/json');
require_once '../db.php';

if (isset($_GET['delivery_id'])) {
    $deliveryId = intval($_GET['delivery_id']);

    try {
        // Fetch delivery info
        $query = "
            SELECT 
                d.line_man_id,
                lm.name AS line_man_name,
                lm.mobile AS line_man_phone,
                p.id AS product_id,
                p.name AS product_name,
                p.hsn,
                p.stock AS available_stock,
                dp.quantity AS assigned_quantity
            FROM deliveries d
            INNER JOIN line_men lm ON d.line_man_id = lm.id
            INNER JOIN delivery_products dp ON dp.delivery_id = d.id
            INNER JOIN products p ON dp.product_id = p.id
            WHERE d.id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$deliveryId]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            $response = [
                'line_man_id' => $result[0]['line_man_id'],
                'line_man_name' => $result[0]['line_man_name'],
                'line_man_phone' => $result[0]['line_man_phone'],
                'products' => array_map(function ($row) {
                    return [
                        'id' => $row['product_id'],
                        'name' => $row['product_name'],
                        'hsn' => $row['hsn'],
                        'available_stock' => $row['available_stock'],
                        'quantity' => $row['assigned_quantity']
                    ];
                }, $result)
            ];
            echo json_encode($response);
        } else {
            echo json_encode(['error' => 'Delivery not found.']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request.']);
}
?>
