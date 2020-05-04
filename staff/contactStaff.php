<?php include('../server.php') ?>
<?php
    if(!isset($_SESSION))
    {
        session_start();
    }
    echo 'this is ' . $_SESSION['is_assigned_role'];
    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
        if ($_SESSION['is_assigned_role'] != '') {
            if ($_SESSION['is_assigned_role'] == 'student') {
                header('location: student.php');
            }elseif ($_SESSION['is_assigned_role'] == 'tutor') {
                header('location: tutor.php');
            }elseif ($_SESSION['is_assigned_role'] == 'staff'){
                header('location: staffDashboard.php');
            }else{
                header('location: contactStaff.php');
            }
        }
    }

    $message_to_staff = "New User";
    $query = "UPDATE users SET message_to_staff = '$message_to_staff' WHERE userID='{$_SESSION["userID"]}'";
    mysqli_query($db, $query);

    if (isset($_POST['message_to_staff'])) {
        $message_to_staff = mysqli_real_escape_string($db, $_POST['message_to_staff']);
        $query = "UPDATE users SET message_to_staff = '$message_to_staff' WHERE userID='{$_SESSION["userID"]}'";
        mysqli_query($db, $query);
        header('location: successfulMessage.php');
    }




?>
<h1>You are new to the GW System, leave our staff a message</h1>
<form action="" method="post">
    <textarea type="text" name="message_to_staff"></textarea>
     <input type="submit">
</form>
