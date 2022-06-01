<?php
include_once "../db/config.php";
include_once "../utils/dbhelper.php";
include_once "../utils/session.php";
include_once "../utils/validate.php";
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
Session::init();
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // readAll();
}

?>

