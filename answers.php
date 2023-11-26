<?php require_once 'includes/header.php';?>
<?php require_once 'includes/login-check.php';?>
<?php

require_once 'includes/dbh.php';

if (!mysqli_select_db($db, "codetogether_db")) {
    die("couldnt open db");
}


$curUser = $_SESSION['username'];


$sql = "SELECT * FROM answer WHERE posted_by='".$curUser."'";

$result = mysqli_query($db, $sql);





?>

     <main id="main">
        <!-- ======= Contact Section ======= -->
        <section id="faq" class="faq section-bg pt-1">
            <div class="container" >
                <div class="section-title mt-5">
                    <h2>My Answers</h2>
                </div>
                <div class="row">
                    <div class="col-lg-12 mt-2 mt-lg-0">

                        <?php

                        if (mysqli_num_rows($result) > 0) {


                          
                        echo '
                        <div class="form-group faq-list mb-3">
                        <input type="text" name="search_ans" id="search_ans" class="form-control text-center" placeholder="search answers here" />
                        </div>
                            <div class="faq-list">

                            <ul class="ans-list">';
                          while($row = mysqli_fetch_assoc($result)) {
                            
                            ?>
                            <li>
                                    <div class="collapse show">
                                        <p class="mb-3">
                                            <?php echo $row['textt']; ?>
                                        </p>
                                        <a class="getstarted d-inline btn btn-info" href="edit_answer.php?ans_id=<?php echo $row['id'] ?>">Edit Answer</a>
                                        <a class="getstarted d-inline btn btn-danger float-end" href="delete_answer.php?ans_id=<?php echo $row['id'] ?>">Delete Answer</a>
                                    </div>

                                </li>
                            <?php
                          }
                          echo "</ul></div>";
                        } else {
                          echo "0 results";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section><!-- End Contact Section -->
    </main><!-- End #main -->
<?php require_once 'includes/footer.php';?>
