<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Trang quản lý sản phẩm</title>
	<link rel="stylesheet" href="css/grid.css" />
	<link rel="stylesheet" href="css/reset.css" />
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> -->
	<!-- <script src="js/library/boxicons.min.js"></script> -->
	<!-- <link href='css/library/boxicons.min.css' rel='stylesheet'> -->
	<script src="js/library/moment.js"></script>
	<link rel="stylesheet" href="css/admindashboard.css">
	<link rel="stylesheet" href="css/components/table.css">
	<link rel="stylesheet" href="css/components/pagination.css">
</head>
<?php
	$viewMode = isset($_GET["view"])?$_GET["view"]:"dashboard";
	if ($viewMode == "products"||$viewMode == "product" || $viewMode == "change-product" || $viewMode == "new-product" || $viewMode == "change-capacity-product"|| $viewMode == "add-capacity-product") {
		$viewMode = "product";
	}elseif($viewMode == "brands"||$viewMode == "brand" || $viewMode == "change-brand" || $viewMode == "new-brand"){
		$viewMode = "brand";
	}elseif($viewMode=="carts"||$viewMode=="cart"){
		$viewMode = "cart";
	}
?>
<body>
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="index.php" class="brand">
			<img src="css/imgs/logo.png"  class="logo"/>
			<span class="text">AdminHub</span>
		</a>
		<ul class="side-menu top">
			<li class="<?= $viewMode=="dashboard"?"active":"" ?>">
				<a href="index.php">
					<i class='bx bxs-dashboard'></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li class="<?= $viewMode=="product"?"active":"" ?>">
				<a href="index.php?view=products">
					<i class='bx bxs-shopping-bag-alt'></i>
					<span class="text">quản lý sản phẩm</span>
				</a>
			</li>
			<li class="<?= $viewMode=="brand"?"active":"" ?>">
				<a href="index.php?view=brands">
					<i class='bx bxs-doughnut-chart'></i>
					<span class="text">quản lý hãng sản xuất</span>
				</a>
			</li>
			<li class="header__link <?= $viewMode=="cart"?"active":"" ?>">
				<a  href="index.php?view=carts">
					<i class='bx bxs-message-dots'></i>
					<span class="text">quản lý đơn hàng</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<!-- <li>
				<a href="#">
					<i class='bx bxs-cog'></i>
					<span class="text">Settings</span>
				</a>
			</li> -->
			<li>
				<a href="#" class="logout">
					<i class='bx bxs-log-out-circle'></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->
	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<!-- <a href="#" class="nav-link">Tìm kiếm</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
				</div>
			</form> -->
			<div class="header-left">
				<i class='bx bx-menu'></i>
			</div>
			<div class="header-right">
				<input type="checkbox" id="switch-mode" hidden>
				<label for="switch-mode" class="switch-mode"></label>
				<a href="#" class="notification">
					<i class='bx bxs-bell'></i>
					<span class="num">8</span>
				</a>
				<!-- <a href="#" class="profile">
					<img src="css/imgs/people">
				</a> -->
			</div>
		</nav>
		<!-- NAVBAR -->
		<!-- MAIN -->
		<main>
			