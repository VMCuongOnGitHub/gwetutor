<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        if ($_SESSION['user_role'] == 'staff') {
            $_SESSION['msg'] = "Unauthorized Access";
            header('location: login.php');
        }
        header('location: login.php');
    }



    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: login.php");
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/staffDashboard.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
  <script src="https://kit.fontawesome.com/96bd6ee534.js" crossorigin="anonymous"></script>
  <title>Document</title>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
        <div class="left-action col-sm-2">
            <p>MENU</p>
            <div class="left-action-content">
                <a href="staffDashboard.php">Staff Dashboard</a>
            </div>
            <div class="left-action-content">
                <a href="tutorList.php">Tutor List</a>

            </div>
            <div class="left-action-content">
                <a href="studentList.php.php">Student List</a>
            </div>
        </div>

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
              <div class="with-tutor d-flex flex-column">
                <span>238(75%)</span>
                <span>with Tutor</span>
              </div>
              <div class="with-tutor d-flex flex-column">
                <span>238(75%)</span>
                <span>with Tutor</span>
              </div>
              <div class="with-tutor d-flex flex-column">
                <span>238(75%)</span>
                <span>with Tutor</span>
              </div>
            </div>
          </div>
          <div class="pie-student">
            <span id="title">Number of Tutors</span>
            <canvas id="my-student-pie-chart"></canvas>
            <div class="result-tutor d-flex justify-content-around">
              <div class="with-tutor d-flex flex-column">
                <span>238(75%)</span>
                <span>with Student</span>
              </div>
              <div class="with-tutor d-flex flex-column">
                <span>Total</span>
                <span>238</span>
              </div>
              <div class="with-tutor d-flex flex-column">
                <span>238(75%)</span>
                <span>without Student</span>
              </div>
          </div>
        </div>
        <div class="summary">
          <div class="summary-active d-flex">
            <div class="total-left-result">
              <div class="total-meeting total d-flex justify-content-around">
                <span id="words">Number of Meeting</span>
                <span id="number">256</span>
              </div>
              <div class="total-meeting total d-flex justify-content-around">
                <span id="words">Number of Meeting</span>
                <span id="number">256</span>
              </div>
              <div class="total-meeting total d-flex justify-content-around">
                <span id="words">Number of Meeting</span>
                <span id="number">256</span>
              </div>
            </div>
            <div class="total-right-result d-flex flex-column">
              <div class="total-blogs d-flex flex-column">
                <span id="blogs">Number of Blogs</span>
                <span id="number-blogs">186</span>
              </div>
              <div class="total-meeting total d-flex justify-content-around">
                <span id="words">Number of Meeting</span>
                <span id="number">256</span>
              </div>
            </div>
          </div>
          <div class="summary-inactive d-flex">
              <div class="inactive-student d-flex justify-content-around">
                <span id="inactive">Inactive Students</span>
                <div class="result-inactive">
                  <span>44/276</span>
                  <span>13%</span>
                </div>
              </div>
              <div class="inactive-student d-flex justify-content-around">
                <span id="inactive">Inactive Tutor</span>
                <div class="result-inactive">
                  <span>44/276</span>
                  <span>13%</span>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script>
  let ctx = document.getElementById("myChart4").getContext('2d');
  ctx.canvas.parentNode.style.height = '50vh';
  ctx.canvas.parentNode.style.width = '79rem';
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["09/04/2020","10/04/2020","11/04/2020","12/04/2020","13/04/2020","14/04/2020","15/04/2020","16/04/2020","17/04/2020"],
        datasets: [{
            label: 'Student Message',
            backgroundColor: "#caf270",
            data: [12, 59, 5, 56, 58,12, 59, 87, 45],
        }, {
            label: 'Tutor Message',
            backgroundColor: "#45c490",
            data: [12, 59, 5, 56, 58,12, 59, 85, 23],
        }, {
            label: 'Active Student',
            backgroundColor: "#008d93",
            data: [12, 59, 5, 56, 58,12, 59, 65, 51],
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
        data: [2478,5267]
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
        data: [1000,5267]
      }]
    },
});
  </script>
</body>
</html>
