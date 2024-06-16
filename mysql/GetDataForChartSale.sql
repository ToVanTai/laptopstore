DROP PROCEDURE IF EXISTS GetDataForChartSale;


CREATE PROCEDURE GetDataForChartSale(IN fromDate DATE, IN toDate DATE)
BEGIN
    -- Tạo bảng tạm để lưu trữ kết quả danh sách và tổng
    CREATE TEMPORARY TABLE temp_list1 (
        branch_name VARCHAR(255),
        Total INT
    );
    
    -- Lấy dữ liệu cho biểu đồ doanh số bán hàng theo hãng sản xuất và lưu vào bảng tạm
    INSERT INTO temp_list1 (branch_name, Total)
    SELECT
        b.name AS branch_name,
        SUM(od.quantity) AS Total
    FROM
        order_details od
    INNER JOIN products p ON
        od.product_id = p.id
    INNER JOIN brands b ON
        b.id = p.brand_id
    INNER JOIN orders o ON
        o.id = od.order_id
    WHERE
        o.created_at >= fromDate AND o.created_at <= toDate
    GROUP BY
        b.name;
    
    -- Lấy danh sách hãng sản xuất
    SELECT * FROM brands;
    
    -- Lấy danh sách và tổng từ bảng tạm
    SELECT * FROM temp_list1;
END

CALL GetDataForChartSale('2022-06-01', '2022-12-31');