<?php 
$sql    = "SELECT * FROM categories WHERE parent = 0";
$pquery = $db->query($sql);




?>


<!--navigation-->
<nav id="navigation" class="navbar navbar-fixed-top">
<div class="container">
	<div class="navbar-header">
		<a href="index.php" class="navbar-brand">Shaunter's Boutique</a>
		<button class="navbar-toggle" data-target="#myNavbar" data-toggle="collapse" style="background: #000; color: red;">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<div id="myNavbar" class="navbar-collapse">
		<ul class="nav navbar-nav">
			<li class="pull-right"><a href="/ecommerce/admin/products.php">Back end</a></li>
		<?php while ($parent = mysqli_fetch_assoc($pquery)) : ?>
			<?php
			 $parent_id = $parent['id']; 
			 $sql2      = "SELECT * FROM categories WHERE parent = '$parent_id'";
			 $cquery    = $db->query($sql2);
			?>
		<!--menu items-->
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $parent['category']; ?><span class="caret"></span></a>
				<ul class="dropdown-menu">
				<?php while($child = mysqli_fetch_assoc($cquery)) : ?>
					<li><a href="category.php?cat=<?= $child['id']; ?>"><?php echo $child['category']; ?></a></li>
				<?php endwhile; ?>
				</ul>
			</li>
		<!--menu items-->
		<?php endwhile; ?>
				<li><a href="cart.php" class="fa fa-shopping-cart"> Mycart</a></li>
		</ul>
	</div>
</div>
</nav>
<!--navigation End-->