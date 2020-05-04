<?php include('header_staff.php') ?>

<?php
    if (isset($_GET['id'])) {
      echo $_GET['id'];
      if (isset($_POST['radioRole'])) {
          $selectTutors = "SELECT * FROM tutors WHERE userID='{$_POST['tutorname']}'";
          $results = mysqli_query($db, $selectTutors);
          $row = mysqli_fetch_assoc($results);

          $updateUserRoleQuerry = "UPDATE users SET is_assigned_role='{$_POST['radioRole']}' WHERE userID='{$_GET['id']}'";
          $insertNewStudentQuerry = "INSERT INTO students (studentID, userID, tutorID)";
          $studentID = 'stu' . $_GET['id'];
          $insertNewStudentQuerry .= "VALUES ({$studentID}, '{$_GET['id']}', '{$row['tutorID']}')";

          mysqli_query($db, $updateUserRoleQuerry);
          mysqli_query($db, $insertNewStudentQuerry);
      }
    }

?>


<body>
<div class="container-fluid">

    <!-- The Modal -->
    <div class="modal" id="myModal1">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>
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
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search Name or Email">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </nav>

                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tutor Email</th>
                                <th scope="col">Messages</th>
                                <th scope="col">Assign</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT * FROM users WHERE is_assigned_role='0'";

                                $results = mysqli_query($db, $query);

                                while($row = mysqli_fetch_assoc($results)) {
                                    echo "<tr>
                                        <th scope='row'>1</th>
                                        <td>{$row['email']}</td>
                                        <td>{$row['message_to_staff']}</td>
                                        <td>
                                            <button class='btn btn-primary' data-toggle='modal' data-target='#myModal1' data-formid='{$row['userID']}'>Assign</button>
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
    <script>
        $(document).ready(function(){
            //jQuery function for loading data
            $("#myModal1").on('show.bs.modal', function(event){
                var button = $(event.relatedTarget);
                //bootstrap way of retrieving data-* attributes
                //data-formid in this case
                var id = button.data('formid');
                $.get('newAssign.php?id='+id,
                    function(data) {
                        $("#myModal1 .modal-content").html(data);
                        $("#myModal1").modal("handleUpdate");
                    });
            });
        });

    </script>

</body>

</html>
