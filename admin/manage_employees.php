<?php
include("config.php");

$conn = mysqli_connect($servername, $username, $password, $database);

// Check if the connection is successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save"])) {
    // Retrieve form data
    $employee_id = $_POST["employee_id"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];
    $contact = $_POST["contact"];
    $address = $_POST["address"];
    $department = $_POST["department"];
    $designation = $_POST["designation"];

    $query = "INSERT INTO employees (employee_id, firstname, lastname, email, dob, contact, address, department, designation) 
              VALUES ('$employee_id', '$firstname', '$lastname', '$email', '$dob', '$contact', '$address', '$department', '$designation')";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('New Employee Successfully Added!');
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$result = mysqli_query($conn, "SELECT * FROM signup");

if (!$result) {
    echo "Error fetching signup data: " . mysqli_error($conn);
}

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="employees.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <title>Employees | Top Click</title>
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
        <?php 
            $result = mysqli_query($conn, "SELECT * FROM signup");
            if (mysqli_num_rows($result) > 0) {
        ?>
        <header>
            <h2>
                <label for="">
                    <span class="las la-bars"></span>
                    Add Employee
                </label>
            </h2>

            <?php 
                while($row = mysqli_fetch_array($result)) {
            ?>
            <div class="user-wrapper">
                <div>
                    <h4><?php echo $row["name"]; ?></h4>
                    <small>Developer</small>
                </div>
            </div>
            <?php 
                } // Close the while loop here
            ?>
        </header>
        <?php
            } else {
                echo "<p>No Result Found</p>";
            }
        ?>
        <main>
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <div class="container-fluid">
                        <div id="msg"></div>
                        <form action="" id="manage-user" method="POST"> 	
                            <input type="hidden" name="id" value="">
                            <input type="hidden" name="type" value="3">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="employee_id">Employee ID</label>
                                        <input type="text" name="employee_id" id="employee_id" class="form-control rounded-0" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="firstname">First Name</label>
                                        <input type="text" name="firstname" id="firstname" class="form-control rounded-0" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" name="lastname" id="lastname" class="form-control rounded-0" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" class="form-control rounded-0" value="" required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="dob">DOB</label>
                                        <input type="date" name="dob" id="dob" class="form-control rounded-0" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact">Contact #</label>
                                        <input type="text" name="contact" id="contact" class="form-control rounded-0" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea rows="3" name="address" id="address" class="form-control rounded-0" style="resize:none !important" required></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="department">Department</label>
                                        <select name="department" id="department" class="form-control" required>
                                            <option style="font-size: 10px;" value="" disabled ></option>
                                            <option value="">Marketing and Sales Department</option>
                                            <option value="">IT Department</option>
                                            <option value="">Finance Department</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="designation">Designation</label>
                                        <input type="text" name="designation" id="designation" class="form-control rounded-0" value="" required>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12">
                            <div class="row">
                                <button class="btn btn-primary mr-2" type="submit" name="save" form="manage-user">Save</button>
                                <a class="btn btn-secondary" href="employees.php">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php 
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
