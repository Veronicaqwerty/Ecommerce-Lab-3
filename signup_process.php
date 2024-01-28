<?php
include('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the 'users' table
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
    
    try {
        $stmt->execute([$name, $email, $hashedPassword]);
        // Redirect to login page after successful registration
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        // Handle registration error (e.g., duplicate email)
        header("Location: signup_form.php?error=2");
        exit();
    }
} else {
    // Invalid request method, redirect to sign-up page
    header("Location: index.php");
    exit();
}
?>
