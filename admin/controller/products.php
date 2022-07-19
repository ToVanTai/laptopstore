<?php
    include_once "../../db/config.php";
    include_once "../../utils/dbhelper.php";
    include_once "../../utils/session.php";
    include_once "../../utils/validate.php";
    $http_origin = "";
    if (!empty($_SERVER['HTTP_ORIGIN'])) {
        if (in_array($_SERVER['HTTP_ORIGIN'], allowedOrigins)) {
            $http_origin = $_SERVER['HTTP_ORIGIN'];
        }
    }
    
    header("Access-Control-Allow-Origin: " . $http_origin);
    header("Access-Control-Allow-Methods: GET,POST");
    header("Access-Control-Allow-Credentials: true");
    
    $method = $_SERVER["REQUEST_METHOD"];
    Session::init();
    if($method=="GET" && empty($_GET["id"])){//call api
        //get products
        getProducts();
        die();
    }

    function getProducts(){
        $query='select id, background, model, screen, RAM, hardware, OS, CPU, VGA,warranty,discount, color from products';
        $dataRes=executeResult($query);
        if(count($dataRes)>=1){
            $i=1;
            foreach ($dataRes as $item) {
                $image = baseUrl.'store/'.$item['background'];
                echo '
                    <tr>
                        <td>'.$i.'</td>
                        <td>'.$item['model'].'</td>
                        <td><img style="height:50px; object-fit:cover" src="'.$image.'" alt=""></td>
                        <td>'.$item['screen'].'</td>
                        <td>'.$item['RAM'].'</td>
                        <td>'.$item['hardware'].'</td>
                        <td>'.$item['OS'].'</td>
                        <td>'.$item['CPU'].'</td>
                        <td>'.$item['VGA'].'</td>
                        <td>'.$item['warranty'].'</td>
                        <td>'.$item['discount'].'%</td>
                        <td>'.$item['color'].'</td>
                        <td>
                            <a href="index.php?view=change-product&id='.$item['id'].'" class="btn">Sửa</a>
                            <a href="index.php?view=product&id='.$item['id'].'" class="btn">Xem</a> 
                        </td>
                    </tr>';
                // echo '
                //     <tr>
                //         <td>'.$i.'</td>
                //         <td>'.$item['name'].'</td>
                //         <td><img style="height:50px; object-fit:cover" src="'.$image.'" alt=""></td>
                //         <td>
                //             <a href="index.php?view=change-brand&id='.$item['id'].'" class="btn">Sửa</a> 
                //         </td>
                //     </tr>';
                $i++;
            }
        }
    }
