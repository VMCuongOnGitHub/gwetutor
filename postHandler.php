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
?>


<?php

    if (isset($_POST['post-content'])) {
        $postID = 'post' . randomPassword();
        $post_content = mysqli_real_escape_string($db, $_POST['post-content']);
        $time_created = $_POST['time_created'];
        $userID = $_POST['userID'];

        $query = "INSERT INTO posts";
        $query .= " VALUES ('{$postID}', '{$userID}', '{$post_content}', '{$time_created}')";

        mysqli_query($db, $query);

        if (!empty($_FILES['file'])){
            $imageID = 'image' . randomPassword();
            $image_name = randomPassword() . '-' . basename($_FILES["imageToUpload"]["name"]);
            uploadFile("imageToUpload", $image_name);

            $queryImage = "INSERT INTO images (imageID, image_name, postID)";
            $queryImage .= " VALUES ('{$imageID}', '{$image_name}', '{$postID}')";


            mysqli_query($db, $queryImage);
        }
    }


?>



<?php
    if (isset($_SESSION['studentID'])){
        $userID = $_SESSION['studentID'];
    }else{
        $userID = $_SESSION['userID'];
    }
    $query = "SELECT * FROM posts WHERE userID = '{$userID}' ORDER BY time_created";

    $results = mysqli_query($db, $query);
    $numberOfPosts = mysqli_num_rows($results);

    if ($numberOfPosts > 0){
        while($row = mysqli_fetch_assoc($results)) {
            $querySelectImageFromPost = "SELECT * FROM images WHERE postID = '{$row['postID']}'";
            $resultsSelectImageFromPost = mysqli_query($db, $querySelectImageFromPost);
            $numberOfImagePost = mysqli_num_rows($resultsSelectImageFromPost);



            echo "
                <div class='container-fluid' style='background-color: #1d68a7; margin-top: 10px; padding: 20px 10px 20px 10px'>
                    <div class='row'>
                        <div class='col-sm-12'>";

            if ($numberOfImagePost > 0){
                $rowSelectImageFromPost = mysqli_fetch_assoc($resultsSelectImageFromPost);
                $image_name = $rowSelectImageFromPost['image_name'];
                echo "
                    <div class='image-post text-center'>
                        <img src='images/{$image_name}' class='img-fluid' alt='Responsive image'>
                    </div>";
            }

            echo "
                                <div class='content-post' style='margin-top: 10px'>
                                    <p>{$row['content_post']}</p>
                                    <p>{$row['time_created']}</p>
                                </div>
                            </div>
                        </div>";

            echo "<div class='comment-wrapper_{$row['postID']}'>";
            $querySelectFromComment = "SELECT * FROM comments INNER JOIN users ON comments.userID = users.userID  WHERE postID = '{$row['postID']}'";
            $resultsSelectFromComment = mysqli_query($db, $querySelectFromComment);
            $numberOfComment = mysqli_num_rows($resultsSelectFromComment);

            while($rowSelectFromComment = mysqli_fetch_assoc($resultsSelectFromComment)) {
                $querySelectImageFromComment = "SELECT * FROM images WHERE commentID = '{$rowSelectFromComment['commentID']}' AND postID = '{$row['postID']}'";
                $resultsSelectImageFromComment = mysqli_query($db, $querySelectImageFromComment);
                $numberOfImageComment = mysqli_num_rows($resultsSelectImageFromComment);



                echo "
                
                <hr>
                <div class='row'>
                    <div class='col-md-2 text-center'>
                        <div style='background-color: #3f9ae5; height: 100px; width: 100px; margin-left: auto'>
                        </div>
                    </div>
                    <div class='col-md-10'>
                        <h1>{$rowSelectFromComment['username']}</h1>";
                        if ($numberOfImageComment > 0){
                            $rowSelectImageFromComment = mysqli_fetch_assoc($resultsSelectImageFromComment);
                            $image_name_comment = $rowSelectImageFromComment['image_name'];
                            echo "<div class='image-post text-center'>
                            <img src='images/{$image_name_comment}' class='img-fluid' alt='Responsive image'>
                        </div>";
                        }


                echo "
                            <p>{$rowSelectFromComment['content_comment']}</p>
                            <p>{$rowSelectFromComment['time_created']}</p>
                            <div style='background-color: #1b1e21; height: 1px; width: 100%'></div>
                        </div>
                    </div>
                ";
            }
            echo "</div>";

            $time_created_comment = date('Y-m-d H:i:s');
            echo "
                <hr>
                 <div class='row'>
                    <form id='post_submit_comment_{$row['postID']}' action='commentHandle.php' method='post' enctype='multipart/form-data'>
                        <div class='col-sm-10'>
                            <div class='form-group' style='margin-top: 10px'>
                                <input type='hidden' value='{$row['postID']}' name='postID_comment'>
                                <input type='hidden' value='{$_SESSION['userID']}' name='userID_comment'>
                                <input type='hidden' value='{$time_created_comment}' name='time_created_comment'>
                                <input class='form-control' id='comment-post' placeholder='Comment here' name='comment-content'>
                                <input class='form-control' type='file' name='imageToUpload' class='file-comment'>
                            </div>
                        </div>
                        <div class='col-sm-2'>
                            <button type='submit' class='btn btn-primary' name='post_submit_comment'>Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            ";

            echo "
                <script type='text/javascript'>
                 $(document).ready(function () {
                    $('#post_submit_comment_{$row['postID']}').on('submit',(function(e) {
                       
                        let file_data1 = $('input[name=\"imageToUpload\"]').prop('files')[0];
                        let formData1 = new FormData(this);
                        formData1.append('file', file_data1);
                        
                        e.preventDefault();
                        $.ajax({
                            url: 'commentHandle.php',
                            type: 'POST',
                            data:  formData1,
                            enctype: 'multipart/form-data',
                            contentType: false,
                            cache: false,
                            processData:false,
                            dataType: 'text',
                            success: function(data){
                                $('.comment-wrapper_{$row['postID']}').html(data);
                            }, error: function() {
                                $('.comment-wrapper_{$row['postID']}').html('<p></p>');
                            }
                        });
                    }));
                 });
                </script>
            ";
        }
    }

?>


