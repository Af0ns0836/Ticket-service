<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once(__DIR__.'/../database/connec.php');

if (!isset($_SESSION['id'])) {
    die("User ID not found");
}

$statement = $conn->prepare("SELECT name, username, email, password FROM users WHERE userid = :userid");
$statement->bindParam(":userid", $_SESSION['id']);
if (!$statement->execute()) {
    // handle error
    die("Failed to retrieve user data");
}
$user = $statement->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['edit'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $new_password = $_POST['password'];
    $email = $_POST['email'];

    // Check which fields have been changed
    if (empty($name)) {
        $name = $user['name'];
    }
    if (empty($username)) {
        $username = $user['username'];
    }
    if (empty($email)) {
        $email = $user['email'];
    }
    if (empty($new_password)) {
        $password = $user['password'];
    } else {
        $password = password_hash($new_password, PASSWORD_DEFAULT);
    }
    
    $user_id = $_SESSION["id"];
    // Update user in database
    $query = "UPDATE users SET username = :username, password = :password, email = :email, name = :name WHERE userid = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':user_id', $user_id);

    if ($stmt->execute()) {
        // Display success message to user
        echo "User data updated successfully";
        header('Location: /../pages/account.php');
        exit;
    } else {
        // Log error details and display generic error message to user
        error_log("Failed to update user data: " . print_r($stmt->errorInfo(), true));
        die("Failed to update user data");
    }
}
