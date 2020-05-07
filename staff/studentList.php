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
                    <input type="text" class="form-control" id="search_user" placeholder="Search Student">
                </div>
            </form>
            <div class="row">

                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">STUDENT NAME</th>
                        <th scope="col">STUDENT EMAIL</th>
                        <th scope="col">IS BEING ASSIGNED TO <i class="fas fa-sort"></i></th>
                        <!--                                <th scope="col">LAST ACTIVITY <i class="fas fa-sort"></i></th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $querySelectAllStudents = "SELECT * FROM users WHERE is_assigned_role='student'";
                    $results = mysqli_query($db, $querySelectAllStudents);

                    while($row = mysqli_fetch_assoc($results)) {
                        $querySelectTutorFromStudent = "SELECT * FROM students WHERE userID LIKE '{$row['userID']}'";
                        //echo $querySelectTutorFromStudent;
                        $resultSelectTutorFromStudent = mysqli_query($db, $querySelectTutorFromStudent);
                        $rowSelectTutorFromStudent = mysqli_fetch_assoc($resultSelectTutorFromStudent);

                        //$tutorIDCut = substr($rowSelectTutorFromStudent['tutorID'], 5);
                        $tutorIDCut = str_replace("tutor","",$rowSelectTutorFromStudent['tutorID']);

                        $querySelectTutor = "SELECT * FROM users WHERE userID = '{$tutorIDCut}'";

                        $resultSelectTutor = mysqli_query($db, $querySelectTutor);
                        $rowSelectTutor = mysqli_fetch_assoc($resultSelectTutor);

                        echo "<tr>
                                                <td>{$row['userID']}</td>
                                                <td><a href='../studentDashboard.php?id={$row['userID']}&tutorid={$tutorIDCut}'&update='1'>{$row['username']}</a></td>
                                                <td>{$row['email']}</td>
                                                <td>
                                                    <button class='btn btn-primary' data-toggle='modal' data-target='#myModal1' data-formid='{$row['userID']}'>{$rowSelectTutor['username']}</button>
                                                </td>
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
