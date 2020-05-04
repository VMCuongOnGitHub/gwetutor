<?php include('header_staff.php') ?>


<div class="container-fluid">
    <div class="row">
        <div class="wrapper">
            <div class="sidebar">
                <h2>MENU</h2>
                <ul>
                    <li><a href="staffDashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
                    <li><a href="tutorList.php"><i class="fas fa-user"></i>Tutor List</a></li>
                    <li><a href="studentList.php"><i class="fas fa-address-card"></i>Student List</a></li>
                    <li><a href="unassignedUser.php"><i class="fas fa-project-diagram"></i>Unassigned User</a></li>
                </ul>
            </div>
            <div class="main_content">
                <div class="right-action col-sm-10">
                    <div class="right-action-header">
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
                        <div class="banner-action row">
                            <div class="action-update action d-flex justify-content-around">
                                <i class="fa fa-pen-square"></i>
                                <span>Update</span>
                            </div>
                            <div class="action-export action d-flex justify-content-around">
                                <i class="fa fa-file-excel"></i>
                                <span>Export Report</span>
                            </div>
                        </div>
                    </div>

                    <div class="right-content-bar">
                        <canvas id="myChart4"></canvas>
                    </div>

                    <div class="right-content-summary d-flex justify-content-around">
                        <div class="pie-tutor">
                            <span id="title">Number of Students</span>
                            <canvas id="my-tutor-pie-chart"></canvas>
                            <div class="result-tutor d-flex justify-content-around">
                                <?php
                                    $querySelectStudent = "SELECT * FROM students WHERE tutorID != ''";
                                    $resultsSelectStudent = mysqli_query($db, $querySelectStudent);
                                    $numberOfStudentWithTutor = mysqli_num_rows($resultsSelectStudent);

                                    $querySelectAllStudent = "SELECT * FROM students WHERE 1=1";
                                    $resultsSelectAllStudent = mysqli_query($db, $querySelectStudent);
                                    $numberOfAllStudent = mysqli_num_rows($resultsSelectAllStudent);

                                    $numberOfStudentWithoutTutor = $numberOfAllStudent - $numberOfStudentWithTutor;
                                    echo "
                                    <div class='with-tutor d-flex flex-column'>
                                        <span>{$numberOfStudentWithTutor}</span>
                                        <span>with Tutor</span>
                                    </div>
                                    <div class='with-tutor d-flex flex-column'>
                                        <span>$numberOfAllStudent</span>
                                        <span>Total Student</span>
                                    </div>
                                    <div class='with-tutor d-flex flex-column'>
                                        <span>{$numberOfStudentWithoutTutor}</span>
                                        <span>without Tutor</span>
                                    </div>
                                    ";
                                ?>

                            </div>
                        </div>
                        <div class="pie-student">
                            <span id="title">Number of Tutors</span>
                            <canvas id="my-student-pie-chart"></canvas>
                            <div class="result-tutor d-flex justify-content-around">
                                <?php
                                $querySelectTutorWithStudents = "SELECT * FROM tutors WHERE total_assigned_student > 1";
                                $resultsSelectTutorWithStudents = mysqli_query($db, $querySelectTutorWithStudents);
                                $numberOfTutorWithStudent = mysqli_num_rows($resultsSelectTutorWithStudents);

                                $querySelectAllTutor = "SELECT * FROM tutors WHERE 1=1";
                                $resultSelectAllTutor = mysqli_query($db, $querySelectAllTutor);
                                $numberOfAllTutors = mysqli_num_rows($resultSelectAllTutor);

                                $numberOfTutorWithoutStudents = $numberOfAllTutors - $numberOfTutorWithStudent;
                                echo "
                                    <div class='with-tutor d-flex flex-column'>
                                        <span>{$numberOfTutorWithStudent}</span>
                                        <span>with Students</span>
                                    </div>
                                    <div class='with-tutor d-flex flex-column'>
                                        <span>{$numberOfAllTutors}</span>
                                        <span>Total Tutors</span>
                                    </div>
                                    <div class='with-tutor d-flex flex-column'>
                                        <span>{$numberOfTutorWithoutStudents}</span>
                                        <span>without Students</span>
                                    </div>
                                    ";
                                ?>
                                
                            </div>
                        </div>
                        <div class="summary">
                            <div class="summary-active d-flex">
                                <?php
                                    $querySelectAllPosts = "SELECT * FROM posts WHERE 1=1";
                                    $resultSelectAllPosts = mysqli_query($db, $querySelectAllPosts);
                                    $numberOfPosts = mysqli_num_rows($resultSelectAllPosts);

                                    $querySelectAllComments = "SELECT * FROM comments WHERE 1=1";
                                    $resultSelectAllComments = mysqli_query($db, $querySelectAllComments);
                                    $numberOfComments = mysqli_num_rows($resultSelectAllComments);

                                    $querySelectAllMessages = "SELECT * FROM messages WHERE 1=1";
                                    $resultSelectAllMessages = mysqli_query($db, $querySelectAllMessages);
                                    $numberOfMessages = mysqli_num_rows($resultSelectAllMessages);
                                    
                                    echo "
                                    <div class='total-left-result'>
                                        <div class='total-meeting total d-flex justify-content-around'>
                                            <span id='words'>Number of Meeting</span>
                                            <span id='number'>256</span>
                                        </div>
                                        <div class='total-meeting total d-flex justify-content-around'>
                                            <span id='words'>Number of Post</span>
                                            <span id='number'>{$numberOfPosts}</span>
                                        </div>
                                        <div class='total-meeting total d-flex justify-content-around'>
                                            <span id='words'>Number of Comment</span>
                                            <span id='number'>{$numberOfComments}</span>
                                        </div>
                                    </div>
                                    <div class='total-right-result d-flex flex-column'>
                                        <div class='total-blogs d-flex flex-column'>
                                            <span id='blogs'>Number of Messages</span>
                                            <span id='number-blogs'>{$numberOfMessages}</span>
                                        </div>
                                    </div>
                                    ";
                                ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div></div>
    <?php
    $arrayLatestSevenDays = array();
    for ($i = 6; $i >= 0; $i--){
        $stringDayAgo = '-' . $i . ' days';
        $lastWeek = date("Y/m/d", strtotime($stringDayAgo));
        array_push($arrayLatestSevenDays, $lastWeek);
    }


    ?>


    <script>
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
                    backgroundColor: "#caf270",
                    stack: "Stack 0",
                    data: [<?php
                            $dataStudentMessages = "";
                            foreach($arrayLatestSevenDays as $value){
                                $querySelectMessageEachDay = "SELECT * FROM students INNER JOIN messages ON students.userID = messages.from_userID WHERE time_created LIKE '$value%'";
                                $resultsSelectMessageEachDay = mysqli_query($db, $querySelectMessageEachDay);
                                $numberOfMessageEachDay = mysqli_num_rows($resultsSelectMessageEachDay);

                                $dataStudentMessages .= '"' . $numberOfMessageEachDay . '"' . ",";
                            }
                            $dataStudentMessages = rtrim($dataStudentMessages, ",");
                            echo $dataStudentMessages;
                        ?>],
                }, {
                    label: "Tutors' Messages",
                    backgroundColor: "#45c490",
                    stack: "Stack 0",
                    data: [<?php
                            $dataTutorMessages = "";
                            foreach($arrayLatestSevenDays as $value){
                                $querySelectMessageEachDay = "SELECT * FROM tutors INNER JOIN messages ON tutors.userID = messages.from_userID WHERE time_created LIKE '$value%'";
                                $resultsSelectMessageEachDay = mysqli_query($db, $querySelectMessageEachDay);
                                $numberOfMessageEachDay = mysqli_num_rows($resultsSelectMessageEachDay);

                                $dataTutorMessages .= '"' . $numberOfMessageEachDay . '"' . ",";
                            }
                            $dataTutorMessages = rtrim($dataTutorMessages, ",");
                            echo $dataTutorMessages;
                        ?>],
                }, {
                    label: "Student's Comments",
                    backgroundColor: "#008d53",
                    stack: "Stack 1",
                    data: [<?php
                            $dataStudentComments = "";
                            foreach($arrayLatestSevenDays as $value){
                                $dateConverter = str_replace("/","-",$value);
                                $querySelectCommentEachDay = "SELECT * FROM students INNER JOIN comments ON students.userID = comments.userID WHERE time_created LIKE '$dateConverter%'";
                                $resultsSelectCommentEachDay = mysqli_query($db, $querySelectCommentEachDay);
                                $numberOfCommentEachDay = mysqli_num_rows($resultsSelectCommentEachDay);

                                $dataStudentComments .= '"' . $numberOfCommentEachDay . '"' . ",";
                            }
                            $dataStudentComments = rtrim($dataStudentComments, ",");
                            echo $dataStudentComments;
                        ?>],
                }, {
                    label: "Tutors' Comments",
                    backgroundColor: "#008d93",
                    stack: "Stack 1",
                    data: [<?php
                        $dataTutorComments = "";
                        foreach($arrayLatestSevenDays as $value){
                            $dateConverter = str_replace("/","-",$value);
                            $querySelectMessageEachDay = "SELECT * FROM tutors INNER JOIN comments ON tutors.userID = comments.userID WHERE time_created LIKE '$dateConverter%'";
                            $resultsSelectMessageEachDay = mysqli_query($db, $querySelectMessageEachDay);
                            $numberOfMessageEachDay = mysqli_num_rows($resultsSelectMessageEachDay);

                            $dataTutorComments .= '"' . $numberOfMessageEachDay . '"' . ",";
                        }
                        $dataTutorComments = rtrim($dataTutorComments, ",");
                        echo $dataTutorComments;
                        ?>],
                }],
            },
            options: {
                title:{
                    display:true,
                    text:'Number of messages',
                    fontSize:25
                },
                tooltips: {
                    displayColors: true,
                    callbacks:{
                        mode: 'x',
                    },
                },
                scales: {
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            display: false,
                        }
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true,
                        },
                        type: 'linear',
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
                    data: [<?php echo $numberOfStudentWithoutTutor?>, <?php echo $numberOfStudentWithTutor?>]
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
                    data: [<?php echo $numberOfTutorWithStudent?>, <?php echo $numberOfTutorWithoutStudents?>]
                }]
            },
        });
    </script>
</body>
</html>
