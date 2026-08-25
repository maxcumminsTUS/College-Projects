<?php
session_start();
include "K00319172db.php";

// Only allow customers to access checkout
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "customer") {
    exit("Access denied");
}

$user_id = $_SESSION["user_id"];

// Create a new order for the customer
$stmt = $conn->prepare("INSERT INTO orders (user_id) VALUES (?)");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$order_id = $conn->insert_id;

// Fetch all items from the customer's cart
$stmt = $conn->prepare("SELECT product_id FROM cart WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Move each cart item into order_items
while ($row = $result->fetch_assoc()) {
    $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, product_id) VALUES (?, ?)");
    $stmt2->bind_param("ii", $order_id, $row["product_id"]);
    $stmt2->execute();
}

// Clear the cart and redirect to confirmation
$stmt = $conn->prepare("DELETE FROM cart WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

header("Location: K00319172confirmation.php?order_id=" . $order_id);
exit();