<?php
include_once __DIR__."/../utils/index.php";
Session::init();
Session::destroy();
$loginHref = baseUrl."login.php";
echo "
<script>
window.location.href='".$loginHref. "' ;
    </script>";