<?php
if(!isset($_SESSION))
{
    session_start();
}

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
    if ($_SESSION['user_role'] != 'staff') {
        $_SESSION['msg'] = "Unauthorized Access";
        header('location: login.php');
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}



$userID = $_GET['id'];
$tutorID = $_GET['tutorid'];

?>

<?php include('header.php') ?>

    <body>




    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">
                <nav id="sidebar">
                    <div class="sidebar-header">
                        <?php
                        $querySelectTutor = "SELECT * FROM users WHERE userID = '{$tutorID}'";
                        $resultsSelectTutor = mysqli_query($db, $querySelectTutor);
                        $rowSelectTutor = mysqli_fetch_assoc($resultsSelectTutor);

                        $querySelectStudentInfor = "SELECT * FROM users WHERE userID = '{$userID}'";
                        $resultsSelectStudentInfor = mysqli_query($db, $querySelectStudentInfor);
                        $rowSelectStudentInfor = mysqli_fetch_assoc($resultsSelectStudentInfor);



                        echo "
                                    <span>{$rowSelectStudentInfor['username']}</span><br>
                                    <span>{$rowSelectStudentInfor['email']}</span>
                                    <br>
                                    <span>is assigned to {$rowSelectTutor['email']}</span>
                                    <span></span>
                                    <br>
                                    <br>
                                    <a class='btn btn-primary' href='staff/staffDashboard.php' role='button'>Back</a>
                                ";
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

            <div class="container-fluid">
                <div class="row" style="margin-top: 100px">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card" style="width: 100%">
                            <div class="card-body">
                                <span id="title">Number of Messages</span>
                                <canvas id="my-tutor-pie-chart"></canvas>
                                <div class="result-tutor d-flex justify-content-around">
                                    <?php
                                    $querySelectMessageStudent = "SELECT * FROM messages WHERE from_userID = '{$userID}'";
                                    $resultsSelectMessageStudent = mysqli_query($db, $querySelectMessageStudent);
                                    $numberOfMessageStudentWithTutor = mysqli_num_rows($resultsSelectMessageStudent);

                                    $querySelectMessageTutor = "SELECT * FROM messages WHERE from_userID = '{$tutorID}'";
                                    $resultsSelectMessageTutor = mysqli_query($db, $querySelectMessageTutor);
                                    $numberOfMessageTutorWithStudent = mysqli_num_rows($resultsSelectMessageTutor);

                                    $numberOfMessages = $numberOfMessageStudentWithTutor + $numberOfMessageTutorWithStudent;
                                    echo "
                                    <div class='with-tutor d-flex flex-column'>
                                        <span>{$numberOfMessageStudentWithTutor}</span>
                                        <span>{$rowSelectStudentInfor['username']}</span>
                                    </div>
                                    <div class='with-tutor d-flex flex-column'>
                                        <span>$numberOfMessages</span>
                                        <span>Total Messages Exchanged</span>
                                    </div>
                                    <div class='with-tutor d-flex flex-column'>
                                        <span>{$numberOfMessageTutorWithStudent}</span>
                                        <span>Tutor</span>
                                    </div>
                                    ";
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card" style="width: 100%">
                            <div class="card-body">
                                <span id="title">Number of Comments</span>
                                <canvas id="my-student-pie-chart"></canvas>
                                <div class="result-tutor d-flex justify-content-around">
                                    <?php
                                    $querySelectStudentComments = "SELECT * FROM comments WHERE userID = '{$userID}'";
                                    $resultSelectStudentComments = mysqli_query($db, $querySelectStudentComments);
                                    $numberOfStudentComments = mysqli_num_rows($resultSelectStudentComments);

                                    $querySelectTutorComments = "SELECT * FROM comments WHERE userID = '{$tutorID}'";
                                    $resultSelectTutorComments = mysqli_query($db, $querySelectTutorComments);
                                    $numberOfTutorComments = mysqli_num_rows($resultSelectTutorComments);

                                    $numberOfComments = $numberOfStudentComments + $numberOfTutorComments;
                                    echo "
                                    <div class='with-tutor d-flex flex-column'>
                                        <span>{$numberOfStudentComments}</span>
                                        <span>From {$rowSelectStudentInfor['username']}</span>
                                    </div>
                                    <div class='with-tutor d-flex flex-column'>
                                        <span>{$numberOfComments}</span>
                                        <span>Total Comments</span>
                                    </div>
                                    <div class='with-tutor d-flex flex-column'>
                                        <span>{$numberOfTutorComments}</span>
                                        <span>From Tutor</span>
                                    </div>
                                    ";
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card" style="width: 100%">
                            <div class="card-body">
                                <?php
                                $arrayLatestSevenDays = array();
                                for ($i = 6; $i >= 0; $i--){
                                    $stringDayAgo = '-' . $i . ' days';
                                    $lastWeek = date("Y/m/d", strtotime($stringDayAgo));
                                    array_push($arrayLatestSevenDays, $lastWeek);
                                }
                                $arrayLatestThirtyDays = array();
                                for ($i = 30; $i >= 0; $i--){
                                    $stringDayAgo = '-' . $i . ' days';
                                    $lastWeek = date("Y/m/d", strtotime($stringDayAgo));
                                    array_push($arrayLatestThirtyDays, $lastWeek);
                                }
                                ?>
                                <div class="summary  col-md-4">
                                    <?php
                                    $today = date("Y/m/d");
                                    $querySelectMessageEachDay = "SELECT * FROM messages WHERE to_userID = '{$GLOBALS['userID']}' AND time_created LIKE '$today%'";
                                    $resultsSelectMessageEachDay = mysqli_query($db, $querySelectMessageEachDay);
                                    $numberOfMessageEachDay = mysqli_num_rows($resultsSelectMessageEachDay);

                                    $querySelectCommentsEachDay = "SELECT * FROM comments WHERE userID = '{$GLOBALS['userID']}' AND time_created LIKE '$today%'";
                                    $resultsSelectCommentsEachDay = mysqli_query($db, $querySelectCommentsEachDay);
                                    $numberOfCommentsEachDay = mysqli_num_rows($resultsSelectCommentsEachDay);

                                    $numberStudentMessagesWeekly = 0;
                                    $numberStudentCommentsWeekly = 0;
                                    foreach($arrayLatestSevenDays as $value){
                                        $querySelectMessageEachDay = "SELECT * FROM messages WHERE to_userID = '{$GLOBALS['userID']}' AND time_created LIKE '$value%'";
                                        $resultsSelectMessageEachDay = mysqli_query($db, $querySelectMessageEachDay);
                                        $numberOfMessageEachDay = mysqli_num_rows($resultsSelectMessageEachDay);

                                        $today = str_replace("/","-",$value);
                                        $querySelectCommentsEachDay = "SELECT * FROM comments WHERE userID = '{$GLOBALS['userID']}' AND time_created LIKE '$today%'";
                                        $resultsSelectCommentsEachDay = mysqli_query($db, $querySelectCommentsEachDay);
                                        $numberOfCommentsEachDay = mysqli_num_rows($resultsSelectCommentsEachDay);

                                        $numberStudentMessagesWeekly += $numberOfMessageEachDay;
                                        $numberStudentCommentsWeekly += $numberOfCommentsEachDay;
                                    }

                                    $numberStudentMessagesMonthly = 0;
                                    $numberStudentCommentsWeekly = 0;
                                    foreach($arrayLatestThirtyDays as $value){
                                        $querySelectMessageEachDay = "SELECT * FROM messages WHERE to_userID = '{$GLOBALS['userID']}' AND time_created LIKE '$value%'";
                                        $resultsSelectMessageEachDay = mysqli_query($db, $querySelectMessageEachDay);
                                        $numberOfMessageEachDay = mysqli_num_rows($resultsSelectMessageEachDay);

                                        $today = str_replace("/","-",$value);
                                        $querySelectCommentsEachDay = "SELECT * FROM comments WHERE userID = '{$GLOBALS['userID']}' AND time_created LIKE '$today%'";
                                        $resultsSelectCommentsEachDay = mysqli_query($db, $querySelectCommentsEachDay);
                                        $numberOfCommentsEachDay = mysqli_num_rows($resultsSelectCommentsEachDay);

                                        $numberStudentMessagesMonthly += $numberOfMessageEachDay;
                                        $numberStudentCommentsWeekly += $numberOfCommentsEachDay;
                                    }


                                    echo "
                                        <table class='table'>
                                          <thead>
                                            <tr>
                                              <th scope='col'></th>
                                              <th scope='col'>Messages</th>
                                              <th scope='col'>Comments</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <th scope='row'>Today</th>
                                              <td>{$numberOfMessageEachDay}</td>
                                              <td>{$numberOfCommentsEachDay}</td>
                                              
                                            </tr>
                                            <tr>
                                              <th scope='row'>Last 7 Days</th>
                                              <td>{$numberStudentMessagesWeekly}</td>
                                              <td>{$numberStudentCommentsWeekly}</td>
                                              
                                            </tr>
                                            <tr>
                                              <th scope='row'>Last 30 Days</th>
                                              <td>{$numberStudentMessagesMonthly}</td>
                                              <td>{$numberStudentCommentsWeekly}</td>
                                              
                                            </tr>
                                          </tbody>
                                        </table>
                                    ";
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /#page-content-wrapper -->

        </div>
        <!-- /#wrapper -->




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
                        label: "Tutor's Messages",
                        backgroundColor: "#caf270",
                        stack: "0",
                        data: [<?php
                            $dataTutorMessages = "";
                            foreach($arrayLatestSevenDays as $value){
                                $querySelectMessageEachDay = "SELECT * FROM messages WHERE from_userID = '{$GLOBALS['tutorID']}' AND time_created LIKE '$value%'";
                                $resultsSelectMessageEachDay = mysqli_query($db, $querySelectMessageEachDay);
                                $numberOfMessageEachDay = mysqli_num_rows($resultsSelectMessageEachDay);

                                $dataTutorMessages .= '"' . $numberOfMessageEachDay . '"' . ",";
                            }
                            $dataTutorMessages = rtrim($dataTutorMessages, ",");
                            echo $dataTutorMessages;
                            ?>],
                    }, {
                        label: "Student's Comments",
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
                    }, {
                        label: "Tutor's Comments",
                        backgroundColor: "#004593",
                        stack: "1",
                        data: [<?php
                            $dataTutorComment = "";
                            foreach($arrayLatestSevenDays as $value){
                                $dateConverter = str_replace("/","-",$value);
                                $querySelectMessageEachDay = "SELECT * FROM comments WHERE userID = '{$GLOBALS['tutorID']}' AND time_created LIKE '$dateConverter%'";
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

            let pieChart = document.getElementById('my-tutor-pie-chart').getContext('2d');
            // Global Options
            Chart.defaults.global.defaultFontFamily = 'Lato';
            Chart.defaults.global.defaultFontSize = 18;
            Chart.defaults.global.defaultFontColor = '#777';
            pieChart.canvas.parentNode.style.height = '30vh';
            pieChart.canvas.parentNode.style.width = '27rem';
            let massPopChart = new Chart(pieChart, {
                type: 'pie',
                data: {
                    datasets: [{
                        label: "Population (millions)",
                        backgroundColor: ["#3e95cd", "#8e5ea2"],
                        data: [<?php echo $numberOfMessageStudentWithTutor?>, <?php echo $numberOfMessageTutorWithStudent?>]
                    }]
                },
            });

            let studentPie = document.getElementById('my-student-pie-chart').getContext('2d');
            // Global Options
            Chart.defaults.global.defaultFontFamily = 'Lato';
            Chart.defaults.global.defaultFontSize = 18;
            Chart.defaults.global.defaultFontColor = '#777';
            studentPie.canvas.parentNode.style.height = '30vh';
            studentPie.canvas.parentNode.style.width = '27rem';
            let messPopChart = new Chart(studentPie, {
                type: 'pie',
                data: {
                    datasets: [{
                        label: "Population (millions)",
                        backgroundColor: ["#3e95cd", "#8e5ea2"],
                        data: [<?php echo $numberOfStudentComments?>, <?php echo $numberOfTutorComments?>]
                    }]
                },
            });
        </script>

    </body>

    </html>




<?php include('footer.php') ?>