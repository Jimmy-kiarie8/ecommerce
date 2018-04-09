<?php
require_once 'core/init.php'; 
include 'includes/head.php'; 
include 'includes/navigation.php';
include 'includes/headerfull.php';
include 'includes/leftbar.php';


$sql = "SELECT * FROM products WHERE featured = 1";
$featured =$db->query($sql);
?>


	<!--Main content-->
	<div id="main" class="col-md-8">
		<div class="row">
			<h2 class="text-center">Featured products</h2>
			
			<?php while ($products = mysqli_fetch_assoc($featured)) : ?>
			<div class="col-md-3"><hr>
				<h4><?= $products['title']; ?></h4><hr>
				<img src="<?= $products['image']; ?>" alt="<?= $products['image']; ?>">
				<p class="list-price text-danger">List price: <s>$<?= $products['list_price']; ?></s></p>
				<p class="price">Our price: $<?= $products['price']; ?></p>
				<button class="btn btn-sm" type="button" onclick="detailsmodal(<?= $products['id']; ?>)">Details</button>
			</div>
			<?php endwhile; ?>
		</div>
	</div>
	<!--Main content End-->
<?php
include 'includes/rightbar.php';
include 'includes/footer.php';

?>



	
