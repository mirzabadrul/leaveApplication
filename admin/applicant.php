<?php

// TAMBAH LEAVE_DAYS DLM DB AND TUKAR II SIKIT PHP

session_start();

include("config.php");

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styles.css">
    <title>Applications | Top Click</title>
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
        <?php 
            $result = mysqli_query($conn, "SELECT * FROM signup");
            if (mysqli_num_rows($result) > 0) {
        ?>
        <header>
            <h2>
                <label for="">
                    <span class="las la-bars"></span>
                     Admin Panel
                </label>
            </h2>

            <?php 
                while($row = mysqli_fetch_array($result)) {
            ?>
            <div class="user-wrapper">
                <div>
                    <h4><?php echo $row["name"] ?></h4>
                    <small>Admin</small>
                </div>
            </div>
            <?php 
                } 
            ?>
        </header>
        <?php
            } else {
                echo "<p>No Result Found</p>";
            }
        ?>
        <main>
        <div class="mycontainer">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Leave Application</th>
                        <th>Dates</th>
                        <th>Leave</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                            <!-- loading all leave applications from database -->
                            <?php
                                    global $row;
                                    $query = mysqli_query($conn,"SELECT * FROM employee_leaves WHERE status='Pending'");
                                    
                                    $numrow = mysqli_num_rows($query);

                                if($query){
                                        
                                        if($numrow!=0){
                                            $cnt=1;

                                            while($row = mysqli_fetch_assoc($query)){
                                                $datetime1 = new DateTime($row['fromdate']);
                                                $datetime2 = new DateTime($row['todate']);
                                                $interval = $datetime1->diff($datetime2);
                                                
                                                echo "<tr>
                                                        <td>$cnt</td>
                                                        <td>{$row['full_name']}</td>
                                                        <td>{$row['reason']}</td>
                                                        <td>{$datetime1->format('Y/m/d')} <b>-</b> {$datetime2->format('Y/m/d')}</td>
                                                        <td>{$interval->format('%a Day/s')}</td>
                                            
                                                        <td><a href=\"updateStatusAccept.php?email={$row['email']}&reason={$row['reason']}\"><button class='btn-success btn-sm' >Accept</button></a>
                                                        <a href=\"updateStatusReject.php?email={$row['email']}&reason={$row['reason']}\"><button class='btn-danger btn-sm' >Reject</button></a></td>
                                                    </tr>";  
                                            $cnt++; }       
                                        }
                                    }
                                    else{
                                        echo "Query Error : " . "SELECT * FROM employee_leaves WHERE status='Pending'" . "<br>" . mysqli_error($conn);
                                    }
                        ?> 
                        
                    </tbody>
                </table>
        </div>
    </main>
    </div>
</body>
</html>

