<?php include('header_staff.php') ?>
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h2>Staff</h2>
                </div>
            </nav>
        </div>
        <div class="list-group list-group-flush">
            <a class='list-group-item list-group-item-action bg-light' href="staffDashboard.php"><i class="fas fa-home"> </i>Dashboard</a>
            <a class='list-group-item list-group-item-action bg-light' href="tutorList.php"><i class="fas fa-user"> </i>Tutor List</a>
            <a class='list-group-item list-group-item-action bg-light' href="studentList.php"><i class="fas fa-address-card"> </i>Student List</a>
            <a class='list-group-item list-group-item-action bg-light' href="unassignedUser.php"><i class="fas fa-project-diagram"> </i>Unassigned User</a>
        </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <button class="btn btn-primary" id="menu-toggle">Hide</button>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a href="../index.php?logout='1'" class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <form style="margin-top: 20px; margin-bottom: 20px">
                <div class="form-group">
                    <input type="text" class="form-control" id="search_user" placeholder="Search Tutor">
                </div>
            </form>
            <div class="row">

                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">TUTOR NAME</th>
                        <th scope="col">TUTOR EMAIL</th>
                        <th scope="col">IS ASSIGNING TO <i class="fas fa-sort"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $querySelectAllTutors = "SELECT * FROM users WHERE is_assigned_role='tutor'";
                    $results = mysqli_query($db, $querySelectAllTutors);

                    while($row = mysqli_fetch_assoc($results)) {
                        $tutorID = 'tutor' . $row['userID'];
                        $querySelectAllTutorsInStudent = "SELECT * FROM students WHERE tutorID='{$tutorID}'";

                        $resultsSelectAllTutorsInStudent = mysqli_query($db, $querySelectAllTutorsInStudent);

                        $numberOfAssigningStudent = mysqli_num_rows($resultsSelectAllTutorsInStudent);

                        echo "<tr>
                                            <td>{$row['userID']}</td>
                                            <td><a href='../tutor.php?id={$row['userID']}'>{$row['username']}</a></td>
                                            <td>{$row['email']}</td>
                                            <td>{$numberOfAssigningStudent} Student(s)</td>
                                        </tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            </div>
    </div>
</div>
<!-- /#wrapper -->


<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>




</body>
</html>
