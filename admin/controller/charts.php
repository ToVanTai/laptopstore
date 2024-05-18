<?php
include_once __DIR__."/../../utils/index.php";
Session::init();


$method = $_SERVER["REQUEST_METHOD"];
if($method == "GET" && $_GET["type"] == "sales-chart"){
    getDataForSalesChart();
    die();
}
function getDataForSalesChart(){
    $fromDate = getGET("fromDate");
    $toDate = getGET("toDate");
    $query1 = "SELECT b.name AS branch_name, b.id as branch_id,
        SUM(od.quantity) AS total
        FROM
            order_details od
        INNER JOIN products p ON
            od.product_id = p.id
        INNER JOIN brands b ON
            b.id = p.brand_id
        INNER JOIN orders o ON
            o.id = od.order_id
        WHERE
            o.created_at >= '".$fromDate."' AND o.created_at <= '".$toDate."'
        GROUP BY
        b.name, b.id;";

    $list1 = executeResult($query1);
    $query2 = "SELECT * FROM brands;";
    $list2 = executeResult($query2);
    $dataResponse = array(
        "listQuantity"=>$list1,
        "branchs"=>$list2,
    );
    echo json_encode($dataResponse);
    http_response_code(200);
}
?>