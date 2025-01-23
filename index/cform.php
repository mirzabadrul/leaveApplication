<?php
session_start();
include("config.php");
include("createpdf.php");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function fetchUserDataById($conn, $userId) {
    // Prepare the SQL query to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM employee_leaves WHERE id = ?");
    $stmt->bind_param("i", $userId);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch the data
    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return the data as an associative array
    } else {
        return null; // No data found
    }
}

// Check if the user ID is passed via GET
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user-specific data based on the user ID
    $userData = fetchUserDataById($conn, $userId);

    // Check if data is found
    if ($userData) {
        $full_name = $userData['full_name'];
        $email = $userData['email'];
        $department = $userData['department'];
        $designation = $userData['designation'];
        $leave_type = $userData['leave_type'];
        $from_date = $userData['fromdate'];
        $to_date = $userData['todate'];
        $days = $userData['leave_days'];
        $reason = $userData['reason'];
    } else {
        die('No data found for the given ID.');
    }
} else {
    die('User ID is missing.');
}

// Close the database connection
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Leave | Top Click</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="cform.css">
</head>
<body>
    <div class="container">
        <div class="form">
            <header><a href="view_leave.php">Your Leave Information</a></header>
            <form action="createpdf.php" method="post">
                <div class="input-box">
                    <label for="full_name">Name</label>
                    <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" readonly>
                </div>
                <div class="input-box">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
                </div>
                <div class="input-box">
                    <label for="designation">Designation</label>
                    <input type="text" id="designation" name="designation" value="<?php echo htmlspecialchars($designation); ?>" readonly>
                </div>
                <div class="input-box">
                    <label for="department">Department</label>
                    <input type="text" id="department" name="department" value="<?php echo htmlspecialchars($department); ?>" readonly>
                </div>
                <div class="input-box">
                    <label for="leave_type">Type of Leave</label>
                    <input type="text" id="leave_type" name="leave_type" value="<?php echo htmlspecialchars($leave_type); ?>" readonly>
                </div>
                <div class="form column">
                    <div class="col1 input-box">
                        <label for="fromdate">From Date</label>
                        <input type="text" id="fromdate" name="fromdate" value="<?php echo htmlspecialchars($from_date); ?>" readonly>
                    </div>
                    <div class="col1 input-box">
                        <label for="todate">To Date</label>
                        <input type="text" id="todate" name="todate" value="<?php echo htmlspecialchars($to_date); ?>" readonly>
                    </div>
                </div>
                <div class="input-box">
                    <label for="leave_days">Days</label>
                    <input type="text" id="leave_days" name="leave_days" value="<?php echo htmlspecialchars($days); ?>" readonly>
                </div>
                <div class="input-box">
                    <label for="reason">Reason</label>
                    <input type="text" id="reason" name="reason" value="<?php echo htmlspecialchars($reason); ?>" readonly>
                </div>
                <div class="form column">
                    <button type="submit" name="generate">Generate PDF</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
