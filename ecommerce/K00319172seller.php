<?php
session_start();
include "K00319172db.php";

// Only allow sellers to access this page
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "seller") {
    echo "Access denied";
    exit();
}

// Remove a product if remove link is clicked
if (isset($_GET["remove"])) {
    $product_id = $_GET["remove"];

    // Delete from order_items first to avoid foreign key constraint error
    $stmt = $conn->prepare("DELETE FROM order_items WHERE product_id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();

    // Remove from any customer carts
    $stmt = $conn->prepare("DELETE FROM cart WHERE product_id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();

  
    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    echo "<p>Product removed!</p>";
}

// Add a new product if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $seller_id = $_SESSION["user_id"];
    $stmt = $conn->prepare("INSERT INTO products (name, price, seller_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sdi", $name, $price, $seller_id);
    $stmt->execute();
    echo "<p>Product added!</p>";
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

<h2>Add Product</h2>
<form method="POST">
    Name: <input type="text" name="name"><br>
    Price: <input type="number" step="0.01" name="price"><br>
    <button type="submit">Add</button>
</form>

<h2>All Products</h2>
<?php
// Display all products with option to remove
$result = $conn->query("SELECT * FROM products");
echo "<table border='1'>";
echo "<tr><th>Name</th><th>Price</th><th>Action</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["name"] . "</td>";
    echo "<td>" . $row["price"] . "</td>";
    echo "<td><a href='?remove=" . $row["id"] . "'>Remove</a></td>";
    echo "</tr>";
}
echo "</table>";
?>

<h2>Orders</h2>
<?php
// Display all orders with customer details
$result = $conn->query("
    SELECT orders.id AS order_id, users.username
    FROM orders
    JOIN users ON orders.user_id = users.id
");
echo "<table border='1'>";
echo "<tr><th>Order ID</th><th>Customer</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["order_id"] . "</td>";
    echo "<td>" . $row["username"] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>