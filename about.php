<?php
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