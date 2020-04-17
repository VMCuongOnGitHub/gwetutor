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
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu"
                                        data-toggle="dropdown">
                                    All Students
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                                    <li><a href="#">Students with Tutor</a></li>
                                    <li><a href="#">Students without Tutor</a></li>
                                </ul>
                            </div>
                            <div class="activities d-flex">
                                <span>Last Activity From: </span>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu"
                                            data-toggle="dropdown">
                                        7 Days
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                                        <li><a href="#">1 Day</a></li>
                                        <li><a href="#">2 Day</a></li>
                                        <li><a href="#">3 Day</a></li>
                                        <li><a href="#">4 Day</a></li>
                                        <li><a href="#">5 Day</a></li>
                                        <li><a href="#">6 Day</a></li>
                                        <li><a href="#">7 Day</a></li>
                                    </ul>
                                </div>
                            </div>
                            <form class="form-inline">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search Tutor">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                            </form>
                        </nav>

                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">STUDENT NAME</th>
                                <th scope="col">STUDENT EMAIL</th>
                                <th scope="col">IS BEING ASSIGNED TO <i class="fas fa-sort"></i></th>
                                <th scope="col">LAST ACTIVITY <i class="fas fa-sort"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>James</td>
                                <td>Mark@gmail.com</td>
                                <td>Otto</td>
                                <td>5 DAYS</td>
                                <td>ASSIGNED TO</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>James</td>
                                <td>Mark@gmail.com</td>
                                <td>Thornton</td>
                                <td>10 DAYS</td>
                                <td>ASSIGNED TO</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>James</td>
                                <td>Mark@gmail.com</td>
                                <td>the Bird</td>
                                <td>10 DAYS</td>
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
