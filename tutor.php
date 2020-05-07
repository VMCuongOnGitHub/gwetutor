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
<!----------------------------------------------------->
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">
            <nav id="sidebar">
                <div class="sidebar-header">
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
                                <h3>{$rowSelectTutorInfor['username']}</h3>
                                <span>{$rowSelectTutorInfor['email']}</span><br>
                                <span>is assign to </span>
                                <span>{$numberOfStudent} students</span>
                                
                            ";
                    }else{
                        echo "
                                    <h3>{$rowSelectTutorInfor['username']}</h3>
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
            </nav>
        </div>
        <div class="list-group list-group-flush">
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
                        $scheduleDatePrint = "Has schedule on <br>" . date_format($date,"d/m/Y H:i");
                    }
                    if (intval($interval->h) != 0){
                        $remainingTime .= $interval->h." hours ";
                        $scheduleDatePrint = "Has schedule on <br>" . date_format($date,"d/m/Y H:i");
                    }
                    //echo $remainingTime;

                    echo "
                            <a class='list-group-item list-group-item-action bg-light' href='student.php?id={$rowSelectStudentTutor['userID']}'>
                                <div class='user d-flex'>
                                    <div class='student'>
                                        <span style='color: #1b1e21'>{$rowSelectStudentTutor['username']}</span><br>
                                        <span style='color: #1b1e21'>{$rowSelectStudentTutor['email']}</span><br>
                                        <span style='color: #1b1e21'>{$scheduleDatePrint}</span><br>
                                        <span style='color: #1b1e21'>{$remainingTime}</span>
                                    </div>
                                </div>
                            </a>";
                }
            }


            ?>
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
                        <a href="index.php?logout='1'" class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-md-12"  style="height:500px">
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
                    <div class="chart-container" style="position: relative; height:100%;margin: auto;">
                        <canvas id="myChart4"></canvas>
                    </div>
<!--                    <canvas id="myChart4"></canvas>-->
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row" style="margin-top: 100px">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card" style="width: 100%">
                        <div class="card-body">
                            <h2 class="card-title"><?php echo $rowSelectTutor['total_assigned_student'] - 1?></h2>
                            <span>All Assigned Students</span>
                        </div>
                        <div class="card-body">
                            <h2 class="card-title"><?php echo $numberOfStudent?></h2>
                            <span>Being Assigned to Students</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card" style="width: 100%">
                        <div class="card-body">
                            <?php
                            $querySelectTotalMessages = "SELECT * FROM messages WHERE from_userID LIKE '%{$userID}'";
                            $resultsSelectTotalMessages = mysqli_query($db, $querySelectTotalMessages);
                            $totalMessages = mysqli_num_rows($resultsSelectTotalMessages);
                            ?>
                            <h2><?php echo $totalMessages?></h2>
                            <span>Total Messages</span>
                        </div>
                        <div class="card-body">
                            <?php
                            $querySelectTotalComments = "SELECT * FROM comments WHERE userID LIKE '%{$userID}'";
                            $resultsSelectTotalComments = mysqli_query($db, $querySelectTotalComments);
                            $totalComments = mysqli_num_rows($resultsSelectTotalComments);
                            ?>
                            <h2><?php echo $totalComments?></h2>
                            <span>Total Comments</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
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
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->


<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
<script>

    function openRightMenu() {
        document.getElementById("rightMenu1").style.display = "block";
    }

    function closeRightMenu() {
        document.getElementById("rightMenu1").style.display = "none";
    }

    let ctx = document.getElementById("myChart4").getContext('2d');
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
                text: 'Tutor Activities',
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