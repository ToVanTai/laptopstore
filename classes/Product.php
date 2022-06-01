<?php
    class Product{
        public static function readPage($page, $limit, $name, $category)
        {
            $page = (int)$page;
            $limit = (int)$limit;
            $sql = "select * from users";
            $count = count(executeResult($sql)); //54
            $totalRow = ceil($count / $limit);
            if ($page > $totalRow) {
                $page = 1;
            };
            $from = ($page - 1) * $limit;
            $sql = "select * from users limit $from,$limit";
            $data = executeResult($sql);
            $dataRes = array("data" => $data, "pagination" => array("page" => $page, "limit" => $limit, "totalRow" => $totalRow));
            return $dataRes;
        }
    }
?>