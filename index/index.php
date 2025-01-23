<?php
session_start();
include ("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    if (empty($_POST['email'])) {
        echo "Please enter your Employee Email.";
    } else {
        $email = $_POST['email'];

    $conn = mysqli_connect($servername, $username, $password, $database, $port);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // Prepare SQL query to fetch record by ID
    $query = "SELECT * FROM employees WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['email'] = $email; 
        header("Location: view_leave.php");
        exit();
    } else {
        $error[] = 'Employee Not Found!';
    }
}

// Close the connection
mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Leave Application System</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <!-- Video Background -->
        <video autoplay muted loop id="background-video">
            <source src="background.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <!-- Form Container -->
        <div class="container">
            <h3>Top Click | Leave Application</h3>
            <div class="input">
                <form action="" method="POST">
                    <label for="email">Insert your Email:</label><br>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <button type="submit" name="submit">Enter</button>
                </form>
            </div>
            <?php
                if(isset($error)){
                    foreach($error as $error){
                    echo '<span class="error-msg">'.$error.'</span>';
                    }
                }
            ?>
        </div>
    </body>
</html>
