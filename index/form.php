<?php
session_start();
include("config.php");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    header("Location: index.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['apply'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $designation = mysqli_real_escape_string($conn, $_POST['designation']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $leave_type = mysqli_real_escape_string($conn, $_POST['leave_type']);
    $fromdate = mysqli_real_escape_string($conn, $_POST['fromdate']);
    $todate = mysqli_real_escape_string($conn, $_POST['todate']);
    $days = mysqli_real_escape_string($conn, $_POST['leave_days']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);

    $status = "Pending";

    // Insert query
    $sql = "INSERT INTO employee_leaves (full_name, email, designation, department, leave_type, fromdate, todate, leave_days, reason, status)
            VALUES ('$full_name', '$email', '$designation', '$department', '$leave_type', '$fromdate', '$todate', '$days', '$reason', '$status')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Your Registration was Successful!');
                window.location.href = 'view_leave.php?employee_id=" . $_SESSION['employee_id'] . "';
              </script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
mysqli_close($conn);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form">
            <form method="POST" action="">
                <h3>Leave Application Form</h3>
                <div class="input-group">
                    <input type="text" name="full_name" placeholder="Full Name" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="input-group">
                    <input type="text" name="designation" placeholder="Designation" required>
                </div>
                <div class="input-group">
                    <input type="text" name="department" placeholder="Department" required>
                </div>
                <div class="input-group">
                    <select name="leave_type" required>
                        <option value="" disabled selected>Type of Leave</option>
                        <option value="Annual Leave">Annual Leave</option>
                        <option value="Emergency Leave">Emergency Leave</option>
                        <option value="Unpaid Leave">Unpaid Leave</option>
                        <option value="Sick Leave">Sick Leave</option>
                        <option value="Marriage Leave">Marriage Leave</option>
                    </select>
                </div>
                <div class="input_group">
                    <h5>MC Requirement</h5>
                    <label class="custom-file-upload">
                        <input type="file"/>
                        Upload File
                    </label>
                </div>
                <div class="col-half">
                <br>
                    <div class="input-group">
                        <label for="">From Date</label><br>
                        <input id="fromdate" name="fromdate" type="date" required>
                    </div>
                </div>
                <div class="col-half">
                    <div class="input-group">
                        <label for="">To Date</label><br>
                        <input id="todate" name="todate" type="date" required>
                    </div>
                </div>
                <div class="input-group">
                    <input type="number" id="leave_days" name="leave_days" placeholder="Days" readonly>
                </div>
                <div class="input-group">
                    <textarea id="reason" name="reason" rows="4" placeholder="Reason for leave" required></textarea>
                </div>
                <div class="button-group">
                    <button type="submit" name="apply">Apply For Leave</button>
                    <button><a style="text-decoration: none; color: #fff;" href="view_leave.php">Cancel</a></button>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Auto-calculate leave days
        document.getElementById('fromdate').addEventListener('change', calculateDays);
        document.getElementById('todate').addEventListener('change', calculateDays);

        function calculateDays() {
            const fromDate = new Date(document.getElementById('fromdate').value);
            const toDate = new Date(document.getElementById('todate').value);

            if (fromDate && toDate && toDate >= fromDate) {
                const diffTime = Math.abs(toDate - fromDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // Include the start date
                document.getElementById('leave_days').value = diffDays;
            } else {
                document.getElementById('leave_days').value = '';
            }
        }
    </script>
</body>
</html>