<?php include('header_staff.php') ?>

<?php


    if (isset($_POST['radioRole'])) {
        $updateUserRoleQuery = "UPDATE users SET is_assigned_role='{$_POST['radioRole']}', is_assigned_role_by='{$_SESSION['username']}' WHERE userID='{$_POST['id']}'";

        echo $updateUserRoleQuery;
        mysqli_query($db, $updateUserRoleQuery);

        if ($_POST['radioRole'] == 'tutor'){
            //echo $_POST['radioRole'] == 'tutor';
            $insertNewTutorQuery = "INSERT INTO tutors (tutorID, userID)";
            $tutorID = 'tutor' . $_POST['id'];
            $insertNewTutorQuery .= "VALUES ('{$tutorID}', '{$_POST['id']}')";

            mysqli_query($db, $insertNewTutorQuery);

            $queryUpdateTutorTotalAssign = "UPDATE tutors SET total_assigned_student = total_assigned_student + 1 WHERE tutorID = '{$tutorID}'";
            mysqli_query($db, $queryUpdateTutorTotalAssign);

            header('location: unassignedUser.php');
        }else{
            $selectTutors = "SELECT * FROM tutors WHERE userID='{$_POST['tutorname']}'";
            $results = mysqli_query($db, $selectTutors);
            $row = mysqli_fetch_assoc($results);

            $insertNewStudentQuery = "INSERT INTO students (studentID, userID, tutorID)";
            $studentID = 'stu' . $_POST['id'];
            $insertNewStudentQuery .= "VALUES ('{$studentID}', '{$_POST['id']}', '{$row['tutorID']}')";

            mysqli_query($db, $insertNewStudentQuery);
            header('location: unassignedUser.php');
        }
    }

?>


<form action="newAssign.php" method="post">
    <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
    <div class="form-group" id="radioRoleDiv">
      <label for="radioRole">Assign as</label>
        <input type="radio" name="radioRole" value="tutor" required checked>Tutor
      <input type="radio" name="radioRole" value="student" required>Student
    </div>
    <div class="form-group" id="forStudent">
      <label for="sel1">Assign Student to a Tutor</label>
      <select class="form-control" id="sel1" name="tutorname" required>
        <?php
          $query = "SELECT * FROM users WHERE is_assigned_role='tutor'";
          $results = mysqli_query($db, $query);

          while($row = mysqli_fetch_assoc($results)) {
              echo "<option value='{$row['userID']}'>{$row['username']}</option>";
          }
        ?>
      </select>
    </div>
    <div class="form-group">
      <button type="submit" name="submitAssign">Save</button>
    </div>
</form>

<script>
    $(document).ready(function(){
        $('#forStudent').hide();
        $("#radioRoleDiv input").click(function() {
            if ($('input[name="radioRole"]:checked').val() == "tutor"){
                $('#forStudent').hide();
            }

            if ($('input[name="radioRole"]:checked').val() == "student"){
                $('#forStudent').show();
            }
        });

    });
</script>
</body>
</html>
