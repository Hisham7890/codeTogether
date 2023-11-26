<?php
    if ((!isset($_POST) || empty($_POST))) {
        header("Location:index.php");
        exit;
    } else {
        session_start();
        require_once('includes/dbh.php');

        $q_id = $_POST['qID'];
        $ans_id = $_POST['ans_id'];
        $comment = $_POST['comment'];
        $posted_by = $_SESSION['username'];
        $qry = "INSERT INTO comment (com_text, a_id, q_id, posted_by) VALUES ('$comment','$ans_id','$q_id','$posted_by')";
        if((mysqli_query($db, $qry))){
            echo "success";
            $_SESSION["d_message"] = "Comment added successfully!!!";
        } else {
            echo "error";
            $_SESSION["d_message"] = "Error while Commenting!!!";
        }
        header("Location:".$_POST['page_name']) ;
    }
?>