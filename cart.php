<?php 
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';
//$cart_id = '';
if ($cart_id != '') {
	$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}' ");
	$result = mysqli_fetch_assoc($cartQ);
	$items = json_decode($result['items'], true);
	$i = 1;
	$sub_total = 0;
	$item_count = 0;
}
 ?>

<div class="row">
	<div class="col-md-12">
		<h2 class="text-center">My Shopping Cart</h2><hr>
		<?php if($cart_id == ''): ?>
			<div class="bg-danger">
				<p class="text-center text-danger">Your shopping cart is empty!</p>
			</div>
		<?php else: ?>
			<table class="table table-bordered table-stripped table-condensed">
				<thead>
					<th>#</th>
					<th>Item</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Size</th>
					<th>Sub-total</th>
				</thead>
				<tbody>
					<?php 
						foreach ($items as $item) {
							$product_id = $item['id'];
							$productQ   = $db->query("SELECT * FROM products WHERE id = '{$product_id}' ");
							$product 	= mysqli_fetch_assoc($productQ);
							$sArray		= explode(',', $product['sizes']);
							foreach ($sArray as $sizeString) {
								$s = explode(':', $sizeString);
								if ($s[0] == $item['size']) {
									$available = $s[1];
								}
							}
							?>
							<tr>
								<td><?= $i; ?></td>
								<td><?= $product['title']; ?></td>
								<td><?= money($product['price']); ?></td>
								<td>
								<button class="btn btn-default btn-xs" onclick="update_cart('removeone', '<?= $product['id']; ?>', '<?= $item['size']; ?>')">-</button>
									
									<?= $item['quantity']; ?>
									<?php if ($item['quantity'] < $available): ?>
										<button class="btn btn-default btn-xs" onclick="update_cart('addone', '<?= $product['id']; ?>', '<?= $item['size']; ?>')">+</button>
									<?php else: ?>
										<span class="text-danger">MAX</span>
									<?php endif ?>
									
								</td>
								<td><?= $item['size']; ?></td>
								<td><?= money($item['quantity'] * $product['price']); ?></td>
							</tr>

				  			<?php 
				  			$i++; 
				  			$item_count += $item['quantity'];
				  			$sub_total  += ($item['quantity'] * $product['price']);
				  			$tax = TAXRATE * $sub_total;
				  			$tax = number_format($tax, 2);
				  			$grand_total = $tax + $sub_total;


				  			} ?>
				</tbody>
			</table>
			<legend>Total</legend>
			<table class="table table-bordered text-right table-stripped table-condensed">
				<thead class="totals-table-header" id="htotal">
					<th>Total item</th>
					<th>Sub total</th>
					<th>tax</th>
					<th>Grand total</th>
				</thead>
				<tbody id="btotal">
					<tr>
						<td><?= $item_count ?></td>
						<td><?= money($sub_total) ?></td>
						<td><?= money($tax) ?></td>
						<td class="bg-success"><?= money($grand_total) ?></td>
					</tr>
				</tbody>
			</table>

			<!-- Modal -->
	<div id="modal">
		<button type="button" class="btn btn-lg btn-primary pull-right" data-toggle="modal" data-target="#checkoutModal">
			<span class="glyphicon glyphicon-shopping-cart"></span>Checkout
		</button>
		<div class="modal fade" id="checkoutModal" role="dialog" data-toggle="modal"  tabindex="-1" aria-labelledby="detail-1">
	        <div class="modal-dialog modal-lg" role="document">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	                    <h4 class="modal-title text-center" id="checkoutModalLabel">Shipping Address</h4><hr>
	                </div>
	                <div class="modal-body">
	                <div class="rw">
	                    <form action="thankyou.php" method="post" id="payment-form">
		                    <span class="bg-danger" id="payment-errors"></span>
		                    <input type="hidden" name="tax" value="<?= $tax; ?>">
		                    <input type="hidden" name="sub_total" value="<?= $sub_total; ?>">
		                    <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
		                    <input type="hidden" name="cart_id" value="<?= $cart_id; ?>">
		                    <input type="hidden" name="description" value="<?= $item_count.'item'.(($item_count>1)?'s':'').' from NewLooks'; ?>">
	                    	<div id="step1" style="display: block;">
	                    		<div class="form-group col-md-6">
	                    			<label for="full_name">Full name</label>
	                    			<input type="text" class="form-control" name="full_name" id="full_name">
	                    		</div>
	                    		<div class="form-group col-md-6">
	                    			<label for="email">Email</label>
	                    			<input type="email" class="form-control" name="email" id="email">
	                    		</div>
	                    		<div class="form-group col-md-6">
	                    			<label for="street">Street address</label>
	                    			<input type="text" class="form-control" name="street" id="street" data-stripe="address_line1">
	                    		</div>
	                    		<div class="form-group col-md-6">
	                    			<label for="street2">Street address</label>
	                    			<input type="text" class="form-control" name="street2" id="street2" data-stripe="address_line2">
	                    		</div>
	                    		<div class="form-group col-md-6">
	                    			<label for="city">City</label>
	                    			<input type="text" class="form-control" name="city" id="city" data-stripe="address_city">
	                    		</div>
	                    		<div class="form-group col-md-6">
	                    			<label for="state">State</label>
	                    			<input type="text" class="form-control" name="state" id="state" data-stripe="address_state">
	                    		</div>
	                    		<div class="form-group col-md-6">
	                    			<label for="zip_code">Zipcode</label>
	                    			<input type="text" class="form-control" name="zip_code" id="zip_code" data-stripe="address_zip">
	                    		</div>
	                    		<div class="form-group col-md-6">
	                    			<label for="country">Country</label>
	                    			<input type="text" class="form-control" name="country" id="country" data-stripe="address_country">
	                    		</div>
	                    	</div>
	                    	<div id="step2" style="display: none;">
	                    		<div class="form-group col-md-3">
	                    			<label for="name">Name on card</label>
	                    			<input type="text" id="name" class="form-control" data-stripe="name">
	                    		</div>
	                    		<div class="form-group col-md-3">
	                    			<label for="number">Card number</label>
	                    			<input type="text" id="number" class="form-control" data-stripe="number">
	                    		</div>
	                    		<div class="form-group col-md-2">
	                    			<label for="cvc">CVC</label>
	                    			<input type="text" id="cvc" class="form-control" data-stripe="cvc">
	                    		</div>
	                    		<div class="form-group col-md-2">
	                    			<label for="exp-month">Expire month</label>
	                    			<select id="exp-month" class="form-control" id="" data-stripe="exp_month">
	                    				<option value=""></option>
	                    				<?php for ($i=1; $i < 13; $i++):?>
	                    					<option value="<?= $i; ?>"><?= $i; ?></option>
	                    				<?php endfor; ?>
	                    			</select>
	                    		</div>
	                    		<div class="form-group col-md-2">
	                    			<label for="exp-year">Expire year</label>
	                    			<select id="exp-year" class="form-control" id="" data-stripe="exp_year">
	                    				<option value=""></option>
	                    				<?php $yr = date('Y'); ?>
	                    				<?php for ($i=0; $i < 10; $i++):?>
	                    					<option value="<?= $yr+$i; ?>"><?= $yr+$i; ?></option>
	                    				<?php endfor; ?>
	                    			</select>
	                    		</div>
	                    	</div>
	                   </div>
	                </div>
	                <div class="modal-footer">
	                    <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
	                    <button class="btn btn-primary" type="button" onclick="check_address();" id="next_button">Next >></button>
	                    <button class="btn btn-primary" type="button" onclick="back_address();" id="back_button" style="display: none;"><< Back</button>
	                    <button class="btn btn-primary" type="submit" id="checkout_button" style="display: none;">Check out >></button>
	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
				<!-- Modal end -->
			<?php endif; ?>
		</div>
	</div>



<!-- <script>
	
	jQuery.ajax ({
        url: '/dream/admin/parsers/check_address.php',
        method: 'POST',
        data: data,
         success : function(resp){
           if(resp != 1){
             jQuery('#payment-errors').html(resp);
           }
           if(resp == true){
            jQuery('#payment-errors').html('');
            jQuery('#step1').css('display','none');
 			jQuery('#step2').css('display','block');
 			jQuery('#next_button').css('display','none');
 			jQuery('#back_button').css('display','inline-block');
 			jQuery('#checkout_button').css('display','inline-block');
 			jQuery('#checkoutModalLabel').html('Enter your card details');
           }
         },

      error: function(){alert('Something went wrong...');},
    });

and change the echo statements in your check_address.php file to
//display the errors message

</script> -->







<script>
 function back_address() {
 	jQuery('#payment-errors').html('');
 	jQuery('#step1').css('display','block');
 	jQuery('#step2').css('display','none');
 	jQuery('#next_button').css('display','block');
 	jQuery('#back_button').css('display','none');
 	jQuery('#checkout_button').css('display','none');
 	jQuery('#checkoutModalLabel').html('Enter your card details');
 }
 function check_address() {	
 	var data = {
 		'full_name' : jQuery('#full_name').val(),
 		'email' : jQuery('#email').val(),
 		'street' : jQuery('#street').val(),
 		'street2' : jQuery('#street2').val(),
 		'city' : jQuery('#city').val(),
 		'state' : jQuery('#state').val(),
 		'zip_code' : jQuery('#zip_code').val(),
 		'country' : jQuery('#country').val(),

 	};
 	jQuery.ajax({
 		url : '/ecommerce/admin/parsers/check_address.php',
 		method : 'post',
 		data : data,
 		success : function(data){
 			if (data != 'passed') {
 				jQuery('#payment-errors').html(data);
 			}
 			if (data == 'passed') {
 			 	jQuery('#payment-errors').html('');
 				jQuery('#step1').css('display','none');
 				jQuery('#step2').css('display','block');
 				jQuery('#next_button').css('display','none');
 				jQuery('#back_button').css('display','inline-block');
 				jQuery('#checkout_button').css('display','inline-block');
 				jQuery('#checkoutModalLabel').html('Enter your card details');
 				
 			}
 		},
 		error : function(){
 			alert ('somothing went wrong');
 		},
 	});
 }
 Stripe.setPublishableKey("<?= STRIPE_PUBLIC; ?>");

 function stripeResponseHandler(status, response){
 	var $form = $('#payment-form');

 	if (response.error) {
 		$form.find('#payment-errors').text(response.error.message);
 		$form.find('button').prop('disable', true);
 	}else{
 		//response contains id and card, which contains additionalcard details
 		var token = response.id;
 		//insert the token intothe form so it gets submited to server
 		$form.append($('<input type="hidden" name="stripeToken"/>').val(token));
 		//and submit
 		$form.get(0).submit();

 	}
 };



 jQuery(function($){
 	$('#payment-form').submit(function(event){
	 	var $form = $(this);
	 	//disable submit to prevent repeat clicks
	 	$form.find('button').prop('disable', true);
	 	Stripe.card.createToken($form, stripeResponseHandler);

	 	//prevent the form from submitting with the default action
	 	return false;
 	});
 	
 });

</script>

 <?php include 'includes/footer.php'; ?>