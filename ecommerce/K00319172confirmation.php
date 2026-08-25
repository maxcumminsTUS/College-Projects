<?php
session_start();
include "K00319172db.php";


if (!isset($_SESSION["role"]) || $_SESSION["role"] != "customer") {
    echo "Access denied";
    exit();
}

// Get the order ID passed from checkout
$order_id = $_GET["order_id"];
?>

<hr>
<a href="K00319172register.php">Register</a> |
<a href="K00319172login.php">Login</a> |
<a href="K00319172seller.php">Seller</a> |
<a href="K00319172shop.php">Shop</a> |
<a href="K00319172cart.php">Cart</a> |
<a href="logout.php">Logout</a>
<hr>

<h2>Order Confirmed!</h2>
<?php
echo "Order ID: " . $order_id . "<br>";

// Fetch all products in this order
$stmt = $conn->prepare("
    SELECT products.name, products.price
    FROM order_items
    JOIN products ON order_items.product_id = products.id
    WHERE order_items.order_id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;

// Display each ordered item and calculate total
while ($row = $result->fetch_assoc()) {
    echo "Product: " . $row["name"] . " | Price: " . $row["price"] . "<br>";
    $total += $row["price"];
}

echo "<h3>Total Paid: " . $total . "</h3>";
?>