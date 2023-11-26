<?php
require_once 'includes/header.php';
require_once 'includes/dbh.php';

?>

<?php
$queryNew = "SELECT
                question.title AS q_title,
                question.describtion AS q_desc,
                question.qID AS q_id,
                answer.id AS ans_id,
                answer.textt AS ans_reply,
                answer.rating AS ans_rating,
                answer.avg_rating AS ans_avg_rating,
                answer.posted_by AS ans_posted_by
            FROM question
            LEFT JOIN answer ON question.qID = answer.q_id
            ORDER BY question.qID DESC LIMIT 10";

$query2 = "SELECT question.*, answer.* FROM question, answer";
if (!($rs = mysqli_query($db, $queryNew))) {

    echo "couldnt fetch questions";
    die(mysqli_error($db));
} else {
    $rowMRQue = mysqli_fetch_all($rs, MYSQLI_ASSOC);
    mysqli_free_result($rs);
}



if (!($rsAns = mysqli_query($db, "SELECT title, describtion, qID, (SELECT COUNT(id) from answer where q_id = qID) as answer_count FROM question  ORDER BY answer_count DESC LIMIT 10"))) {

    echo "couldnt fetch questions";
    die(mysqli_error($db));
} else {
    $rowMAQue = mysqli_fetch_all($rsAns);
    // echo '<pre>'; print_r($rowMAQue); echo '</pre>';
}

?>
    <main id="main">
    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=64fc87d0d1ce2d0012f12503&product=sticky-share-buttons&source=platform" async="async"></script>
    <div class="sharethis-sticky-share-buttons"></div>
    <section id="faq" class="faq section-bg pt-4">
            <div class="container">
                <div class="section-title pb-0">
                    <h2>Most Recent Questions</h2>
                </div>
                <div class="faq-list">
                    <?php
                        if (!empty($rowMRQue)) {
                            echo "<ul>";

                            function array_group(array $data, $by_column)
                            {
                                $result = [];
                                foreach ($data as $item) {
                                    $column = $item[$by_column];
                                    unset($item[$by_column]);
                                    $result[$column][] = $item;
                                }
                                return $result;
                            }

                            $mergedAns = array_group($rowMRQue, 'q_id');
                            // echo '<pre>'; print_r($mergedAns); echo '</pre>';

                            foreach ($mergedAns as $key_q_id=>$value_q_ans) {
                                ?>
                                <li>
                                    <i class="bx bx-help-circle icon-help"></i> <a class="collapse"><?php echo $value_q_ans[0]['q_title']; ?> <i class="bx bx-chevron-down icon-show"></i></a>
                                    <div class="collapse show">
                                        <p>
                                            <?php echo $value_q_ans[0]['q_desc']; ?>
                                        </p>
                                        <?php
                                        foreach ($value_q_ans as $answers) {
                                            // echo '<pre>'; print_r($answers); echo '</pre>';
                                            if($answers['ans_id'] != '') {
                                        ?>

                                        <div class="answer-box">
                                            <p><?php echo $answers['ans_reply']; ?></p>
                                            <label class="w-100">Added By: <?php echo $answers['ans_posted_by']; ?>.</label>
                                            <?php if(isset($_SESSION["login"])) { ?>
                                            <form action="add_ratting.php" method="post" class='d-inline-block'>
                                                <input type="hidden" name="page_name" value="<?php echo basename($_SERVER['PHP_SELF']); ?>">
                                                <input type="hidden" name="cur_ans_id" value="<?php echo $answers['ans_id']; ?>">
                                                <input type="hidden" name="cur_rating" value="<?php echo $answers['ans_rating']; ?>">
                                                <input type="hidden" name="cur_avg_rating" value="<?php echo $answers['ans_avg_rating']; ?>">
                                                <input type="text" name="cur_star_rating" class="cur-star-inp">
                                                <div class="rating">
                                                    <input type="radio" value="5" >
                                                    <label class="submit_star-lbl" data-rating="5"></label>
                                                    <input type="radio" value="4" >
                                                    <label class="submit_star-lbl" data-rating="4"></label>
                                                    <input type="radio" value="3">
                                                    <label class="submit_star-lbl" data-rating="3"></label>
                                                    <input type="radio" value="2">
                                                    <label class="submit_star-lbl" data-rating="2"></label>
                                                    <input type="radio" value="1">
                                                    <label class="submit_star-lbl" data-rating="1"></label>
                                                </div>
                                            </form>
                                            <?php
                                                } else {
                                                    echo "<small class='fst-italic d-inline-block'>Login to give ratting!</small>";
                                                }
                                            ?>

                                            <div class="d-inline-block float-end ml-10 fst-italic  text-bg-warning">
                                                Average Ratting: <?php echo $answers['ans_avg_rating'] ?>
                                            </div>
                                            <?php
                                                $sql_com = "SELECT * FROM comment WHERE a_id=".$answers['ans_id'];
                                                $result_com = mysqli_query($db, $sql_com);
                                                if($result_com) {
                                                    if (mysqli_num_rows($result_com) > 0) {
                                                      while($row_com = mysqli_fetch_assoc($result_com)) {
                                                      echo '<div class="comment-box">';
                                                        // echo '<pre>'; print_r($row_com); echo '</pre>';
                                                        echo '<p>'.$row_com['com_text'].'</p>
                                                            <label class="w-100">Added By: '.$row_com['posted_by'].'</label>';
                                                        // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
                                                      echo '</div>';
                                                      }
                                                    } else {
                                                      // echo "0 results";
                                                    }
                                                }


                                                if(isset($_SESSION["login"])) {
                                            ?>
                                            <form action="add_comment.php" method="post">
                                                <input type="hidden" name="qID" value="<?php echo $key_q_id; ?>">
                                                <input type="hidden" name="ans_id" value="<?php echo $answers['ans_id']; ?>">
                                                <input type="hidden" name="page_name" value="<?php echo basename($_SERVER['PHP_SELF']); ?>">
                                                <textarea class="form-control mt-2" name="comment" placeholder="Add Comment" rows="1" required></textarea>
                                                <button type="submit" class="btn btn-secondary btn-sm mt-2">Add Comment</button>
                                            </form>
                                            <?php
                                                } else {
                                                    echo "<small class='fst-italic w-100 d-block'>Login to add comment!</small>";
                                                }
                                            ?>
                                        </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <?php
                                            if(isset($_SESSION["login"])) {
                                        ?>
                                        <form action="add_answer.php" method="post">
                                            <input type="hidden" name="qID" value="<?php echo $key_q_id; ?>">
                                            <input type="hidden" name="page_name" value="<?php echo basename($_SERVER['PHP_SELF']); ?>">
                                            <textarea class="form-control mt-2" name="reply" placeholder="Add Answer" required></textarea>
                                            <button type="submit" class="btn btn-primary mt-2">Reply</button>
                                        </form>
                                        <?php
                                            } else {
                                                echo "<small class='fst-italic'>Login to reply!</small>";
                                            }
                                        ?>
                                    </div>

                                </li>
                                <?php
                            }
                            echo "</ul>";
                        } else {
                            echo '<a class="getstarted btn btn-primary" href="new_question.php">Create a Question</a>';
                        }
                    ?>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
    <?php
    mysqli_close($db);
     ?>
<?php require_once 'includes/footer.php';?>