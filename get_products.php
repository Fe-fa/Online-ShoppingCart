<?php
header("Content-Type: application/json");
$conn = new mysqli("localhost", "root", "", "classic_store");

if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}
$category = isset($_GET['category']) ? trim($_GET['category']) : "";
if (!empty($category)) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ? ORDER BY id DESC");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM products ORDER BY id DESC");
}
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
echo json_encode($products);
$conn->close();
?>
