
    <?php
    function uploadFile1($imageToUpload, $imageID){
        $target_dir = "images/";
        $target_file = $target_dir . $imageID;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $check = getimagesize($_FILES[$imageToUpload]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES[$imageToUpload]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES[$imageToUpload]["tmp_name"], $target_file)) {
                echo "";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    function randomPassword1() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 12; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
    $db = mysqli_connect('localhost', 'root', '', 'etutor');

    $commentID = 'cmt' . randomPassword1();
    $comment_content = mysqli_real_escape_string($db, $_POST['comment-content']);
    $time_created_comment = $_POST['time_created_comment'];
    $postIDComment = $_POST['postID_comment'];
    $userIDComment = $_POST['userID_comment'];


    $queryInsertComment = "INSERT INTO comments";
    $queryInsertComment .= " VALUES ('{$commentID}', '{$userIDComment}', '{$postIDComment}', '{$comment_content}', '{$time_created_comment}')";

    mysqli_query($db, $queryInsertComment);

//    if (isset($_FILES['imageToUpload'])){
//
//        $imageID = 'image' . randomPassword1();
//        $image_name = randomPassword1() . '-' . basename($_FILES["imageToUpload"]["name"]);
//        uploadFile1("imageToUpload", $image_name);
//
//        $queryImage = "INSERT INTO images (imageID, image_name, commentID, postID)";
//        $queryImage .= " VALUES ('{$imageID}', '{$image_name}', '{$commentID}', '{$postIDComment}')";
//
//        mysqli_query($db, $queryImage);
//    }

    ?>

    <?php
    $querySelectFromComment = "SELECT * FROM comments INNER JOIN users ON comments.userID = users.userID  WHERE postID = '{$postIDComment}' ORDER BY time_created ASC ";
    $resultsSelectFromComment = mysqli_query($db, $querySelectFromComment);
    $numberOfComment = mysqli_num_rows($resultsSelectFromComment);

    while($rowSelectFromComment = mysqli_fetch_assoc($resultsSelectFromComment)) {
        $querySelectImageFromComment = "SELECT * FROM images WHERE commentID = '{$rowSelectFromComment['commentID']}' AND postID = '{$postIDComment}' ";
        $resultsSelectImageFromComment = mysqli_query($db, $querySelectImageFromComment);
        $numberOfImageComment = mysqli_num_rows($resultsSelectImageFromComment);


        echo "
                <hr>
                <div class='row'>
                    <div class='col-md-2 text-center'>
                    </div>
                    <div class='col-md-10'>
                        <h4>{$rowSelectFromComment['username']}</h4>";
                        if ($numberOfImageComment > 0) {
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
    ?>



