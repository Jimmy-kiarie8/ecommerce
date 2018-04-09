<?php 
$sql    = "SELECT * FROM categories WHERE parent = 0";
$pquery = $db->query($sql);




?>
<!--navigation-->
<nav id="navigation" style="opacity: 1;" class="navbar navbar-default navbar-fixed-top">
<div class="container">
	<div class="navbar-header">
		<a href="index.php" class="navbar-brand">New looks admin</a>
		<button class="navbar-toggle" data-target="#myNavbar" data-toggle="collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<div id="myNavbar" class="navbar-collapse">
		<ul class="nav navbar-nav">
			<li><a href="/ecommerce/index.php" class="active"><b>Home</b></a></li>
			<li><a href="brands.php">Brands</a></li>
			<li><a href="categories.php">Categories</a></li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="products.php">Products <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="products.php">Products</a></li>
					<li><a href="products.php?add=1">Add products</a></li>
				</ul>
			</li>
			<li><a href="archived.php">Archived</a></li>
			<?php if(has_permission('admin')): ?>
				<li><a href="users.php"><i class="glyphicon glyphicon-user"></i>Users</a></li>
			<?php endif; ?>
			<li class="dropdown">
				<a href="" class="dropdown-toggle" data-toggle="dropdown">Hellow <?= $user_data['first']?><span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="change_password.php">Change password</a></li>
					<li><a class="glyphicon glyphicon-log-out" href="logout.php">Logout</a></li>
				</ul>
			</li>
		</ul>
	</div>
</div>
</nav>
<!--navigation End-->