<?php
    echo "hello";
    session_start();
    session_destroy();
    header("Location: index.php");
?>