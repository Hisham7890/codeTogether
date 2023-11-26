<?php require_once 'includes/header.php';?>
<?php require_once 'includes/login-check.php';?>
<?php
if (isset($_POST["que_title"])) {

    require_once 'includes/dbh.php';

    if(!mysqli_select_db($db, "codetogether_db"))
    die("couldnt open db");
    $username = $_SESSION["username"];
    $que_title = $_POST["que_title"];
    $que_desc = $_POST["que_desc"];

    $qry = "INSERT INTO question (posted_by, title, describtion) VALUES ('$username','$que_title','$que_desc')";
    if((mysqli_query($db, $qry))){
    
        echo '<h3 class="text-bg-warning text-center p-3">Question added successfully!!!</h3>';

     
    }
    else {
        echo '<h3 class="text-bg-warning text-center p-3">Error while adding question!!!</h3>';
        

    }
    mysqli_close($db);
}
?>


    <main id="main">
        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact pt-1">
            <div class="container" >
                <div class="section-title mt-5">
                    <h2>Create a New Question</h2>
                </div>
                <div class="row">
                    <div class="col-lg-12 mt-2 mt-lg-0">
                        <form action="#" method="post" role="form" class="php-email-form mw-700">
                            <div class="row gy-2 gx-md-3">
                                <div class="form-group col-12">
                                    <label for="que_title" class="form-label">Question Title</label>
                                    <input type="text" class="form-control" name="que_title" id="que_title" placeholder="Question Title" required>
                                </div>
                                <div class="form-group col-12">
                                    <label for="que_desc" class="form-label">Question Description</label>
                                    <textarea class="form-control" rows="5" placeholder="Question Description" name="que_desc" id="que_desc"></textarea>
                                </div>
                                <div class="text-center col-12"><button type="submit">Post Question</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section><!-- End Contact Section -->
    </main><!-- End #main -->
<?php require_once 'includes/footer.php';?>