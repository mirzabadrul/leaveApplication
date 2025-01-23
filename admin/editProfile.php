<?php
session_start();
include("config.php");

// Database connection
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch employee details to pre-fill the form
$userData = [];
if (isset($_SESSION['employee_id'])) {
    $stmt = $conn->prepare("SELECT * FROM employees WHERE employee_id = ?");
    $stmt->bind_param("i", $_SESSION['employee_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();
    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $employee_id = $_POST['employee_id'];
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    // $dob = $conn->real_escape_string($_POST['dob']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $address = $conn->real_escape_string($_POST['address']);
    $department = $conn->real_escape_string($_POST['department']);
    $designation = $conn->real_escape_string($_POST['designation']);

    // Update query
    $stmt = $conn->prepare("UPDATE employees SET firstname = ?, lastname = ?, email = ?, contact = ?, address = ?, department = ?, designation = ? WHERE employee_id = ?");
    $stmt->bind_param("sssssssi", $firstname, $lastname, $email, $contact, $address, $department, $designation, $employee_id);

    if ($stmt->execute()) {
        echo "<script>alert('Employee details updated successfully!');</script>";
        header("Location: employees.php");
    } else {
        echo "<script>alert('Error updating record: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="editProfile.css">
    <title>Edit Profile | Top Click</title>
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
                <a href="#"><span class="las la-file"></span>
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
        <h2>
            <label for="">
                <span class="las la-bars"></span> Dashboard
            </label>
        </h2>
        <div class="user-wrapper">
            <div>
                <h4><?php echo htmlspecialchars($_SESSION['name'] ?? 'User'); ?></h4>
                <small>Developer</small>
            </div>
        </div>
    </header>
    <main>
        <form action="" method="POST">
            <h3>Edit Employees</h3>
            <div class="form-group">
                <div class="form-row">
                    <!-- ID -->
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="employee_id">Your ID</label>
                        <input type="text" class="form-control" id="employee_id" name="employee_id" value="<?php echo htmlspecialchars($userData['employee_id'] ?? ''); ?>" readonly>
                    </div>
                    <!-- First Name -->
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($userData['firstname'] ?? ''); ?>" required>
                    </div>
                    <!-- Last Name -->
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($userData['lastname'] ?? ''); ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <!-- Email -->
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userData['email'] ?? ''); ?>" required>
                    </div>
                    <!-- DOB -->
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($userData['dob'] ?? ''); ?>">
                    </div>
                    <!-- Phone -->
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="contact" name="contact" value="<?php echo htmlspecialchars($userData['contact'] ?? ''); ?>">
                    </div>
                </div>
                <div class="form-row">
                    <!-- Address -->
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($userData['address'] ?? ''); ?>">
                    </div>
                </div>
                <div class="form-row">
                    <!-- Department -->
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="department">Department</label>
                        <input type="text" class="form-control" id="department" name="department" value="<?php echo htmlspecialchars($userData['department'] ?? ''); ?>">
                    </div>
                    <!-- Designation -->
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="designation">Designation</label>
                        <input type="text" class="form-control" id="designation" name="designation" value="<?php echo htmlspecialchars($userData['designation'] ?? ''); ?>">
                    </div>
                </div>
            </div>
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="text-right">
                        <button type="button" id="cancel" class="btn btn-secondary">Cancel</button>
                        <button type="submit" id="submit" name="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>
</body>
</html>
