<?php

include "config.php";

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']); 
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $query = "SELECT * FROM signup WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'User already exists!';
    } else {
        // Check if passwords match
        if ($password !== $cpassword) {
            $error[] = 'Passwords do not match!';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $insert = "INSERT INTO signup (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";
            if (mysqli_query($conn, $insert)) {
                header('location:login.php');
                exit(); 
            } else {
                $error[] = 'Failed to register. Please try again.';
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Top Click</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="post">
            <h3>Sign Up</h3>
            <?php
            if(isset($error)){
                foreach($error as $error){
                    echo '<span class="error-msg">'.$error.'</span>';
                }
            }
            ?>
            <input type="text" name="name" required placeholder="Name">
            <input type="email" name="email" required placeholder="Email Address">
            <input type="password" name="password" required placeholder="Password">
            <input type="password" name="cpassword" required placeholder="Confirm Password">
            <input type="submit" name="submit" value="register" class="form-btn">
            <p>already have an account? <a href="login.php">Login</a></p>
        </form>

    </div>
</body>
</html>