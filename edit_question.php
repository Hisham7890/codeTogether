<?php require_once 'includes/header.php';?>
<?php require_once 'includes/login-check.php';?>
<?php require_once 'includes/qID-check.php';?>

<?php

require_once('includes/dbh.php');

// $result = $db->query($sql);
// echo '<pre>'; print_r($result); echo '</pre>';


if (isset($_POST["que_title"])) {

    if(!mysqli_select_db($db, "codetogether_db"))
    die("couldnt open db");

    $que_title = $_POST["que_title"];
    $que_desc = $_POST["que_desc"];

    $sql = "UPDATE question SET title='".$que_title."', describtion='".$que_desc."' WHERE qID=".$_GET["qID"];
    // echo '<pre>'; print_r($sql); echo '</pre>';

    if (mysqli_query($db, $sql)) {
      echo "<h3 class='p-3 text-center text-bg-success'>Question updated successfully</h3>";
      $sqlSEL = "SELECT * FROM question WHERE qID=".$_GET["qID"];
        $resultSEL = mysqli_query($db, $sqlSEL);
    } else {
      echo "<h3 class='p-3 text-center text-bg-danger'>Error updating question: " . mysqli_error($db)."</h3>";
    }
} else {
    $sqlSEL = "SELECT * FROM question WHERE qID=".$_GET["qID"];
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
                    <h2>Edit a Question</h2>
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
                                <div class="row gy-2 gx-md-3">
                                    <div class="form-group col-12">
                                        <label for="que_title" class="form-label">Question Title</label>
                                        <input type="text" class="form-control" name="que_title" id="que_title" placeholder="Question Title" value="<?php echo $row['title'] ?>" required>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="que_desc" class="form-label">Question Description</label>
                                        <textarea class="form-control" rows="5" placeholder="Question Description" name="que_desc" id="que_desc"><?php echo $row['describtion'] ?></textarea>
                                    </div>
                                    <div class="text-center col-12"><button type="submit">Update Question</button></div>
                                </div>
                            </form>
                            <?php
                            // echo "<br> id: ". $row["id"]. " - Name: ". $row["firstname"]. " " . $row["lastname"] . "<br>";
                          }
                        } else {
                          echo "No question found";
                        }

                        ?>

                    </div>
                </div>
            </div>
        </section><!-- End Contact Section -->
    </main><!-- End #main -->
<?php require_once 'includes/footer.php';?>