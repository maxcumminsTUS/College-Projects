<?php
session_start();
include "K00319172db.php";

// Only allow customers to access the shop
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "customer") {
    echo "Access denied";
    exit();
}

$message = "";

// Handle adding a product to the cart
if (isset($_GET["add"])) {
    $product_id = $_GET["add"];
    $user_id = $_SESSION["user_id"];

    // Check if item is already in cart to enforce 1 item limit per product
    $check = $conn->prepare("SELECT * FROM cart WHERE user_id=? AND product_id=?");
    $check->bind_param("ii", $user_id, $product_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows == 0) {
        // Add item to cart if not  present
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $message = "Added to cart!";
    } else {
        $message = "Already in cart!";
    }
}
?>

<hr>
<a href="K00319172register.php">Register</a> |
<a href="K00319172login.php">Login</a> |
<a href="K00319172seller.php">Seller</a> |
<a href="K00319172shop.php">Shop</a> |
<a href="K00319172cart.php">Cart</a> |
<a href="logout.php">Logout</a>
<hr>

<h2>Products</h2>
<?php if ($message != "") echo "<p>$message</p>"; ?>

<?php
// Display all available products with price and add to cart option
$result = $conn->query("SELECT * FROM products");
echo "<table border='1'>";
echo "<tr><th>Name</th><th>Price</th><th>Action</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["name"] . "</td>";
    echo "<td>" . $row["price"] . "</td>";
    echo "<td><a href='?add=" . $row["id"] . "'>Add to cart</a></td>";
    echo "</tr>";
}
echo "</table>";
?>