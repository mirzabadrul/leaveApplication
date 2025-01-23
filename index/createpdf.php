<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    $leave_type = $_POST['leave_type'];
    $from_date = $_POST['fromdate'];
    $to_date = $_POST['todate'];
    $reason = $_POST['reason'];

    // HTML Structure
    $data = '
    <html>
    <head>
        <style>' . file_get_contents('pdfStyle.css') . '</style>
    </head>
    <body>
        <div class="header">
            <img src="topclick.png" alt="Logo">
            <h2>Leave Information</h2>
        </div>
        <div class="details">
            <p><strong>Full Name:</strong> ' . htmlspecialchars($full_name) . '</p>
            <p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>
            <p><strong>Department:</strong> ' . htmlspecialchars($department) . '</p>
            <p><strong>Designation:</strong> ' . htmlspecialchars($designation) . '</p>
            <p><strong>Leave Type:</strong> ' . htmlspecialchars($leave_type) . '</p>
            <p><strong>From Date:</strong> ' . htmlspecialchars($from_date) . '</p>
            <p><strong>To Date:</strong> ' . htmlspecialchars($to_date) . '</p>
            <p><strong>Reason:</strong> ' . htmlspecialchars($reason) . '</p>
        </div>
        <div class="footer">
            Generated on ' . date('Y-m-d H:i:s') . '
        </div>
    </body>
    </html>
    ';

    require_once __DIR__ . '/vendor/autoload.php';

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($data);
    $mpdf->Output("Leave Form.pdf", "D");
} 
?>
