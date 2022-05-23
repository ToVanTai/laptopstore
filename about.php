<?php

require_once "./utils/session.php";
Session::init();
if(empty(Session::get("user"))){
    header("Location: index.php");
    die();
}

$view = "";
if(!empty($_GET["view"])){
    $view=$_GET["view"];
};
switch($view){
    case "change":
        include "./views/aboutHeader.php" ;
        include "./views/aboutChange.php";
        include "./views/aboutFooter.php";
    break;
    default:
        include "./views/aboutHeader.php" ;
        include "./views/aboutView.php";
        include "./views/aboutFooter.php";
    break;
}

?>