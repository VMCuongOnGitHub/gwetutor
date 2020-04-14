<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    if ($_SESSION['user_role'] == 'staff') {
        $_SESSION['msg'] = "Unauthorized Access";
        header('location: login.php');
    }
    header('location: login.php');
}



if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/staffDashboard.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script src="https://kit.fontawesome.com/96bd6ee534.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <div class="left-action col-sm-2">
            <p>MENU</p>
            <div class="left-action-content">
                <a href="staffDashboard.php">Staff Dashboard</a>
            </div>
            <div class="left-action-content">
                <a href="tutorList.php">Tutor List</a>

            </div>
            <div class="left-action-content">
                <a href="studentList.php.php">Student List</a>
            </div>
        </div>

    </div>
</div>

</body>
</html>
