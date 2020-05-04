<?php
    if(!isset($_SESSION))
    {
        session_start();
    }

    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
        if ($_SESSION['user_role'] != 'tutor') {
            $_SESSION['msg'] = "Unauthorized Access";
            header('location: login.php');
        }
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: login.php");
    }


    $userID = $_SESSION['userID'];
    if (isset($_GET['id'])){
        $userID = $_GET['id'];
    }

?>

<?php include('header.php') ?>

<body>

<div class="container-fluid">
    <div class="row">
        <div class="wrapper">

            <div class="sidebar">
                <div class="infor-user d-flex justify-content-around">
                    <div class="detail">
                        <?php
                            $querySelectTutor = "SELECT * FROM tutors WHERE userID = '{$userID}'";
                            $resultsSelectTutor = mysqli_query($db, $querySelectTutor);
                            $rowSelectTutor = mysqli_fetch_assoc($resultsSelectTutor);


                            $querySelectStudentTutor = "SELECT users.userID, users.username, users.email FROM students INNER JOIN users ON users.userID = students.userID WHERE tutorID = '{$rowSelectTutor['tutorID']}'";
                            $resultsSelectStudentTutor = mysqli_query($db, $querySelectStudentTutor);

                            $querySelectTutorInfor = "SELECT * FROM users WHERE userID = '{$userID}'";
                            $resultsSelectTutorInfor = mysqli_query($db, $querySelectTutorInfor);
                            $rowSelectTutorInfor = mysqli_fetch_assoc($resultsSelectTutorInfor);


                            $numberOfStudent = mysqli_num_rows($resultsSelectStudentTutor);
                            if (isset($_GET['id']) == false){

                                echo "
                                <span>{$rowSelectTutorInfor['username']}</span><br>
                                <span>{$rowSelectTutorInfor['email']}</span>
                                <span>is assign to </span>
                                <span>{$numberOfStudent} students</span>
                                
                            ";
                            }else{
                                echo "
                                    <span>{$rowSelectTutorInfor['username']}</span><br>
                                    <span>{$rowSelectTutorInfor['email']}</span>
                                    <br>
                                    <span>is assigned to </span>
                                    <span>{$numberOfStudent} student(s)</span>
                                    <br>
                                    <br>
                                    <a class='btn btn-primary' href='staff/staffDashboard.php' role='button'>Back</a>
                                ";
                                
                            }
                        ?>

                    </div>
                </div>
                <div class="assigned">
                    <ul>
                        <?php
                            if (isset($_GET['id']) == false){

                                while($rowSelectStudentTutor = mysqli_fetch_assoc($resultsSelectStudentTutor)) {
                                    $today = date('Y-m-d H:i');
                                    $querySchedule = "SELECT * FROM schedules WHERE userID = '{$rowSelectStudentTutor['userID']}'";
                                    $resultSchedule = mysqli_query($db, $querySchedule);
                                    $rowSelectSchedule = mysqli_fetch_assoc($resultSchedule);
                                    $stringDate = $rowSelectSchedule['time_schedule'];
                                    $date = date_create($stringDate);
                                    $scheduleDate = date_format($date,"Y-m-d H:i");

                                    $date1 = new DateTime(strval($today));
                                    $date2 = new DateTime(strval($scheduleDate));
                                    $interval = $date2->diff($date1);



                                    $remainingTime = '';
                                    $scheduleDatePrint = '';
                                    if (intval($interval->d) != 0){
                                        $remainingTime .= $interval->d." days ";
                                        $scheduleDatePrint = "Has schedule on " . date_format($date,"d/m/Y H:i");
                                    }
                                    if (intval($interval->h) != 0){
                                        $remainingTime .= $interval->h." hours ";
                                        $scheduleDatePrint = "Has schedule on " . date_format($date,"d/m/Y H:i");
                                    }
                                    //echo $remainingTime;

                                    echo "<li>
                                        <a href='student.php?id={$rowSelectStudentTutor['userID']}'>
                                            <div class='user d-flex'>
                                                <div class='student'>
                                                    <span>{$rowSelectStudentTutor['username']}</span><br>
                                                    <span>{$rowSelectStudentTutor['email']}</span><br>
                                                    <span>{$scheduleDatePrint}</span><br>
                                                    <span>{$remainingTime}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>";
                                }
                            }


                        ?>


                    </ul>
                </div>
            </div>


            <div class="main_content">
                <div class="right-action col-sm-10">
                    <div class="right-action-header">
                        <a class="btn btn-warning" href="index.php?logout='1'" role="button">Logout</a>

                    </div>
                    <div class="right-action-banner d-flex justify-content-between">
                        <div class="banner-date-picker row">
                            <div class="start-date date d-flex justify-content-around">
                                <span>12/04/2020</span>
                                <i class="fa fa-calendar-alt"></i>
                            </div>
                            <div class="end-date date d-flex justify-content-around">
                                <span>Now</span>
                                <i class="fa fa-calendar-alt"></i>
                            </div>
                        </div>
                    </div>

                    <div class="right-content-bar">
                        <canvas id="myChart4"></canvas>
                    </div>

                    <div class="right-statistical d-flex">
                        <div class="assigned-student">
                            <div class="all-assigned d-flex justify-content-around">
                                <span id="object">All Assigned Students</span>
                                <span id="number"><?php echo $rowSelectTutor['total_assigned_student'] - 1?></span>
                            </div>
                            <div class="assigned-student-result d-flex justify-content-around">
                                <span id="object">Being Assigned to Students</span>
                                <span id="number"><?php echo $numberOfStudent?></span>
                            </div>
                        </div>
                        <div class="assigned-student">
                            <div class="all-assigned d-flex justify-content-around">
                                <span id="object">Total Messages</span>
                                <?php
                                    $querySelectTotalMessages = "SELECT * FROM messages WHERE from_userID LIKE '%{$userID}'";
                                    $resultsSelectTotalMessages = mysqli_query($db, $querySelectTotalMessages);
                                    $totalMessages = mysqli_num_rows($resultsSelectTotalMessages);
                                ?>
                                <span id="number"><?php echo $totalMessages?></span>
                            </div>
                            <div class="assigned-student-result d-flex justify-content-around">
                                <span id="object">Total Comments</span>
                                <?php
                                    $querySelectTotalComments = "SELECT * FROM comments WHERE userID LIKE '%{$userID}'";
                                    $resultsSelectTotalComments = mysqli_query($db, $querySelectTotalComments);
                                    $totalComments = mysqli_num_rows($resultsSelectTotalComments);
                                ?>
                                <span id="number"><?php echo $totalComments?></span>
                            </div>
                        </div>
                    </div>
                    <?php
                        $arrayLatestSevenDays = array();
                        for ($i = 6; $i >= 0; $i--){
                            $stringDayAgo = '-' . $i . ' days';
                            $lastWeek = date("Y/m/d", strtotime($stringDayAgo));
                            array_push($arrayLatestSevenDays, $lastWeek);
                        }


                    ?>
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">STUDENT EMAIL</th>
                            <th scope="col">NUMBER OF MESSAGES</th>
                            <th scope="col">COMMENT(S) ON POSTS</th>
                            <th scope="col">MEETING SCHEDULED</th>
                        </tr>
                        </thead>
                        <tbody>

                            <?php
                                 mysqli_data_seek($resultsSelectStudentTutor, 0);
                                while($rowSelectStudentTutor = mysqli_fetch_assoc($resultsSelectStudentTutor)) {
                                    $querySelectNumberOfMessages = "SELECT * FROM messages WHERE from_userID = '{$userID}' AND to_userID = '{$rowSelectStudentTutor['userID']}'";
                                    $resultsSelectNumberOfMessages = mysqli_query($db, $querySelectNumberOfMessages);
                                    $numberOfMessagesWithStudent = mysqli_num_rows($resultsSelectNumberOfMessages);

                                    $querySelectNumberOfComments = "SELECT content_comment FROM comments INNER JOIN posts ON comments.postID = posts.postID WHERE comments.userID = '{$userID}' AND posts.userID = '{$rowSelectStudentTutor['userID']}'";
                                    $resultsSelectNumberOfComments = mysqli_query($db, $querySelectNumberOfComments);

                                    $numberOfCommentStudent = mysqli_num_rows($resultsSelectNumberOfComments);

                                    $today = date('Y-m-d H:i');
                                    $querySchedule = "SELECT * FROM schedules WHERE userID = '{$rowSelectStudentTutor['userID']}'";
                                    $resultSchedule = mysqli_query($db, $querySchedule);
                                    $rowSelectSchedule = mysqli_fetch_assoc($resultSchedule);
                                    $stringDate = $rowSelectSchedule['time_schedule'];
                                    $date = date_create($stringDate);
                                    $scheduleDate = date_format($date,"Y-m-d H:i");

                                    $date1 = new DateTime(strval($today));
                                    $date2 = new DateTime(strval($scheduleDate));
                                    $interval = $date2->diff($date1);



                                    $remainingTime = '';
                                    $scheduleDatePrint = '';
                                    if (intval($interval->d) != 0){
                                        $remainingTime .= $interval->d." days ";
                                        $scheduleDatePrint = "Has schedule on " . date_format($date,"d/m/Y H:i");
                                    }
                                    if (intval($interval->h) != 0){
                                        $remainingTime .= $interval->h." hours ";
                                        $scheduleDatePrint = "Has schedule on " . date_format($date,"d/m/Y H:i");
                                    }
                                    echo "
                                        <tr>
                                            <td>{$rowSelectStudentTutor['email']}</td>
                                            <td>{$numberOfMessagesWithStudent}</td>
                                            <td>{$numberOfCommentStudent}</td>
                                            <td>{$scheduleDatePrint} - {$remainingTime}</td>
                                        </tr>
                                        ";
                                }

                            ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</div>



<script>

    function openRightMenu() {
        document.getElementById("rightMenu1").style.display = "block";
    }

    function closeRightMenu() {
        document.getElementById("rightMenu1").style.display = "none";
    }

    let ctx = document.getElementById("myChart4").getContext('2d');
    ctx.canvas.parentNode.style.height = '50vh';
    ctx.canvas.parentNode.style.width = '79rem';
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?php
                    $sevenDayString = "";
                    foreach($arrayLatestSevenDays as $value){
                        $sevenDayString .= '"' . $value . '"' . ",";
                    }
                    $sevenDayString = rtrim($sevenDayString, ",");
                    echo $sevenDayString;
                ?>],
            datasets: [{
                label: "Tutor's Messages",
                backgroundColor: "#caf270",
                stack: "0",
                data: [<?php
                        $dataTutorMessages = "";
                        foreach($arrayLatestSevenDays as $value){
                            $querySelectMessageEachDay = "SELECT * FROM messages WHERE from_userID = '{$GLOBALS['userID']}' AND time_created LIKE '$value%'";
                            $resultsSelectMessageEachDay = mysqli_query($db, $querySelectMessageEachDay);
                            $numberOfMessageEachDay = mysqli_num_rows($resultsSelectMessageEachDay);

                            $dataTutorMessages .= '"' . $numberOfMessageEachDay . '"' . ",";
                        }
                        $dataTutorMessages = rtrim($dataTutorMessages, ",");
                        echo $dataTutorMessages;
                    ?>],
            }, {
                label: "Students' Messages",
                backgroundColor: "#45c490",
                stack: "0",
                data: [<?php
                        $dataStudentMessages = "";
                        foreach($arrayLatestSevenDays as $value){
                            $querySelectMessageEachDay = "SELECT * FROM messages WHERE to_userID = '{$GLOBALS['userID']}' AND time_created LIKE '$value%'";
                            $resultsSelectMessageEachDay = mysqli_query($db, $querySelectMessageEachDay);
                            $numberOfMessageEachDay = mysqli_num_rows($resultsSelectMessageEachDay);

                            $dataStudentMessages .= '"' . $numberOfMessageEachDay . '"' . ",";
                        }
                        $dataStudentMessages = rtrim($dataStudentMessages, ",");
                        echo $dataStudentMessages;
                    ?>],
            }, {
                label: "Tutor's Comments",
                backgroundColor: "#008d93",
                stack: "1",
                data: [<?php
                        $dataTutorComment = "";
                        foreach($arrayLatestSevenDays as $value){
                            $dateConverter = str_replace("/","-",$value);
                            $querySelectMessageEachDay = "SELECT * FROM comments WHERE userID = '{$GLOBALS['userID']}' AND time_created LIKE '$dateConverter%'";
                            //echo $querySelectMessageEachDay;
                            $resultsSelectMessageEachDay = mysqli_query($db, $querySelectMessageEachDay);
                            $numberOfMessageEachDay = mysqli_num_rows($resultsSelectMessageEachDay);

                            $dataTutorComment .= '"' . $numberOfMessageEachDay . '"' . ",";
                        }
                        $dataTutorComment = rtrim($dataTutorComment, ",");
                        echo $dataTutorComment;
                    ?>],
            }],
        },
        options: {
            title: {
                display: true,
                text: 'Number of messages',
                fontSize: 25
            },
            tooltips: {
                displayColors: true,
                callbacks: {
                    mode: 'x',
                },
            },
            scales: {
                xAxes: [{
                    stacked: true,
                    gridLines: {
                        display: true,
                    }
                }],
                yAxes: [{
                    stacked: true,
                    ticks: {
                        beginAtZero: true,
                    }
                }]
            },
            responsive: true,
            maintainAspectRatio: false,
            legend: { position: 'bottom' },
        }
    });
</script>

</body>

</html>




<?php include('footer.php') ?>