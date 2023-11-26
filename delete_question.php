<?php require_once 'includes/header.php';?>
<?php require_once 'includes/login-check.php';?>
<?php require_once 'includes/qID-check.php';?>

<?php

require_once('includes/dbh.php');
$errMsg = '';

$sql_com = "DELETE FROM comment WHERE q_id=".$_GET["qID"];
if (mysqli_query($db, $sql_com)) {
    $sql_ans = "DELETE FROM answer WHERE q_id=".$_GET["qID"];
    if (mysqli_query($db, $sql_ans)) {
        $sql = "DELETE FROM question WHERE qID=".$_GET["qID"];
    } else {
        $errMsg = "<h3 class='p-3 text-bg-danger'>Error deleting record: " . mysqli_error($db)."</h3>";
    }

} else {
    $errMsg = "<h3 class='p-3 text-bg-danger'>Error deleting record: " . mysqli_error($db)."</h3>";
}
?>

    <main id="main">
        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact pt-1">
            <div class="container" >
                <div class="section-title mt-5">
                    <h2>Delete a Question</h2>
                </div>
                <div class="row">
                    <div class="col-lg-12 mt-2 mt-lg-0 text-center">
                        <?php

                                if (mysqli_query($db, $sql)) {
                                  // echo "Record deleted successfully";
                                  echo "<h3 class='p-3 text-center text-bg-success'>Question deleted successfully</h3>";


                                } else {
                                  // echo "Error deleting record: " . mysqli_error($db);
                                  $errMsg = "<h3 class='p-3 text-center text-bg-danger'>Error deleting question: " . mysqli_error($db)."</h3>";

                                }
    if($errMsg != '') echo $errMsg;
  echo '<a class="btn btn-primary mt-3 mb-3" href="javascript:history.go(-1)">Go to previous page</a>';

                         ?>

                    </div>
                </div>
            </div>
        </section><!-- End Contact Section -->
    </main><!-- End #main -->
    <?php mysqli_close($db); ?>
<?php require_once 'includes/footer.php';?>