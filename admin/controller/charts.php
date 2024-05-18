<?php
include_once __DIR__ . "/../../utils/index.php";
Session::init();


$method = $_SERVER["REQUEST_METHOD"];
if ($method == "GET" && $_GET["type"] == "sales-chart") {
    getDataForSalesChart();
    die();
}
if ($method == "GET" && $_GET["type"] == "visitors-chart") {
    getDataForVisitorsChart();
    die();
}

if ($method == "GET" && $_GET["type"] == "new_order") {
    getDataForNewOrder();
    die();
}
function getDataForSalesChart()
{
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
            o.created_at >= '" . $fromDate . "' AND o.created_at <= '" . $toDate . "'
        GROUP BY
        b.name, b.id;";

    $list1 = executeResult($query1);
    $query2 = "SELECT * FROM brands;";
    $list2 = executeResult($query2);
    $dataResponse = array(
        "listQuantity" => $list1,
        "branchs" => $list2,
    );
    echo json_encode($dataResponse);
    http_response_code(200);
}
function getDataForVisitorsChart()
{
    $query1 = "SELECT MONTH(orders.created_at) AS month, SUM(order_details.quantity * order_details.price) AS total_revenue
    FROM orders
    JOIN order_details ON orders.id = order_details.order_id
    WHERE YEAR(orders.created_at) = YEAR(CURRENT_DATE())
    GROUP BY MONTH(orders.created_at)
    ORDER BY MONTH(orders.created_at)";
    $list1 = executeResult($query1);
    echo json_encode($list1);
    http_response_code(200);
}

function getDataForNewOrder()
{
    $query1 = "SELECT u.id AS user_id, u.email AS email, u.name AS name, s.name AS status_name, o.id AS order_id,
        o.created_at as created
        FROM orders  o
        INNER JOIN status s ON o.status_id = s.id
        INNER JOIN users u ON u.id = o.user_id
        ORDER BY o.created_at DESC
        LIMIT 10;";
    $list1 = executeResult($query1);
    echo json_encode($list1);
    http_response_code(200);
}
?>