<?php 
require_once('includes/header.php'); 
function verifyRecaptcha($recaptchaResponse) {
    $recaptchaSecret = '6LfDwxAoAAAAAKFFqL1-iQnRUYSUXToxMl_2uLoJ';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'secret' => $recaptchaSecret,
        'response' => $recaptchaResponse,
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response);
    return $result->success;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['g-recaptcha-response']) || !verifyRecaptcha($_POST['g-recaptcha-response'])) {
        echo "<h3 class='text-bg-danger text-center p-3'> ReCAPTCHA verification failed!!! </h3>";
        exit();
    }

    require_once('includes/dbh.php');

    if (!mysqli_select_db($db, "codetogether_db")) {
        die("couldn't open db");
    }

    $stmt = mysqli_prepare($db, "SELECT username FROM reg_users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, 's', $_POST["username"]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        die("username already taken");
    }

    $un = $_POST["username"];
    $pw = password_hash($_POST["password"], PASSWORD_DEFAULT);  // Hashing the password

    $qry = "INSERT INTO reg_users (username, passwrd) VALUES (?, ?)";
    $stmt = mysqli_prepare($db, $qry);
    mysqli_stmt_bind_param($stmt, 'ss', $un, $pw);

    if (mysqli_stmt_execute($stmt)) {
        echo "Registration successful.";
        session_start();
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["login"] = true;
        header("Location:index.php");
        exit();
    } else {
        echo "Registration failed.";
    }

    mysqli_close($db);
}
?>

<main id="main">
    <section id="contact" class="contact">
        <div class="container">
            <div class="section-title mt-5">
                <h2>Signup</h2>
            </div>
            <div class="row">
                <div class="col-lg-12 mt-2 mt-lg-0">
                    <form action="#" method="post" role="form" class="php-email-form mw-700">
                        <div class="row gy-2 gx-md-3">
                            <div class="form-group col-12">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                            </div>
                            <div class="form-group col-12">
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                            </div>
                            <div class="form-group col-12">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                            </div>
                            <div class="g-recaptcha" data-sitekey="6LfDwxAoAAAAANppw5oUTNeyOAYpaadIeJdgXZrE"></div>
                            <div class="text-center col-12"><button type="submit">Signup</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php require_once('includes/footer.php'); ?>
