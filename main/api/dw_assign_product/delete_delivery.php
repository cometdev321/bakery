<?php
header('Content-Type: application/json');
require_once '../db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['delivery_id'])) {
    $deliveryId = intval($data['delivery_id']);

    try {
        // Begin transaction
        $conn->beginTransaction();

        // Delete products associated with the delivery
        $stmt = $conn->prepare("DELETE FROM delivery_products WHERE delivery_id = ?");
        $stmt->execute([$deliveryId]);


        $stmt = $conn->prepare("DELETE FROM delivery_product_updates WHERE delivery_id = ?");
        $stmt->execute([$deliveryId]);

        // Delete the delivery
        $stmt = $conn->prepare("DELETE FROM deliveries WHERE id = ?");
        $stmt->execute([$deliveryId]);

        // Commit transaction
        $conn->commit();

        echo json_encode(['message' => 'Delivery deleted successfully.']);
    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request.']);
}
?>
