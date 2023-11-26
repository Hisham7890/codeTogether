<?php require_once 'includes/header.php';?>
<?php require_once 'includes/login-check.php';?>
<?php

require_once 'includes/dbh.php';

if (!mysqli_select_db($db, "codetogether_db")) {
    die("couldnt open db");
}

if (isset($_GET['page_no']) && $_GET['page_no']!="") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}
$total_records_per_page = 10;
$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "9";

$result_count      = mysqli_query($db, "SELECT COUNT(*) As total_records FROM question WHERE posted_by =". $_SESSION["username"]);
echo '<pre>'; print_r("ayaaa". $result_count); echo '</pre>';
$total_records     = mysqli_fetch_array($result_count);
$total_records     = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last       = $total_no_of_pages - 1;


if (!($rs = mysqli_query($db, "SELECT title, describtion, qID FROM question WHERE posted_by ='". $_SESSION['username']."' LIMIT $offset, $total_records_per_page"))) {

    echo "couldnt fetch usernames";
    die(mysqli_error($db));
} else {
    $c   = 0;
    $row = mysqli_fetch_all($rs);
}
?>

     <main id="main">
        <!-- ======= Contact Section ======= -->
        <section id="faq" class="faq section-bg pt-1">
            <div class="container" >
                <div class="section-title mt-5">
                    <h2>My Questions</h2>
                </div>
                <div class="row">
                    <div class="col-lg-12 mt-2 mt-lg-0">

                        <?php

                        if (!empty($row)) {
                            echo '<pre>'; print_r($row); echo '</pre>';

                            echo '
                            <div class="faq-list">

                            <ul>';
                            foreach ($row as $value) {
                                ?>
                                <li>
                                    <i class="bx bx-help-circle icon-help"></i> <a class="collapse"><?php echo $value[0]; ?> <i class="bx bx-chevron-down icon-show"></i></a>
                                    <div class="collapse show">
                                        <p class="mb-3">
                                            <?php echo $value[1]; ?>
                                        </p>
                                        <a class="getstarted d-inline btn btn-info" href="edit_question.php?qID=<?php echo $value[2] ?>">Edit Question</a>
                                        <a class="getstarted d-inline btn btn-danger float-end" href="delete_question.php?qID=<?php echo $value[2] ?>">Delete Question</a>
                                    </div>

                                </li>
                                <?php
                            }
                            echo "</ul></div>";
                        } else {
                                echo '<a class="getstarted btn btn-primary" href="new_question.php">Create a Question</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section><!-- End Contact Section -->
    </main><!-- End #main -->
<?php require_once 'includes/footer.php';?>
