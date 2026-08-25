<?php
session_start();
include "K00319172db.php";

// Only allow customers to access the cart
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "customer") {
    echo "Access denied";
    exit();
}

// Get the logged in customer's ID
$user_id = $_SESSION["user_id"];

// Remove item from cart if remove link is clicked
if (isset($_GET["remove"])) {
    $product_id = $_GET["remove"];
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id=? AND product_id=?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
}

// Get all items in the customer's cart joined with product details
$stmt = $conn->prepare("
    SELECT products.id, products.name, products.price
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
?>

<hr>
<a href="K00319172register.php">Register</a> |
<a href="K00319172login.php">Login</a> |
<a href="K00319172seller.php">Seller</a> |
<a href="K00319172shop.php">Shop</a> |
<a href="K00319172cart.php">Cart</a> |
<a href="logout.php">Logout</a>
<hr>

<h2>Your Cart</h2>
<?php
// Display cart items in a table with remove option
echo "<table border='1'>";
echo "<tr><th>Name</th><th>Price</th><th>Action</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["name"] . "</td>";
    echo "<td>" . $row["price"] . "</td>";
    echo "<td><a href='?remove=" . $row["id"] . "'>Remove</a></td>";
    echo "</tr>";
    $total += $row["price"];
}

echo "</table>";

// Display total price of all items in cart
echo "<h3>Total: " . $total . "</h3>";

// Show checkout button only if cart has items
if ($total > 0) {
    echo "<a href='K00319172checkout.php'><button>Checkout</button></a>";
}
?>