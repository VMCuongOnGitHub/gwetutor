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
    </div>

</body>
</html>
