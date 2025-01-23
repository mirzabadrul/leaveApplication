<?php
session_start();
include("config.php");

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Retrieve email from the session
$email = $_SESSION['email'];

// Connect to the database
$conn = mysqli_connect($servername, $username, $password, $database, $port);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all leave records for the logged-in user
$sql = "SELECT * FROM employee_leaves WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

// Check for database query errors
if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Leave Applications</title>
    <link rel="stylesheet" href="viewstyle.css">
</head>
<body>
    <div class="container">
        <h2>View Leave Applications</h2>
        <div class="button-group">
            <form action="form.php" method="GET">
                <button type="submit">Apply Leave</button>
            </form>
            <a href="logout.php"><button>Exit</button></a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Date Leave</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["fromdate"]) . " until " . htmlspecialchars($row["todate"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                        echo "<td>
                                <form action='cform.php' method='GET'>
                                    <button type='submit' name='id' value='" . htmlspecialchars($row['id']) . "'>View Leave</button>
                                    <button onclick='removeLeave(this)'>Delete</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr class='text-center'>
                            <td colspan='3'><b>YOU DON'T HAVE ANY LEAVE HISTORY! PLEASE APPLY TO VIEW YOUR STATUS HERE!</b></td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
    function removeLeave(button) {
        if (confirm("Are you sure you want to remove this leave?")) {
            const item = button.parentElement.parentElement;
            item.remove(); 
        }
    }
</script>
</body>
</html>

<?php
// Close the connection after all operations
mysqli_close($conn);
?>
