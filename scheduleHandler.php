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

        $query = "INSERT INTO schedules";
        $query .= " VALUES ('{$scheduleID}', '{$userID}', '{$schedule_time}', '{$schedule_content}', '{$time_created}')";
        mysqli_query($db, $query);
    }
?>

<?php
    echo "<script src=https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js></script>";
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

        $dateString = date('Y-m-d');
        $timeString = date('H:i:s');

        $stringNow = $dateString . "T" . $timeString;

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
                    <div class='col-sm-6'>
                        <p>{$rowSelectSchedule['content_schedule']}</p>
                    </div>
                    <div class='col-sm-4'>
                        <label for='title-schedule'>Related Document</label>
                        <ul id='file-list_{$rowSelectSchedule['scheduleID']}'>";
                            $querySelectFile = "SELECT * FROM relateddocuments WHERE scheduleID = '{$rowSelectSchedule['scheduleID']}'";
                            $resultSelectFile = mysqli_query($db, $querySelectFile);

                            while($row = mysqli_fetch_assoc($resultSelectFile)){
                                echo "<li><a href='{$row['url_related_document']}'>{$row['name_related_document']}</a></li>";
                            }
                        echo "</ul>
                        <form action='uploadFileRelatedDocument.php' method='post' enctype='multipart/form-data' id='uploadfile_{$rowSelectSchedule['scheduleID']}'>
                          <input type='hidden' name='scheduleID' value='{$rowSelectSchedule['scheduleID']}'>
                          <input type='hidden' name='time_created' value='{$stringNow}'>
                          <input type='file' name='fileToUpload' id='fileToUpload'>
                          <input type='submit' value='Upload File' name='submit' id='uploadfile_{$rowSelectSchedule['scheduleID']}'>
                        </form>
                    </div>
                </div>
            </div>
            
        ";
        echo "
            <script type='text/javascript'>
            $(document).ready(function () {
                $('#uploadfile_{$rowSelectSchedule['scheduleID']}').on('submit',(function(e) {
                    let file_data1 = $('input[name=fileToUpload]').prop('files')[0];
                    let formData1 = new FormData(this);
                    formData1.append('file', file_data1);
                    
                    e.preventDefault();
                    $.ajax({
                            url: 'uploadFileRelatedDocument.php',
                            type: 'POST',
                            data:  formData1,
                            enctype: 'multipart/form-data',
                            contentType: false,
                            cache: false,
                            processData:false,
                            dataType: 'text',
                            success: function(data){
                                $('#file-list_{$rowSelectSchedule['scheduleID']}').html(data);
                            }, error: function() {
                                $('#file-list_{$rowSelectSchedule['scheduleID']}').html('<p></p>');
                            }
                    });
                    
                    $('#uploadfile_{$rowSelectSchedule['scheduleID']}').val(null);
                }));
             });
        </script>
        ";
    }
?>

<?php

?>


