<?php
    $db = mysqli_connect('localhost', 'root', '', 'etutor');
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

    if (isset($_POST['radioRole'])) {
        $selectTutors = "SELECT * FROM tutors WHERE userID='{$_POST['tutorname']}'";
        $results = mysqli_query($db, $selectTutors);
        $row = mysqli_fetch_assoc($results);

        $updateUserRoleQuerry = "UPDATE users SET is_assigned_role='{$_POST['radioRole']}' WHERE userID='{$_GET['id']}'";
        $insertNewStudentQuerry = "INSERT INTO students (studentID, userID, tutorID)";
        $studentID = 'stu' . {$_GET['id']};
        $insertNewStudentQuerry .= "VALUES ({$studentID}, '{$_GET['id']}', '{$row['tutorID']}')";

        mysqli_query($db, $updateUserRoleQuerry);
        mysqli_query($db, $insertNewStudentQuerry);
    }

?>

<form action="" method="post">
    <div class="form-group">
      <label for="radioRole">Select list (select one):</label>
      <input type="radio" name="radioRole" value="student">Student
      <input type="radio" name="radioRole" value="tutor">Tutor
    </div>
    <div class="form-group">
      <label for="sel1">Assign to a Tutor</label>
      <select class="form-control" id="sel1" name="tutorname">
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
