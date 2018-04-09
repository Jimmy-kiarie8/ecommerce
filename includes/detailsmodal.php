<?php 
 require_once '../core/init.php';
 $id	      = $_POST['id'];
 $id	      = (int)$id;
 $sql 	      = "SELECT * FROM products WHERE id = '$id'";
 $results     = $db->query($sql);
 $products    = mysqli_fetch_assoc($results);
 $brand_id    = $products['brand'];
 $sql		  = "SELECT brand FROM brand WHERE id = '$brand_id'";
 $brand_query = $db->query($sql);
 $brand 	  = mysqli_fetch_assoc($brand_query);
 $sizestring  = $products['sizes'];
 $sizestring  = rtrim($sizestring, ',');
 $size_array  = explode(',', $sizestring);
 ?>

<!--detail modal-->
<?php ob_start(); ?>

<div id="modal" class="container-fluid">
<div class="modal fade details_1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="detail-1" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<button class="close" type="button" onclick="closeModal()" aria-label="close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><?= $products['title']; ?></h4><hr>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row">
					<span id="modal_errors" class="bg-danger"></span>
						<div class="col-md-6">
							<div class="center-block">
								<img src="<?= $products['image']; ?>" alt="<?=$products['title'];?>" class="details imgs-responsive">
							</div>
						</div>

						<div class="col-md-6">
							<h4>Details</h4>
							<p><?= nl2br($products['description']); ?></p>
							<hr>
							<p>Price: $<?= $products['price']; ?></p>
							<p>Brand: <?= $brand['brand']; ?></p>
							<!--form-->
							<div id="form">
								<form id="add_product_form" action="add_cart.php" method="POST">
									<input type="hidden" name="product_id" value="<?= $id; ?>">
									<input type="hidden" name="available" id="available" value="">
									<div class="form-group">
										<div class="col-xs-9">
											<label for="quantity">Quantity:</label>
											<input type="number" class="form-control" min="0" id="quantity" name="quantity">
										</div>
									</div>
									<div class="form-group">
										<div class="col-xs-12">
											<label for="size">Size:</label>
											<select name="size" id="size" class="form-control">
												<option value=""></option>
												<?php 
													foreach ($size_array as $string) {
														$string_array = explode(':', $string);
														$size 		  = $string_array[0];
														$available 	  = $string_array[1];
														echo '<option value="'.$size.'" data-available="'.$available.'" >'.$size.'('.$available.' available)</option>';
													}
												 ?>
											</select>
										</div>
									</div>
								</form>
							</div>
							<!--form end-->
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button class="btn" onclick="closeModal()">Close</button>
				<button class="btn btn-warning btn1" onclick="add_to_cart();return false;"><span class="glyphicon glyphicon-shopping-cart"></span> add item</button>
			</div>
		</div>
	</div>
</div>
</div>
<!--detail modal end-->
<script>
jQuery('#size').change(function () {
	var available = jQuery('#size option:selected').data("available");
	jQuery('#available').val(available);
});

function closeModal() {
	jQuery('#details-modal').modal('hide');
	setTimeout(function(){
		jQuery('#details-modal').remove();
			jQuery('.modal-backdrop').remove();
	},500);
}
</script>

<?php echo ob_get_clean(); ?>
