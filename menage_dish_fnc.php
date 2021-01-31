<?php

if(isset($_POST['edited'])){
    $id = $_POST['id'];
    $edited = $_POST['edited'];
    $mode = $_POST['mode'];

    require_once "dbConfig.php";

    mysqli_report(MYSQLI_REPORT_STRICT);
    try{

        if($db->connect_errno != 0){
            throw new Exception(mysqli_connect_errno());
        }
        else{
            $sql_query = "";
            // zależnie od mode dodaje
            switch ($mode) {
                case 'add':
                    $sql_query = "INSERT INTO dania VALUES(NULL, '$edited');";
                    break;
                case 'modify':
                    $sql_query = "UPDATE dania SET title='$edited' WHERE id='$id';";
                    break;
                case 'delete':
                    $sql_query = "DELETE FROM dania WHERE id='$id';";
                    break;
            }
            if($db->query($sql_query)){
                echo 'correct';
            }
            else{
                throw new Exception($db->error);
            }
        }

    }
    catch(Exception $exc){
        echo $exc;
    }
}
// if(isset($_POST['show'])){

// }

?>