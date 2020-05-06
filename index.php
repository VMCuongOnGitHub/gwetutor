<?php include('server.php') ?>

<?php
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: login.php");
    }else{
        session_start();
        if ($_SESSION['is_assigned_role'] == 'student') {
            header('location: student.php');
        }elseif ($_SESSION['is_assigned_role'] == 'tutor'){
            header('location: tutor.php');
        }elseif ($_SESSION['is_assigned_role'] == 'staff'){
            header('location: staff/staffDashboard.php');
        }else{
            header('location: login.php');
        }
    }
?>
