<?php
if (!isset($_POST) || empty($_POST)) {
    header("Location: index.php");
    exit;
} else {
    session_start();
    require_once('includes/dbh.php');

    $ans_id = $_POST['cur_ans_id'];
    $cur_avg_rating = $_POST['cur_avg_rating'];
    $cur_star_rating = $_POST['cur_star_rating'];

    // Calculate the new average rating based on the current average and the new star rating
    $new_avg_rating = ($cur_avg_rating + $cur_star_rating) / 2;

    // Round the new average rating to one decimal place
    $new_avg_rating = number_format($new_avg_rating, 1);

    $sql = "UPDATE answer SET avg_rating='" . $new_avg_rating . "' WHERE id=" . $ans_id;

    if (mysqli_query($db, $sql)) {
        echo "success";
        $_SESSION["d_message"] = "Rating added successfully!!!";
    } else {
        echo "error";
        $_SESSION["d_message"] = "Error while Rating!!!";
    }

    mysqli_close($db);
    header("Location:" . $_POST['page_name']);
}
?>
