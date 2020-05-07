<?php include('server.php') ?>

<?php
    if(!isset($_SESSION))
    {
        session_start();
    }

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

    $receiverID = $_POST['receiverID'];
    $senderID = $_POST['senderID'];
?>

<?php
    if (isset($_POST['message-context'])) {
        $time_created = date('Y/m/d - H:i:s');
        $message_context = mysqli_real_escape_string($db, $_POST['message-context']);

        $queryInsertMessage = "INSERT INTO messages(from_userID, to_userID, content_message, time_created)";
        $queryInsertMessage .= " VALUES ('{$senderID}', '{$receiverID}', '{$message_context}', '{$time_created}')";
        mysqli_query($db, $queryInsertMessage);
    }
?>

<?php
        $querySelectMessage = "
             SELECT * FROM messages 
             WHERE (from_userID = '{$senderID}' 
             AND to_userID = '{$receiverID}') 
             OR (from_userID = '{$receiverID}'
             AND to_userID = '{$senderID}') 
             ORDER BY time_created ASC
        ";
        $resultsSelectMessage = mysqli_query($db, $querySelectMessage);
        while($rowSelectMessage = mysqli_fetch_assoc($resultsSelectMessage)) {
            $querySelectSender = "SELECT * FROM users INNER JOIN messages ON users.userID = messages.from_userID WHERE userID = '{$rowSelectMessage['from_userID']}'";
            $resultsSelectSender = mysqli_query($db, $querySelectSender);
            $rowSelectSender = mysqli_fetch_assoc($resultsSelectSender);

            $tutorMessageColor = '';
            $textColor = '';
            if ($rowSelectSender['is_assigned_role'] == 'tutor'){
                $tutorMessageColor = 'background-color: rgb(103, 184, 104);';
                $textColor = 'color: white';
            }else{
                $tutorMessageColor = 'background-color: rgb(241, 240, 240);';
                $textColor = 'color: #3d3d3d';
            }

            echo "
                <div class='row msg_container base_sent' style=''>
                    <div class='messages msg_sent' style='word-wrap: break-word; {$tutorMessageColor}'>
                        <p style='{$textColor}'>{$rowSelectMessage['content_message']}</p>
                        <time datetime='2009-11-13T20:00:00'><strong style='{$textColor}'>{$rowSelectSender['email']}</strong> - {$rowSelectMessage['time_created']}</time>
                    </div>
                </div>
            ";
        }
?>










