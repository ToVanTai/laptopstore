<?php
    /**
     * Thực thi cấu truy vấn và o có kết quả trả về
     * $multi: false insert 1 row. Nếu là true insert array
     */
    function execute($sql, $multi = false)
    {
        $conn = null;
        $result = true;
        try {
            $conn = empty($conn) ? mysqli_connect(host, user, password, database) : $conn;
            mysqli_set_charset($conn, 'utf8');

            if ($multi) {
                mysqli_multi_query($conn, $sql);
            } else {
                mysqli_query($conn, $sql);
            }
        } catch (Exception $e) {
            $result = false;
        } finally {
            // Đảm bảo rằng kết nối sẽ được đóng bất kể có lỗi hay không
            if ($conn) {
                mysqli_close($conn);
            }
        }
        return $result;
    }
    /**
     * thực thi câu truy vấn có kết quả trả về
     * $resultOne: true => trả về  1 object. Nếu là false trả về 1 danh sách
     */
    function executeResult($sql, $resultOne = false){
        $conn = null;
        $data = [];

        try {
            $conn = empty($conn) ? mysqli_connect(host, user, password, database) : $conn;
            mysqli_set_charset($conn, 'utf8');
            $resultset = mysqli_query($conn, $sql);

            if ($resultOne) {
                $data = mysqli_fetch_array($resultset, 1);
                return $data;
            }

            while (($row = mysqli_fetch_array($resultset, 1)) != null) {
                $data[] = $row;
            }
        } catch (Exception $e) {
        } finally {
            // Đảm bảo rằng kết nối sẽ được đóng bất kể có lỗi hay không
            if ($conn) {
                mysqli_close($conn);
            }
        }
        return $data;
    }
?>