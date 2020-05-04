<?php include('../server.php') ?>

<?php
    if(!isset($_SESSION))
    {
        session_start();
    }

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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script src="https://kit.fontawesome.com/96bd6ee534.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>