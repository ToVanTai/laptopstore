<?php
    function fixSqlInjection($str) {
        $str = str_replace("\\", "\\\\", $str);
        $str = str_replace("'", "\'", $str);
        return $str;
    }
    function getGET($key) {
        $value = null;
        if (!empty($_GET[$key])) {
            $value = $_GET[$key];
        }
        $value = fixSqlInjection($value);
    
        return $value;
    }
    function getPOST($key) {
        $value = null;
        if (!empty($_POST[$key])) {
            $value = $_POST[$key];
        }
        $value = fixSqlInjection($value);
        return $value;
    }
    function validateFile($files){
        $resTex="";
        $currentName = $files['name'];
        $allowTypes = array('jpg','png','jpeg','gif');
        $imageFileType=pathinfo($currentName,PATHINFO_EXTENSION);
        $maxFileSizes = 800000;
        $check = getimagesize($files["tmp_name"]);
        if($check==false){
            $resTex= "This is not a picture(jpg, png, jpeg, gif). ";
        }
        if($files['size']>$maxFileSizes){
            $resTex=$resTex."Kich thuoc khong hop le(<=0.8MB). ";
        }
        if(!in_array($imageFileType,$allowTypes)){
            $resTex=$resTex." Loại file không hợp lệ. ";
        }
        return $resTex;
    }
    //http://localhost/BTL_N8/utils/validateStr.php
    // function validateName($input){
    //     return preg_match();
    // }
    // function validatePassword($input){
    //     return preg_match();
    // }
    // function validateAccount($input){//không có khoảng trắng, 5->15 ký tự,
    //     $pattent="//";
    //     return preg_match($pattent,$input);
    // }
    // function validateImage($input){

    // }
    // tên người dùng: dài từ 3->15 ký tự, chỉ bao gồm số và chữ, khoảng trắng. Không có khoảng trắng ở đầu và cuối
    // mật khẩu: dài từ 3->15 ký tự, chỉ bao gồm số, chữ
    // tên tài khoản: dài từ 3->15 ký tự, không được có khoảng trắng, chỉ bao gồm số, chữ, @
