<?php
if ((!isset($_GET["qID"]) || $_GET["qID"] == '')) {
    header("Location:index.php");
    exit;
}
?>