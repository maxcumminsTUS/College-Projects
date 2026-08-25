<?php
session_start();
include "K00319172db.php";


if (isset($_GET["logout"])) {
    echo "<p style='color:green;'>Logout successful!</p>";
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Look up user by username using prepared statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify password against hashed value stored in database
    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["role"] = $user["role"];
        echo "<p>Login successful!</p>";
    } else {
        echo "<p>Invalid login</p>";
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

<h2>Login</h2>
<form method="POST">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <button type="submit">Login</button>
</form>