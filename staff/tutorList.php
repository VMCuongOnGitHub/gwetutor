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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script src="https://kit.fontawesome.com/96bd6ee534.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="wrapper">
                <div class="sidebar">
                    <h2>MENU</h2>
                    <ul>
                        <li><a href="staffDashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
                        <li><a href="tutorList.php"><i class="fas fa-user"></i>Tutor List</a></li>
                        <li><a href="studentList.php"><i class="fas fa-address-card"></i>Student List</a></li>
                        <li><a href="unassignedUser.php"><i class="fas fa-project-diagram"></i>Unassigned User</a></li>
                    </ul>
                </div>
                <div class="main_content">
                    <div class="right-action col-sm-10">
                        <div class="right-action-header">
                        </div>

                        <nav class="navbar navbar-light bg-light">
                            <form class="form-inline">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search Tutor">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                            </form>
                        </nav>

                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">TUTOR EMAIL</th>
                                <th scope="col">HAS BEEN ASSIGN FOR <i class="fas fa-sort"></i></th>
                                <th scope="col">IS ASSIGN TO <i class="fas fa-sort"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark@gmail.com</td>
                                <td>Otto</td>
                                <td>5</td>
                                <td>ASSIGNED TO</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Mark@gmail.com</td>
                                <td>Thornton</td>
                                <td>10</td>
                                <td>ASSIGNED TO</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Mark@gmail.com</td>
                                <td>the Bird</td>
                                <td>10</td>
                                <td>ASSIGNED TO</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
