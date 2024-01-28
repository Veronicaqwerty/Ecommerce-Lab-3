<?php
// Database configuration
$host = 'localhost';
$dbname = 'verywell';
$username = 'root';
$password = '';

// Establish a database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Function to register a new user
function registerUser($name, $email, $password) {
    global $pdo;

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

    try {
        $stmt->execute([$name, $email, $hashedPassword]);
        return true;
    } catch (PDOException $e) {
        // Check the error code for duplicate entry
        if ($e->getCode() == '23000') {
            // Duplicate entry error (e.g., duplicate email)
            return false;
        } else {
            // Other registration error
            throw $e; // Re-throw the exception for general error handling
        }
    }
}

// Function to authenticate a user
function authenticateUser($email, $password) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    // Add debugging information
    var_dump($stmt->errorInfo());

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Authentication successful
        return true;
    } else {
        // Authentication failed
        return false;
    }
}
?>
