<?php
try {
    $conn = new mysqli('localhost', 'root', '', 'simple_crud');
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo "<h2>Login Successful!</h2>";
            echo "<pre>User data: " . print_r($user, true) . "</pre>";
            $all_users = $conn->query("SELECT * FROM users");
            echo "<h3>All Users (Proof of SQL Injection):</h3>";
            echo "<pre>" . print_r($all_users->fetch_all(MYSQLI_ASSOC), true) . "</pre>";
        } else {
            $error = "Invalid username or password";
        }
    }
} catch (Exception $e) {
    $error = "Database error: " . $e->getMessage();
}
require_once 'login_form.html';
if (isset($error)) {
    echo "<div class='error'>$error</div>";
}
?>
