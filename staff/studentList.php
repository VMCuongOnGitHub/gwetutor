<?php include('header_staff.php') ?>


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
                            <a class="btn btn-warning" href="../index.php?logout=1" role="button">Logout</a>
                        </div>



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
                                        $querySelectTutorFromStudent = "SELECT tutorID FROM students WHERE userID='{$row['userID']}'";
                                        $resultSelectTutorFromStudent = mysqli_query($db, $querySelectTutorFromStudent);
                                        $rowSelectTutorFromStudent = mysqli_fetch_assoc($resultSelectTutorFromStudent);

                                        $tutorIDCut = substr($rowSelectTutorFromStudent['tutorID'], 5);

                                        $querySelectTutor = "SELECT * FROM users WHERE userID = '{$tutorIDCut}'";
                                        $resultSelectTutor = mysqli_query($db, $querySelectTutor);
                                        $rowSelectTutor = mysqli_fetch_assoc($resultSelectTutor);

                                        echo "<tr>
                                                <td>{$row['userID']}</td>
                                                <td><a href='../studentDashboard.php?id={$row['userID']}&tutorid={$tutorIDCut}'>{$row['username']}</a></td>
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
    </div>

</body>
</html>
