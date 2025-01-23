<?php
session_start();

include("config.php");

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styles.css">
    <title>Employees | Top Click</title>

    <style>
    .img-avatar{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center ;
        border-radius:100%;
    }
    </style>
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
                     Employees
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List of Employees</h3>
                    <div class="card-tools">
                        <a href="manage_employees.php" class="btn btn-flat btn-primary"><span class="las la-plus"></span>  Create New</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                    <?php 
                    $result = mysqli_query($conn, "SELECT * FROM employees ");
                    if (mysqli_num_rows($result) > 0) {
                    ?>
                        <table class="table table-hover table-stripped">
                            <colgroup>
                                <col width="15%">
                                <col width="20%">
                                <col width="25%">
                                <col width="30%">
                                <col width="10%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Details</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php 
                            $i = 0;
                            while($row = mysqli_fetch_array($result)) {
                            ?>
                            <tbody>
                                    <tr>
                                        <td><?php echo $row["employee_id"]; ?></td>
                                        <td><?php echo $row["firstname"] . " " . $row["lastname"]; ?></td>
                                        <td><?php echo $row["email"]; ?></td>
                                        <td>
                                            <p class="m-0 ">
                                                <b>Department: <?php echo $row["department"]; ?></b><br>
                                                <b>Designation: <?php echo $row["designation"]; ?></b><br>
                                            </p>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="dropbtn"> 
                                                    Action
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-content" aria-label="Dropdown options">
                                                    <a href="editProfile.php" aria-label="Edit Profile">Edit</a>
                                                    <!--a href="#" aria-label="Link 1">Link 1</a>
                                                    <a!-- href="#" aria-label="Link 2">Link 2</a!-->
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php
                                $i++;
                                }
                                ?>
                        </table>
                        <?php
                            }
                            else
                            {
                                echo "No Result Found";
                            }
                        ?>
                    </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

<?php
//close the connection
mysqli_close($conn);
?>