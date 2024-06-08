<div class="body-main-table">
    <div class="table-container" id="customers_table">
        <section class="table__header">
            <a href="index.php?view=new-brand" class="btn">Thêm mới</a>
            <div class="input-group">
                <input type="search" placeholder="Search Data...">
            </div>
            <div class="export__file">
                <label for="export-file" class="export__file-btn bx bxs-file-export" title="Export File"></label>
                <input type="checkbox" id="export-file">
                <div class="export__file-options">
                    <label>Export As &nbsp; &#10140;</label>
                    <label for="export-file" id="toPDF">PDF <img src="css/imgs/pdf.png" alt=""></label>
                    <label for="export-file" id="toJSON">JSON <img src="css/imgs/json.png" alt=""></label>
                    <label for="export-file" id="toCSV">CSV <img src="css/imgs/csv.png" alt=""></label>
                    <label for="export-file" id="toEXCEL">EXCEL <img src="css/imgs/excel.png" alt=""></label>
                </div>
            </div>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                    <th>STT</th>
                    <th>Tên danh mục</th>
                    <th>Hình ảnh</th>
                    <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="product__list">

                </tbody>
            </table>
        </section>
        <section class="table__footer">
            <ul class="pagination" id="pagination-table">
                <!-- <li class="prev">Trước</li>
                <li class="num active">1</li>
                <li class="num">2</li>
                <li class="num">3</li>
                <li class="dots">...</li>
                <li class="num">52</li>
                <li class="next">Sau</li> -->
            </ul>
        </section>
    </div>
</div>
<script type="module" src="js/components/brands.js"></script>