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
<!-- The Modal -->
<div class="modal" id="myModal1">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>
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

        <div class="container-fluid">
            <form style="margin-top: 20px; margin-bottom: 20px">
                <div class="form-group">
                    <input type="text" class="form-control" id="search_user" placeholder="Search User">
                </div>
            </form>
            <table class="table">
                <thead class="thead-light">
                <tr>
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
<!-- /#wrapper -->


<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>


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
