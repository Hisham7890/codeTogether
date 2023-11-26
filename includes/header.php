<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Q&ampA</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!-- Vendor CSS Files -->

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center justify-content-between">
            <h1 class="logo"><a href="index.php"></a>Q&ampA</h1>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto" href="index.php">Home</a></li>
                    <?php
                        if(isset($_SESSION["login"])) {
                    ?>
                    <li><a class="nav-link" href="my_questions.php">My Questions</a></li>
                    <li><a class="nav-link" href="answers.php">My Answers</a></li>
                    <li><a class="nav-link" href="new_question.php">Create a Question</a></li>
                    <li><a class="nav-link" href="search.php">Find a Question</a></li>

                    <li><a class="getstarted" href="signout.php">Signout</a></li>
                    <?php
                        } else {
                            echo '
                    <li><a class="getstarted" href="signin.php">Signin</a></li>
                    <li><a class="getstarted" href="signup.php">Signup</a></li>
                            ';
                        }
                    ?>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
        </div>
    </header><!-- End Header -->
    <?php
    if(isset($_SESSION["d_message"])) {
        echo '<h3 class="text-bg-warning text-center p-3">'.$_SESSION["d_message"].'</h3>';
        unset($_SESSION["d_message"]);
    }
    ?>