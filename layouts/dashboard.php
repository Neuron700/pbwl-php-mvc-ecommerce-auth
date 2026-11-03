<?php
if (!function_exists('e')) {
	function e($value)
	{
		return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
	}
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Suendri">
	<title>Project 6 Pemrograman Berbasis Web Lanjutan</title>

	<link rel="icon" href="<?php echo AST; ?>/images/favicon.ico">
	<link href="<?php echo AST; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo AST; ?>/bootstrap-icons/bootstrap-icons.min.css" rel="stylesheet">
	<link href="<?php echo AST; ?>/css/style.css" rel="stylesheet">
</head>

<body>

	<div class="d-flex" id="wrapper">
		<div class="bg-primary border-right" id="sidebar-wrapper">
			<div class="sidebar-heading text-white">ECOMMERCE</div>

			<div class="list-group list-group-flush">
				<a href="<?php echo URL; ?>/dashboard" class="list-group-item list-group-item-action">Dashboard</a>
				<a href="<?php echo URL; ?>/kategori" class="list-group-item list-group-item-action">Kategori</a>
				<a href="<?php echo URL; ?>/produk" class="list-group-item list-group-item-action">Produk</a>
				<a href="<?php echo URL; ?>/dashboard/logout" class="list-group-item list-group-item-action">Logout</a>
			</div>
		</div>
		<div id="page-content-wrapper">
			<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
				<div class="container-fluid">
					<button class="btn btn-primary" id="menu-toggle">
						<i class="bi bi-list"></i>
					</button>
				</div>
			</nav>

			<div class="container-fluid p-4">

				<?php if (!empty($_SESSION['flash'])): $flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
					<div class="alert alert-<?php echo e($flash['type']); ?> alert-dismissible fade show" role="alert">
						<?php echo e($flash['message']); ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
					</div>
				<?php endif; ?>

				<?php require_once ROOT . "app/views/" . $view . ".php"; ?>

			</div>
		</div>
	</div>

	<script src="<?php echo AST; ?>/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo AST; ?>/js/app.js"></script>

</body>

</html>