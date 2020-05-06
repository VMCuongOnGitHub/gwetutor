<?php include('../server.php') ?>
<?php
    if(!isset($_SESSION))
    {
        session_start();
    }
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
<!--<h1>You are new to the GW System, leave our staff a message</h1>-->
<!--<form action="" method="post">-->
<!--    <textarea type="text" name="message_to_staff"></textarea>-->
<!--     <input type="submit">-->
<!--</form>-->

<html>
    <head>
        <title>GW E Tutor</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    </head>
    <body>
        <div id="login">
            <h3 class="text-center text-grey pt-5">Login</h3>
            <div class="container">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6">
                        <div id="login-box" class="col-md-12">
                            <form id="login-form" class="form" method="post" action="">
                                <h3 class="text-center text-info">You are new to the GW System, leave our staffs a message</h3>
                                <div class="form-group">
                                    <label for="message_to_staff" class="text-info">Message for our Staffs:</label><br>
                                    <textarea type="text" name="message_to_staff" id="username" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-info btn-md" value="Send">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
