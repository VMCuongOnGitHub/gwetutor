<?php
$db = mysqli_connect('localhost', 'root', '', 'etutor');

    if (isset($_POST['related_document_ID'])) {
        $documentID = $_POST['related_document_ID'];
        $query = "DELETE FROM relateddocuments";
        $query .= " WHERE related_document_ID = {$documentID}";
        mysqli_query($db, $query);
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
