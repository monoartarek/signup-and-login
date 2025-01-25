<?php
// Include the database connection file
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Fetch the user's hashed password from the database
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Start a session and store user info
            session_start();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;

            // Redirect to the main page
            header("Location: main.php");
            exit();
        } else {
            // Redirect back to login with an error
            header("Location: login.html?error=Invalid password");
            exit();
        }
    } else {
        // Redirect back to login with an error
        header("Location: login.html?error=Email not found");
        exit();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
