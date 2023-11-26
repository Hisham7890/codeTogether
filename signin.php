<?php require_once('includes/header.php'); ?>
    <?php
        if(isset($_POST["username"])){

            require_once('includes/dbh.php');
            if(!($rs=mysqli_query($db, "SELECT * FROM reg_users"))){

                echo "couldnt fetch usernames";
                die(mysqli_error($db));
            }
            $flag = "f";
            while($row = mysqli_fetch_row($rs)){
                if($row[0] == $_POST["username"] && $row[1] == $_POST["password"]){
                    $flag = "t";
                }
            }
            if ($flag == "t"){
                session_start();
                $_SESSION["username"] = $_POST["username"];
                $_SESSION["login"] = true;
                header("Location:index.php") ;
            }else{
                echo " incorrect password/ username";
            }

            mysqli_close($db);
        }
    ?>

    <main id="main">
        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" >
                <div class="section-title mt-5">
                    <h2>Signin</h2>
                </div>
                <div class="row">
                    <div class="col-lg-12 mt-2 mt-lg-0">
                        <form action="#" method="post" role="form" class="php-email-form mw-700">
                            <div class="row gy-2 gx-md-3">
                                <div class="form-group col-12">
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                                </div>
                                <div class="form-group col-12">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                </div>
                                <div class="text-center col-12"><button type="submit">Signin</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section><!-- End Contact Section -->
    </main><!-- End #main -->
<?php require_once('includes/footer.php'); ?>