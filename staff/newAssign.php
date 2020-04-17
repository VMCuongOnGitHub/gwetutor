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
        $updateUserRoleQuery = "UPDATE users SET is_assigned_role='{$_POST['radioRole']}', is_assigned_role_by='{$_SESSION['username']}' WHERE userID='{$_POST['id']}'";

        echo $updateUserRoleQuery;
        mysqli_query($db, $updateUserRoleQuery);

        if ($_POST['radioRole'] == 'tutor'){
            //echo $_POST['radioRole'] == 'tutor';
            $insertNewTutorQuery = "INSERT INTO tutors (tutorID, userID)";
            $tutorID = 'tutor' . $_POST['id'];
            $insertNewTutorQuery .= "VALUES ('{$tutorID}', '{$_POST['id']}')";

            mysqli_query($db, $insertNewTutorQuery);
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
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>GW E Tutor</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/sidebar.css">
    <!--        <link rel="stylesheet" type="text/css" href="css/style.css">-->
    <!--        <link rel="stylesheet" type="text/css" href="css/staffDashboard.css">-->

</head>
<body>

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
