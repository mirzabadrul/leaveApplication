<?php
// Start the session
session_start();

// Include the database configuration file
include "config.php";

// Handle the form submission
if (isset($_POST['submit'])) {
    // Sanitize and escape user inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']); 
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Prepare the SQL statement to prevent SQL injection
    $query = "SELECT * FROM signup WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    // Get the result of the query
    $result = mysqli_stmt_get_result($stmt);

    // Check if email exists in the database
    if (mysqli_num_rows($result) == 1) {       
        $row = mysqli_fetch_assoc($result);

        // Verify the hashed password
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['name'];

            // Redirect to the dashboard
            header('Location: dashboard.php'); 
            exit();
        } else {
            $error[] = 'Invalid Password';
        }
    } else {
        $error[] = 'Invalid Email or Password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login | Top Click</title>
</head>
<body>
    <div class="login-box">
        <form action="" method="post">
            <?php
                // Display error messages, if any
                if (isset($error)) {
                    foreach ($error as $err) {
                        echo '<span class="error-msg">' . htmlspecialchars($err) . '</span>';
                    }
                }
            ?>
            <div class="login-header">
                <header>Login</header>
            </div>
            <div class="input-box">
                <input type="email" name="email" class="input-field" placeholder="Email" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" class="input-field" placeholder="Password" required>
            </div>
            <div class="input-submit">
                <button type="submit" name="submit" class="submit-btn">Sign In</button>
            </div>
            <div class="sign-up-link">
                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            </div>
        </form>
    </div>
</body>
</html>
