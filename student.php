<?php
    if(!isset($_SESSION))
    {
        session_start();
    }

    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
        if ($_SESSION['user_role'] != 'student' || $_SESSION['user_role'] != 'tutor') {
            $_SESSION['msg'] = "Unauthorized Access";
            header('location: login.php');
        }
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: login.php");
    }

//    if (isset($_GET['id'])){
//        $userID= $_GET['id'];
//        $_SESSION['studentID'] = $_GET['id'];
//    }else{
//        $userID= $_SESSION['userID'];
//    }



?>

<?php include('header.php') ?>

<?php


    $senderID = $_SESSION['userID'];
    if (isset($_GET['id'])){
        $receiverID = $_GET['id'];
        $_SESSION['studentID'] = $_GET['id'];
    }else{

        $querySelectTutorStudent = "SELECT * FROM students WHERE userID = '{$_SESSION['userID']}'";
        $resultsSelectTutorStudent = mysqli_query($db, $querySelectTutorStudent);
        $rowSelectTutorStudent = mysqli_fetch_assoc($resultsSelectTutorStudent);

        $tutorIDForStudent = $rowSelectTutorStudent['tutorID'];
        $receiverID = substr($tutorIDForStudent, 5);
    }

?>

<a id="toggle-button-chat" style="z-index: 1000"><img src="images/chaticon.png" id="fixedbutton"></a>

<div class="chat-window" id="chat_window_1" style="position:fixed;right:-5px;bottom:10px;z-index: 1000000" >
    <div class="panel panel-default">
        <div class="panel-heading top-bar">
                <h3 class="float-left">Chat</h3>
                <h6 id="close-chat" class="float-right" style="margin-top: 15px">Close</h6>
        </div>
        <div class='panel-body msg_container_base' style= 'height:500px;' id="scroll-messages">
            <div id="chat-window-wrapper"></div>
        </div>

        <div class="panel-footer">
            <div id="div-form">
                <form id="message_post" action="messageHandler.php" method="post" style="margin-top: 10px">
                    <div class="form-row">
                        <div class="col-8">
                            <input type="text" name="message-context" id="message-context" class="form-control">
                        </div>
                        <div class="col-4">
                            <input type="submit" name="message_post" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="wrapper">
    <!-- Sidebar Holder -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>Student</h3>
            <p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
        </div>
    </nav>
    <!-- Page Content Holder -->
    <div id="content">


        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="w3-button w3-teal w3-xlarge w3-right" onclick="openRightMenu()">&#9776;</button>

            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="navbar-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>
            </div>
        </nav>

        <div class="container-fluid"  style="background-color: #1b4b72; padding: 30px 20px 30px 20px">

            <?php
                if(isset($_GET['id']) == false){
                    $dateToday = date('Y-m-d H:i:s');
                    echo "
                    <ul class='nav nav-tabs' role='tablist'>
                        <li class='nav-item'>
                            <a class='nav-link active' data-toggle='tab' href='#post-form'>Post</a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' data-toggle='tab' href='#schedule-form'>Schedule</a>
                        </li>
                    </ul>
                    <div class='tab-content'>
                        <div id='post-form' class='tab-pane fade show active'><br>
                            <form id='post_submit' action='postHandler.php' method='post' enctype='multipart/form-data'>
                                <input type='hidden' value='{$senderID}' name='userID'>
                                <input type='hidden' value='{$dateToday}' name='time_created'>
                                <div class='form-group' style='margin-top: 10px'>
                                    <label for='comment'>Post Content</label>
                                    <textarea class='form-control' rows='5' id='comment' name='post-content' required></textarea>
                                    <label for='imageToUpload'>Image</label>
                                    <input class='form-control' type='file' name='imageToUpload' id='file'>
                                </div>
                                <button type='submit' name='post_submit' class='btn btn-primary'>Submit</button>
                            </form>
                        </div>
        
                        <div id='schedule-form' class='tab-pane fade'><br>
                            <form id='schedule_submit' action='scheduleHandler.php' method='post' enctype='multipart/form-data'>
                                <input type='hidden' value='{$senderID}' name='userID'>
                                <input type='hidden' value='{$dateToday}' name='time_created'>
                                <div class='form-row'>
                                    <div class='col-md-8'>
                                        <label>Setup Schedule</label>
                                        <input class='form-control' type='datetime-local' value='2020-04-20T13:45:00' id='example-datetime-local-input' name='time-schedule' required>
                                        <label for='description-schedule'>Description</label>
                                        <textarea class='form-control' id='description-schedule' name='description-schedule' required></textarea>
                                        <button type='submit' class='btn btn-primary' name='schedule_submit'>Submit</button>
                                    </div>
                                    <div class='col-md-4'>
                                        <label for='title-schedule'>Related Document</label>
                                        <input class='form-control' type='file'>
                                        <ul>
                                            <li>1</li>
                                            <li>2</li>
                                            <li>3</li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    ";
                }
            ?>
            
            
            
        </div>


        <div id="schedule-wrapper"></div>
        <div id="posts-wrapper"></div>
    </div>


</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#chat_window_1').hide();

        $("#toggle-button-chat").click(function() {
            $('#chat_window_1').toggle({
                duration: 300,
            });
        });
        $("#close-chat").click(function () {
            $('#chat_window_1').hide();
        });


        // $('#sidebarCollapse').on('click', function () {
        //     $('#sidebar').toggleClass('active');
        //     $(this).toggleClass('active');
        // });
        // $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});

        function runajax(){
            let datapost = {"receiverID" : "<?php echo $receiverID?>", "senderID" : "<?php echo $senderID?>"};
            console.log(datapost);
            $.ajax({
                url: "postHandler.php",
                type: "POST",
                data:  new FormData(),
                contentType: false,
                cache: true,
                processData:false,
                success: function(data){
                    $("#posts-wrapper").html(data);
                }, error: function() {
                    $("#posts-wrapper").html("<p></p>");
                }
            });

            $.ajax({
                url: "scheduleHandler.php",
                type: "POST",
                data:  new FormData(),
                contentType: false,
                cache: true,
                processData:false,
                success: function(data){
                    $("#schedule-wrapper").html(data);
                }, error: function() {
                    $("#schedule-wrapper").html("<p></p>");
                }
            });

            $.ajax({
                url: "messageHandler.php",
                type: "POST",
                data: datapost,
                success: function(data){
                    $("#chat-window-wrapper").html(data);
                }, error: function() {
                    $("#chat-window-wrapper").html("<p>error</p>");
                }
            });
        }

        runajax();

        setInterval(function(){
            runajax();
        }, 5000);

        $("#schedule_submit").on('submit',(function(e) {
            e.preventDefault();
            $.ajax({
                url: "scheduleHandler.php",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: true,
                processData:false,
                success: function(data){
                    $("#schedule-wrapper").html(data);
                }, error: function() {
                    $("#schedule-wrapper").html("<p>error</p>");
                }
            });
        }));


        $("#post_submit").on('submit',(function(e) {
            let file_data = $('#file').prop('files')[0];
            let formData = new FormData(this);
            formData.append('file', file_data);

            e.preventDefault();
            $.ajax({
                url: "postHandler.php",
                type: "POST",
                data:  formData,
                enctype: 'multipart/form-data',
                contentType: false,
                cache: false,
                processData:false,
                async: false,
                dataType: 'text',
                success: function(data){
                    $("#posts-wrapper").html(data);
                }, error: function() {
                    $("#posts-wrapper").html("<p></p>");
                }
            });
        }));

        function scrollBottom(){
            $('#scroll-messages').stop().animate({
                scrollTop: $('#scroll-messages')[0].scrollHeight * $('#scroll-messages')[0].scrollHeight
            }, 300);
        }
        scrollBottom();

        $("#message_post").on('submit',(function(e) {
            let inputVal = document.getElementById("message-context").value;
            let datapost = {"receiverID" : "<?php echo $receiverID?>", "senderID" : "<?php echo $senderID?>", "message-context" : inputVal};
            e.preventDefault();
            $.ajax({
                url: "messageHandler.php",
                type: "POST",
                data: datapost,
                success: function(data){
                    console.log(data);
                    $("#chat-window-wrapper").html(data);
                }, error: function() {
                    $("#chat-window-wrapper").html("<p>error</p>");
                }
            });
            scrollBottom();
            document.getElementById("message-context").value = '';
        }));
    });
</script>
<script>
    function openRightMenu() {
        document.getElementById("rightMenu1").style.display = "block";
    }

    function closeRightMenu() {
        document.getElementById("rightMenu1").style.display = "none";
    }

</script>




<?php include('footer.php') ?>
