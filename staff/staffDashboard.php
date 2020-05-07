<?php include('header_staff.php') ?>

<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h2>Staff</h2>
                 </div>
            </nav>
        </div>
        <div class="list-group list-group-flush">
            <a class='list-group-item list-group-item-action bg-light' href="staffDashboard.php"><i class="fas fa-home"> </i>Dashboard</a>
            <a class='list-group-item list-group-item-action bg-light' href="tutorList.php"><i class="fas fa-user"> </i>Tutor List</a>
            <a class='list-group-item list-group-item-action bg-light' href="studentList.php"><i class="fas fa-address-card"> </i>Student List</a>
            <a class='list-group-item list-group-item-action bg-light' href="unassignedUser.php"><i class="fas fa-project-diagram"> </i>Unassigned User</a>
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
                        <a href="../index.php?logout='1'" class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-md-12" style="height:450px">
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

                </div>
            </div>
        </div>

        <div class="container" style="margin-top: 100px">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 col-sm-12" style="margin-bottom: 20px">
                    <div class="card" style="height:350px; width:100%">
                        <div class="card-body">
                            <h2 class="card-title">Tutors</h2>
                            <canvas id="my-student-pie-chart"></canvas>
                            <div class="result-tutor d-flex justify-content-around">
                                <?php
                                $querySelectTutorWithStudents = "SELECT DISTINCT tutorID FROM students";
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
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12" style="margin-bottom: 20px">
                    <div class="card card-block" style="height:350px; width:100%">
                        <div class="card-body">
                            <h2 class="card-title">Active Students in 7 days</h2>
                            <canvas id="my-tutor-pie-chart"></canvas>
                            <div class="result-tutor d-flex justify-content-around">
                                <?php
                                $querySelectStudentMessages = "SELECT DISTINCT from_userID FROM messages WHERE DATEDIFF(NOW(), time_created) <= 7";
                                $resultsSelectStudentMessages = mysqli_query($db, $querySelectStudentMessages);

                                $numberOfActiveStudent = 0;
                                while ($row = mysqli_fetch_assoc($resultsSelectStudentMessages)){
                                    $querySelectActiveStudent = "SELECT * FROM students WHERE userID = '{$row['from_userID']}'";
                                    $resultSelectActiveStudent = mysqli_query($db, $querySelectActiveStudent);
                                    $numberOfAllStudent = mysqli_num_rows($resultSelectActiveStudent);
                                    if ($numberOfAllStudent > 0){
                                        $numberOfActiveStudent++;
                                        break;
                                    }
                                }
                                $querySelectAllStudent = "SELECT * FROM students WHERE 1=1";
                                $resultSelectAllStudent = mysqli_query($db, $querySelectAllStudent);
                                $numberOfAllStudents = mysqli_num_rows($resultSelectAllStudent);

                                $numberOfInactiveStudent = $numberOfAllStudents - $numberOfActiveStudent;

                                echo "
                                        <div class='with-tutor d-flex flex-column'>
                                            <span>{$numberOfActiveStudent}</span>
                                            <span>Active Students</span>
                                        </div>
                                        <div class='with-tutor d-flex flex-column'>
                                            <span>{$numberOfAllStudents}</span>
                                            <span>Total Students</span>
                                        </div>
                                        <div class='with-tutor d-flex flex-column'>
                                            <span>{$numberOfInactiveStudent}</span>
                                            <span>Inactive Students</span>
                                        </div>
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
</div>
<!-- /#wrapper -->


<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>


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
                            echo "\"12\",\"31\",\"42\",\"41\",\"32\",\"17\",\"43\"";
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
                            echo "\"27\",\"35\",\"47\",\"27\",\"34\",\"12\",\"13\"";
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
                            echo "\"34\",\"27\",\"37\",\"18\",\"27\",\"35\",\"29\"";
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
                        echo "\"24\",\"27\",\"36\",\"27\",\"47\",\"22\",\"36\"";
                        ?>],
                }],
            },
            options: {
                title:{
                    display:true,
                    text:'Activities',
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
                    data: [<?php echo "16"?>, <?php echo "1"?>]
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
