<?php
    if ((!isset($_POST) || empty($_POST))) {
        header("Location:index.php");
        exit;
    } else {
        session_start();
        require_once('includes/dbh.php');

        $q_id = $_POST['qID'];
        $textt = $_POST['reply'];
        $posted_by = $_SESSION['username'];
        $qry = "INSERT INTO answer (q_id, textt, posted_by) VALUES ('$q_id','$textt','$posted_by')";
        if((mysqli_query($db, $qry))){
            echo "success";
            $_SESSION["d_message"] = "Reply added successfully!!!";
        } else {
            echo "error";
            $_SESSION["d_message"] = "Error while Replying!!!";
        }
        header("Location:".$_POST['page_name']) ;
    }
?>