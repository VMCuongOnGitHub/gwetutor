<?php include('server.php') ?>
<?php
    if (isset($_GET['id'])){
        $userID= $_GET['id'];
        $_SESSION['studentID'] = $_GET['id'];
    }else{
        $userID= $_SESSION['userID'];
    }





    if (isset($_POST['description-schedule'])) {
        $scheduleID = 'sche' . randomPassword();
        $schedule_time = mysqli_real_escape_string($db, $_POST['time-schedule']);
        $schedule_content = mysqli_real_escape_string($db, $_POST['description-schedule']);
        $time_created = $_POST['time_created'];
        $userID = $_POST['userID'];

        $queryCheckExist = "SELECT * FROM schedules WHERE userID = '{$userID}'";
        $resultsCheckExist = mysqli_query($db, $queryCheckExist);
        $numberOfSchedule = mysqli_num_rows($resultsCheckExist);

        if ($numberOfSchedule == 0){
            $query = "INSERT INTO schedules";
            $query .= " VALUES ('{$scheduleID}', '{$userID}', '{$schedule_time}', '{$schedule_content}', '{$time_created}')";
        }else{
            $query = "UPDATE schedules SET";
            $query .= " scheduleID= '{$scheduleID}', time_schedule= '{$schedule_time}', content_schedule= '{$schedule_content}', time_created= '{$time_created}' WHERE userID = '{$userID}'";
        }

        mysqli_query($db, $query);

//        if (!empty($_FILES['file'])){
//            $imageID = 'image' . randomPassword();
//            $image_name = randomPassword() . '-' . basename($_FILES["imageToUpload"]["name"]);
//            uploadFile("imageToUpload", $image_name);
//
//            $queryImage = "INSERT INTO images (imageID, image_name, postID)";
//            $queryImage .= " VALUES ('{$imageID}', '{$image_name}', '{$scheduleID}')";
//
//
//            mysqli_query($db, $queryImage);
//        }
    }
?>

<?php
    if (isset($_SESSION['studentID'])){
        $userID = $_SESSION['studentID'];
    }else{
        $userID = $_SESSION['userID'];
    }
    $querySelectSchedule = "SELECT * FROM schedules WHERE userID = '{$userID}'";
    $resultsSelectSchedule = mysqli_query($db, $querySelectSchedule);

    while($rowSelectSchedule = mysqli_fetch_assoc($resultsSelectSchedule)) {
        $date = $rowSelectSchedule['time_schedule'];
        $date = strtotime($date);
        $day = date('d', $date);
        $month = date('M', $date);
        $dayfull = $day . '/' . date('m', $date);
        $year = date('Y', $date);

        echo "
            <div class='container-fluid' style='background-color: #ffffff; margin-top: 10px; padding: 20px 10px 20px 10px'>
                <div class='row'>
                    <div class='col-sm-2'>
                        <div class='text-center'>
                            <div style='padding-top: 10px; padding-bottom: 10px; background-color: #5f5f5f; margin-bottom: 10px; color: white'>
                                <h1>{$day}</h1>
                                <h3>{$month}</h3>
                            </div>
            
                            <h4>{$dayfull}</h4>
                            <h4>{$year}</h4>
                        </div>
            
                    </div>
                    <div class='col-sm-10'>
                        <p>{$rowSelectSchedule['content_schedule']}</p>
                        
                    </div>
                </div>
            </div>
        ";
    }


?>


