<?php
session_start();

include("config.php");

// Database connection
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_SESSION['id'];

$stmt = $conn->prepare("SELECT * FROM signup WHERE id = ?");
$stmt->bind_param("i", $id); 
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styles.css">
    <title>Dashboard | Top Click</title>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="lab la-accusoft"></span> Top Click</h2>
        </div>

        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="dashboard.php" class="active"><span class="las la-igloo"></span>
                    <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="employees.php"><span class="las la-user"></span>
                    <span>Employees</span></a>
                </li>
                <li>
                    <a href="applicant.php"><span class="las la-file"></span>
                    <span>Applicants</span></a>
                </li>
                <li>
                    <a href="logout.php"><span class="las la-circle"></span>
                    <span>Log Out</span></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-content">
        <header>
        <?php 
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc(); 
        ?>
            <h2>
                <label>
                    <span class="las la-bars"></span>
                     Dashboard
                </label>
            </h2>

            <div class="user-wrapper">
                <div>
                    <h4><?php echo htmlspecialchars($row["name"]); ?></h4> 
                    <small>Developer</small>
                </div>
            </div>
        <?php
            } else {
                echo "<p>No user found</p>";
            }
        ?>
        </header>
        <main>
            <div class="cards">
                <div class="card-single">
                    <div>
                        <h1>20</h1>
                        <span>Employees</span>
                    </div>
                    <div>
                        <span class="las la-users"></span>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <h1>45</h1>
                        <span>Department</span>
                    </div>
                    <div>
                        <span class="las la-clipboard"></span>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <h1>6</h1>
                        <span>Leave</span>
                    </div>
                    <div>
                        <span class="las la-users"></span>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <h1>15</h1>
                        <span>Pending</span>
                    </div>
                    <div>
                        <span class="las la-shopping-bag"></span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
