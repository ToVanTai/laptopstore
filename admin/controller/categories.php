<?php
    include_once "../../db/config.php";
    include_once "../../utils/dbhelper.php";
    include_once "../../utils/session.php";
    include_once "../../utils/validate.php";
    $method = $_SERVER["REQUEST_METHOD"];
    Session::init();
    if($method=="POST" && empty($_GET["id"])){
        //add new category
        addNewCategory();
        die();
    }
    if($method=="GET" && empty($_GET["id"])){//call api
        //get categories
        getCategories();
        die();
    }
    if($method=="DELETE" && isset($_GET["id"])){
        deleteCategories($_GET["id"]);
        die();
    }
    if($method=="POST" && !empty($_GET["id"])){
        //add new category
        updateCategories($_GET["id"]);
        die();
    }
    function addNewCategory(){
        $name = getPOST("name");
        $files = $_FILES["image"];
        if(validateFile($files)==""&& $name!=null){
            $nameFile=time().$files["name"];
            $from = $files["tmp_name"];
            $to = "../../store/".$nameFile;
            $created_at=$updated_at= date("Y-m-d h:i:s");
            $created_by = Session::get("user")["id"];
            $role = Session::get("user")["role"];
            if($role==2){
                if(move_uploaded_file($from,$to)){
                $query = "insert into categories(name, image, created_by, created_at, updated_at) values(
                    '".$name."','".$nameFile."','".$created_by."','".$created_at."','".$updated_at."'
                );";
                execute($query);
                echo "<script>
                        alert('Thêm thành công');
                        window.location.href='".baseUrl."admin/index.php?view=new-category';
                    </script>";
            }
            }
        }
    }
    function getCategories(){
        $query='select * from categories';
        $dataRes=executeResult($query);
        if(count($dataRes)>=1){
            $i=1;
            foreach ($dataRes as $item) {
                $image = baseUrl.'store/'.$item['image'];
                echo '
                    <tr>
                        <td>'.$i.'</td>
                        <td>'.$item['name'].'</td>
                        <td><img style="height:50px; object-fit:cover" src="'.$image.'" alt=""></td>
                        <td>
                            <a href="index.php?view=change-category&id='.$item['id'].'" class="btn">Sửa</a> <btn class="btn-delete btn" data-id="'.$item['id'].'" class="btn">Xóa</b>
                        </td>
                    </tr>';
                $i++;
            }
        }
    }
    function deleteCategories($id){

        $query = 'select * from categories where id = '.$id.' limit 1';
        $idInfor = executeResult($query,true);
        $image=$idInfor['image'];
        unlink("../../store/".$image);
        $query='DELETE from categories where id = '.$id.' ;';
        execute($query);
        http_response_code(201);
    }
    function updateCategories($id){
        //có hình ảnh
        $name = $_POST["name"];
        if(!empty($_FILES["image"]["name"])){
            $query = 'select * from categories where id = '.$id.' limit 1';
            $idInfor = executeResult($query,true);
            $image=$idInfor['image'];
            unlink("../../store/".$image);
            //thêm hình ảnh vào store rồi update data;
            $files = $_FILES["image"];
            if(validateFile($files)==""&& $name!=null){
                $nameFile=time().$files["name"];
                $from = $files["tmp_name"];
                $to = "../../store/".$nameFile;
                $updated_at= date("Y-m-d h:i:s");
                $created_by = Session::get("user")["id"];
                $role = Session::get("user")["role"];
                if($role==2){
                    if(move_uploaded_file($from,$to)){
                    $query = "update categories set name = '".$name."',image = '".$nameFile."', created_by = '".$created_by."', updated_at = '".$updated_at."' where id = ".$id." ;";
                    execute($query);
                    echo "<script>
                            alert('Cập nhật thành công');
                            window.location.href='".baseUrl."admin/index.php?view=change-category&id=".$id."';
                        </script>";
                }
                }
        }
        }else{
            $updated_at= date("Y-m-d h:i:s");
            $created_by = Session::get("user")["id"];
            $query="update categories set name = '".$name."',created_by = '".$created_by."',updated_at = '".$updated_at."' where id = ".$id." ; ";
            execute($query);
            echo "<script>
                    alert('Cập nhật thành công');
                    window.location.href='".baseUrl."admin/index.php?view=change-category&id=".$id."';
                </script>";
        }

        //khong có hình ảnh
    }
