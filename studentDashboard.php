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

    <div class="container-fluid">
        <div class="row">
            <div class="wrapper">

                <div class="sidebar">
                    <div class="infor-user d-flex justify-content-around">
                        <div class="detail">
                            <?php
                            $querySelectTutor = "SELECT * FROM users WHERE userID = '{$tutorID}'";
                            $resultsSelectTutor = mysqli_query($db, $querySelectTutor);
                            $rowSelectTutor = mysqli_fetch_assoc($resultsSelectTutor);

//                            $querySelectStudentTutor = "SELECT users.userID, users.username, users.email FROM students INNER JOIN users ON users.userID = students.userID WHERE tutorID = '{$rowSelectTutor['tutorID']}'";
//                            $resultsSelectStudentTutor = mysqli_query($db, $querySelectStudentTutor);

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

                        <div class="right-content-bar col-md-12">
                            <canvas id="myChart4"></canvas>
                        </div>

                        <div class="right-content-summary d-flex justify-content-around">
                            <div class="pie-tutor col-md-4">
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
                            <div class="pie-student  col-md-4">
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

                                    $dateConverter = str_replace("/","-",$today);
                                    $querySelectCommentEachDay = "SELECT * FROM comments WHERE userID = '{$GLOBALS['userID']}' AND time_created LIKE '$dateConverter%'";
                                    $resultsSelectCommentEachDay = mysqli_query($db, $querySelectCommentEachDay);
                                    $numberOfCommentEachDay = mysqli_num_rows($resultsSelectCommentEachDay);

                                    $numberStudentMessagesWeekly = 0;
                                    $numberStudentCommentsWeekly = 0;
                                    foreach($arrayLatestSevenDays as $value){
                                        $querySelectMessageEachDay = "SELECT * FROM messages WHERE to_userID = '{$GLOBALS['userID']}' AND time_created LIKE '$value%'";
                                        $resultsSelectMessageEachDay = mysqli_query($db, $querySelectMessageEachDay);
                                        $numberOfMessageEachDay = mysqli_num_rows($resultsSelectMessageEachDay);

                                        $numberStudentMessagesWeekly += $numberOfMessageEachDay;

                                        $dateConverter = str_replace("/","-",$value);
                                        $querySelectCommentEachDay = "SELECT * FROM comments WHERE userID = '{$GLOBALS['userID']}' AND time_created LIKE '$dateConverter%'";
                                        $resultsSelectCommentEachDay = mysqli_query($db, $querySelectCommentEachDay);
                                        $numberOfCommentEachDay = mysqli_num_rows($resultsSelectCommentEachDay);

                                        $numberStudentCommentsWeekly += $numberOfCommentEachDay;
                                    }

                                    $numberStudentMessagesMonthly = 0;
                                    $numberStudentCommentsMonthly = 0;
                                    foreach($arrayLatestThirtyDays as $value){
                                        $querySelectMessageEachDay = "SELECT * FROM messages WHERE to_userID = '{$GLOBALS['userID']}' AND time_created LIKE '$value%'";
                                        $resultsSelectMessageEachDay = mysqli_query($db, $querySelectMessageEachDay);
                                        $numberOfMessageEachDay = mysqli_num_rows($resultsSelectMessageEachDay);

                                        $numberStudentMessagesMonthly += $numberOfMessageEachDay;

                                        $dateConverter = str_replace("/","-",$value);
                                        $querySelectCommentEachDay = "SELECT * FROM comments WHERE userID = '{$GLOBALS['userID']}' AND time_created LIKE '$dateConverter%'";
                                        $resultsSelectCommentEachDay = mysqli_query($db, $querySelectCommentEachDay);
                                        $numberOfCommentEachDay = mysqli_num_rows($resultsSelectCommentEachDay);

                                        $numberStudentCommentsMonthly += $numberOfCommentEachDay;
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
                                              <td>{$numberOfCommentEachDay}</td>
                                              
                                            </tr>
                                            <tr>
                                              <th scope='row'>Last 7 Days</th>
                                              <td>{$numberStudentMessagesWeekly}</td>
                                              <td>{$numberStudentCommentsWeekly}</td>
                                              
                                            </tr>
                                            <tr>
                                              <th scope='row'>Last 30 Days</th>
                                              <td>{$numberStudentMessagesMonthly}</td>
                                              <td>{$numberStudentCommentsMonthly}</td>
                                              
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