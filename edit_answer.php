<?php require_once 'includes/header.php';?>
<?php require_once 'includes/login-check.php';?>
<?php
if ((!isset($_GET["ans_id"]) || $_GET["ans_id"] == '')) {
    header("Location:index.php");
    exit;
}
?>

<?php

require_once('includes/dbh.php');

if (isset($_POST["ans_desc"])) {

    if(!mysqli_select_db($db, "codetogether_db"))
    die("couldnt open db");
    $ans_desc = $_POST["ans_desc"];

    $sql = "UPDATE answer SET textt='".$ans_desc."' WHERE id=".$_GET["ans_id"];
    // echo '<pre>'; print_r($sql); echo '</pre>';

    if (mysqli_query($db, $sql)) {
      echo "<h3 class='p-3 text-center text-bg-success'>Answer updated successfully</h3>";
        $sqlSEL = "SELECT * FROM answer WHERE id=".$_GET["ans_id"];
        $resultSEL = mysqli_query($db, $sqlSEL);
    } else {
      echo "<h3 class='p-3 text-center text-bg-danger'>Error updating answer: " . mysqli_error($db)."</h3>";
    }

} else {
    $sqlSEL = "SELECT * FROM answer WHERE id=".$_GET["ans_id"];
    $resultSEL = mysqli_query($db, $sqlSEL);
    // mysqli_close($db);
}
mysqli_close($db);
?>

    <main id="main">
        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact pt-1">
            <div class="container" >
                <div class="section-title mt-5">
                    <h2>Edit an Answer</h2>
                </div>
                <div class="row">
                    <div class="col-lg-12 mt-2 mt-lg-0">
                        <?php
                        if (mysqli_num_rows($resultSEL) > 0) {
                          // output data of each row
                          while($row = mysqli_fetch_assoc($resultSEL)) {
                            // echo '<pre>'; print_r($row); echo '</pre>';
                            ?>
                            <form action="" method="post" role="form" class="php-email-form mw-700">
                                    <div class="form-group col-12">
                                        <label for="ans_desc" class="form-label">Answer Description</label>
                                        <textarea class="form-control" rows="5" placeholder="Answer Description" name="ans_desc" id="ans_desc"><?php echo $row['textt'] ?></textarea>
                                    </div>
                                    <div class="text-center col-12"><button type="submit">Update Answer</button></div>
                                </div>
                            </form>
                            <?php
                            // echo "<br> id: ". $row["id"]. " - Name: ". $row["firstname"]. " " . $row["lastname"] . "<br>";
                          }
                        } else {
                          echo "No Answer found";
                        }

                        ?>

                    </div>
                </div>
            </div>
        </section><!-- End Contact Section -->
    </main><!-- End #main -->
<?php require_once 'includes/footer.php';?>