<?php
require_once 'core/init.php'; 
include 'includes/head.php'; 
include 'includes/navigation.php';
include 'includes/headerpartial.php';
include 'includes/leftbar.php';

if (isset($_GET['cat'])) {
	$cat_id = sanitize($_GET['cat']);
}
else{
	$cat_id = ''; 
}

$sql 	  = "SELECT * FROM products WHERE categories = '$cat_id'";
$productQ = $db->query($sql);
$category = get_category($cat_id);

?>


	<!--Main content-->
	<div id="main" class="col-md-8">
		<div class="row">
			<h2 class="text-center"><?= $category['parent'].' '.$category['child'] ?></h2>
			
			<?php while ($products = mysqli_fetch_assoc($productQ)) : ?>
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



	
