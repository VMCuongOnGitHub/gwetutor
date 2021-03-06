
<?php
    $db = mysqli_connect('localhost', 'root', '', 'etutor');
    if (isset($_FILES["fileToUpload"]["name"])){
        $target_dir = "file/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 50000000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $link = "file/" . basename( $_FILES["fileToUpload"]["name"]);
                $filename = basename( $_FILES["fileToUpload"]["name"]);
                $scheduleID = $_POST['scheduleID'];
                $time_created = $_POST['time_created'];

                $queryInsertFile = "INSERT INTO relateddocuments (scheduleID, name_related_document, url_related_document, time_created) VALUES ('{$scheduleID}','{$filename}','{$link}','{$time_created}')";
                mysqli_query($db, $queryInsertFile);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

?>

<?php
    $querySelectFile = "SELECT * FROM relateddocuments WHERE scheduleID = '{$_POST['scheduleID']}'";
    $resultSelectFile = mysqli_query($db, $querySelectFile);
    echo "<script src=https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js></script>";
    while($row = mysqli_fetch_assoc($resultSelectFile)){
        echo "<li><div id='{$row['related_document_ID']}'>X</div> <a href='{$row['url_related_document']}'>{$row['name_related_document']}</a></li>";
        echo "
            <script>
                $('#{$row['related_document_ID']}').click(function(e) {
                    e.preventDefault();
                    let datapost1 = {'related_document_ID' : '{$row['related_document_ID']}', 'scheduleID' : '{$row['scheduleID']}'};
                    $.ajax({
                        url: 'deleteDocumentHandler.php',
                        type: 'POST',
                        data: datapost1,
                        success: function(data){
                            $('#file-list_{$row['scheduleID']}').html(data);
                        }, error: function() {
                            $('#file-list_{$row['scheduleID']}').html('<p></p>');
                        }
                    });
                });
            </script>
        ";
    }
?>
