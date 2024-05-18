<div class="head-title">
	<div class="left">
		<h1>Dashboard</h1>
		<ul class="breadcrumb">
			<li>
				<a href="index.php">Dashboard</a>
			</li>
			<li><i class='bx bx-chevron-right'></i></li>
			<li>
				<a class="active" href="index.php">Home</a>
			</li>
		</ul>
	</div>
	<!-- <a href="#" class="btn-download">
		<i class='bx bxs-cloud-download'></i>
		<span class="text">Download PDF</span>
	</a> -->
</div>

<ul class="box-info">
	<li class="chart-box">
		<div class="chart-header bg-white">
			<div class="chart-header-title">Doanh số bán hàng theo hãng sản xuất</div>
			<div class="chart-header-action">
				<select name="salesChartAction" id="salesChartAction" style="">
				</select>
			</div>
		</div>
		<div class="chart-body">
			<canvas id="sales-chart"></canvas>
		</div>
	</li>
	<li class="chart-box">
		<div class="chart-header bg-white">
			<div class="chart-header-title">Doanh số bán hàng theo tháng</div>
		</div>
		<div class="chart-body">
			<canvas id="visitors-chart"></canvas>
		</div>
	</li>
</ul>


<div class="table-data">
	<div class="order">
		<div class="head">
			<h3>Đơn hàng mới</h3>
			<i class='bx bx-search'></i>
			<i class='bx bx-filter'></i>
		</div>
		<table>
			<thead>
				<tr>
					<th>Tên người dùng</th>
					<th>Thời gian đặt hàng</th>
					<th>Trạng thái</th>
				</tr>
			</thead>
			<tbody id="table-new-orders">
				<!-- <tr>
					<td>
						<img src="css/imgs/people.png">
						<p>John Doe</p>
					</td>
					<td>01-10-2021</td>
					<td><span class="status completed">Completed</span></td>
				</tr> -->
			</tbody>
		</table>
	</div>
</div>
<script src="./js/components/dashboard.js" type="module"></script>