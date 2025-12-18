<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Anda harus login untuk melakukan transaksi.']);
    exit;
}

include '../connection.php';

$user_id = $_SESSION['user_id'];
$price = isset($_POST['price']) ? intval($_POST['price']) : 0;

if ($price <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Harga tidak valid.']);
    exit;
}

try {
    $stmt = $conn->prepare("INSERT INTO transaksi (user_id, price, is_verified, created_at) VALUES (?, ?, 'Unverified',  NOW())");
    if (!$stmt) {
        throw new Exception("Prepare statement gagal: " . $conn->error);
    }

    $stmt->bind_param("ii", $user_id, $price);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Transaksi gagal disimpan.']);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan transaksi.', 'debug' => $e->getMessage()]);
}
?>
