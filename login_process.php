<?php
// Include the database file
include('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Authenticate user
    if (authenticateUser($email, $password)) {
        // Check the user's role
$stmt = $pdo->prepare("SELECT role FROM users WHERE email = ?");
$stmt->execute([$email]);

if ($stmt) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Print the role for debugging
    echo "Role: " . $user['role'];

    // Redirect based on the user's role
    if ($user && $user['role'] === 'admin') {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Redirect to the regular user dashboard or another page
        header("Location: user_dashboard.php");
        exit();
    }
} else {
    echo "Error fetching user role: " . $stmt->errorInfo()[2];
}
    } else {
        // Authentication failed, redirect to login page with an error message
        header("Location: index.php?error=1");
        exit();
    }
} else {
    // Invalid request method, redirect to login page
    header("Location: index.html");
    exit();
}
?>
