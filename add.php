<!--women-->
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">women<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="#">Brouse</a></li>
					<li><a href="#">Skirts</a></li>
					<li><a href="#">Shoes</a></li>
					<li><a href="#">Purse</a></li>
				</ul>
			</li>
		<!--women-->

		<!--boys-->
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Boys<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="#">Shirts</a></li>
					<li><a href="#">Pants</a></li>
					<li><a href="#">Shoes</a></li>
					<li><a href="#">Accessories</a></li>
				</ul>
			</li>
		<!--boys-->

		<!--Girls-->
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Girls<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="#">Pants</a></li>
					<li><a href="#">Skirts</a></li>
					<li><a href="#">Shoes</a></li>
					<li><a href="#">Accessories</a></li>
				</ul>
			</li>
		<!--Girls-->


<!--main content-->	
			<div class="col-md-3">
				<h4>Hollister shirt</h4>
				<img src="images/imgs/img7.jpg" alt="">
				<p class="list-price text-danger">List price: <s>$25.99</s></p>
				<p class="price">Our price: $19.99</p>
				<button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#details-1">Details</button>
			</div>

			<div class="col-md-3">
				<h4>Fancy shoes</h4>
				<img src="images/imgs/shoes.jpg" alt="">
				<p class="list-price text-danger">List price: <s>$69.99</s></p>
				<p class="price">Our price: $49.99</p>
				<button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#details-1">Details</button>
			</div>

			<div class="col-md-3">
				<h4>Boys hoddies</h4>
				<img src="images/imgs/img5.jpg" alt="">
				<p class="list-price text-danger">List price: <s>$24.99</s></p>
				<p class="price">Our price: $18.99</p>
				<button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#details-1">Details</button>
			</div>

			<div class="col-md-3">
				<h4>Girls dress</h4>
				<img src="images/imgs/img20.jpg" alt="">
				<p class="list-price text-danger">List price: <s>$34.99</s></p>
				<p class="price">Our price: $19.99</p>
				<button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#details-1">Details</button>
			</div>

			<div class="col-md-3">
				<h4>Women's shirt</h4>
				<img src="images/imgs/img18.jpg" alt="">
				<p class="list-price text-danger">List price: <s>$34.99</s></p>
				<p class="price">Our price: $29.99</p>
				<button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#details-1">Details</button>
			</div>

			<div class="col-md-3">
				<h4>Women's skirts</h4>
				<img src="images/imgs/img9.jpg" alt="">
				<p class="list-price text-danger">List price: <s>$29.99</s></p>
				<p class="price">Our price: $19.99</p>
				<button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#details-1">Details</button>
			</div>

			<div class="col-md-3">
				<h4>Purse</h4>
				<img src="images/imgs/handbag.jpg" alt="">
				<p class="list-price text-danger">List price: <s>$49.99</s></p>
				<p class="price">Our price: $39.99</p>
				<button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#details-1">Details</button>
			</div>	
<!--main content-->

p*Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.



<a tabindex="0" class="btn btn-lg btn-danger" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?">Dismissible popover</a>





<?php// if ($item['quantity'] > 0 ): ?>
										
									<?php //else: ?>
										<span class="text-danger">MIN</span>
									<?php // endif ?>






<?php
require_once '../core/init.php';
if (!is_loged_in()) {
	login_error_redirect();
}
if (!has_permission('admin')) {
	permission_error_redirect('index.php');
}
include 'includes/head.php';
include 'includes/navigation.php';


//delete
if (isset($_GET['delete'])) {
	$delete_id = sanitize($_GET['delete']);
	$db->query("DELETE FROM users WHERE id = '$delete_id' ");
	$_SESSION['success_flash'] = "User was successively deleted";
	header('Location: users.php');
}

if (isset($_GET['add']) || isset($_GET['edit'])) {
	$name 		 = ((isset($_POST['name']) && $_POST['name'] != '')?sanitize($_POST['name']):'');
	$email 	 	 = ((isset($_POST['email']))?sanitize($_POST['email']):'');
	$password 	 = ((isset($_POST['password']))?sanitize($_POST['password']):'');
	$confirm 	 = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
	$permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
	$errors 	 = array();

	//edit
	if (isset($_GET['edit'])) {
		$edit_id 	= (int)$_GET['edit'];
		$edit_id 	= sanitize($_GET['edit']);
		$userResult =  $db->query("SELECT * FROM products WHERE id=$edit_id");
		$userQ 	    =  mysqli_fetch_assoc($userResult);
		$name 		=  ((isset($_POST['name']) && $_POST['name']!='' )?sanitize($_POST['name']):$userQ['name']);

	}
//edit

	if ($_POST) {
		$emailQuery = $db->query("SELECT * FROM users WHERE email = '$email'");
		$emailCount		= mysqli_num_rows($emailQuery);
		if ($emailCount > 0) {
			$errors[] = 'email exists in our database! please enter another email';
		}

		$required = array('name', 'email', 'password', 'confirm', 'permissions');
		foreach ($required as $f) {
			if (empty($_POST[$f])) {
				$errors[] = 'You must enter all fields';
				break;
			}
		}
		//password
		if (strlen($password) < 6) {
			$errors[] = 'Password must be atleast 6 characters';
		}
		if ($password != $confirm) {
			$errors[] = 'Password&confirm don\'t match';
		}
		//email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors[] = 'Invalid email address';
		}

		if (!empty($errors)) {
			echo display_errors($errors);
		}
		else{
			//add new users
			$hashed = password_hash($password, PASSWORD_DEFAULT);
			$db->query("INSERT INTO users(`full_name`, `email`, `password`, `permissions`)VALUES('$name', '$email', '$hashed', '$permissions') ");
			$_SESSION['success_flash'] = 'User has been successively added';
			header('Location: users.php');
		}
	}

?>
<h2 class="text-center"><!--edit--><?= ((isset($_GET['edit']))?'Edit':'Add a new') ?> user</h2><hr>
<form action="users.php?<?= ((isset($_GET['edit']))?'edit='.$edit_id:'add=1'); ?> " method="post" enctype="multipart/form-data">
	<div class="form-group col-md-6">
		<label for="name">Full name</label>
		<input type="text" name="name" id="name" class="form-control" value="<?= $name; ?>">
	</div>

	<div class="form-group col-md-6">
		<label for="email">Email</label>
		<input type="text" name="email" id="email" class="form-control" value="<?= $email; ?>">
	</div>

	<div class="form-group col-md-6">
		<label for="password">Password</label>
		<input type="password" name="password" id="password" class="form-control" value="<?= $password; ?>">
	</div>
    
    <div class="form-group col-md-6">
		<label for="confirm">Confirm password</label>
		<input type="password" name="confirm" id="confirm" class="form-control" value="<?= $confirm; ?>">
	</div>

	<div class="form-group col-md-6">
		<label for="permissions">Permissions</label>
		<select name="permissions" id="permissions" name="permissions">
			<option value=""<?= (($permissions == '')?' select':'') ?>></option>
			<option value="editor"<?= (($permissions == 'editor')?' select':'') ?>>Editor</option>
			<option value="admin,editor"<?= (($permissions == 'admin,editor')?' select':'') ?>>Admin</option>
		</select>
	</div>

	<div class="form-group col-md-6 text-right">
		<a href="users.php" class="btn btn-default" id="add">Cancel</a><!--edit-->
		<input type="submit" value="<?= ((isset($_GET['edit']))?'Edit':'Add a new') ?> user" class="btn btn-primary">
	</div>
</form>

<?php 
}else{

$userQuery = $db->query("SELECT *FROM users");
?>
<h2 class="text-center">Users Page</h2>
<a href="users.php?add=1" class="btn btn-success pull-right" id="add">Add new user</a>
<hr>
<table class="table table-condensed table-striped table-bordered">
	<thead>
		<th></th>
		<th>Name</th>
		<th>Email</th>
		<th>Joined date</th>
		<th>Last login</th>
		<th>Permissions</th>
	</thead>

	<tbody>
	<?php while($user = mysqli_fetch_assoc($userQuery)): ?>
		<tr>
			<td>
				<?php if($user['id'] != $user_data['id']): ?>
					<!--edit--><a href="users.php?edit=<?= $user['id'] ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="users.php?delete=<?= $user['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
				<?php endif; ?>
			</td>
			<td><?= $user['full_name']; ?></td>
			<td><?= $user['email']; ?></td>
			<td><?= pretty_date($user['join_date']); ?></td>
			<td><?= (($user['last_login'] == '0000-00-00 00:00:00' )?'Never':pretty_date($user['last_login'])) ; ?></td>
			<td><?= $user['permissions']; ?></td>
		</tr>
	<?php endwhile; ?>
	</tbody>
</table>



<?php } include  'includes/footer.php'; ?>










<?php
require_once 'core/init.php';

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey(STRIPE_PRIVATE);

// Token is created using Stripe.js or Checkout!
// Get the payment token ID submitted by the form:
$token = isset($_POST['stripeToken'])? $_POST['stripeToken']:'';

// Get the rest of the post data
$full_name = isset($_POST['full_name'])? sanitize($_POST['full_name']):'';
$email = isset($_POST['email'])? sanitize($_POST['email']):'';
$street = isset($_POST['street'])? sanitize($_POST['street']):'';
$street2 = isset($_POST['street2'])? sanitize($_POST['street2']):'';
$city = isset($_POST['city'])? sanitize($_POST['city']):'';
$state = isset($_POST['state'])? sanitize($_POST['state']):'';
$zip_code = isset($_POST['zip_code'])? sanitize($_POST['zip_code']):'';
$country = isset($_POST['country'])? sanitize($_POST['country']):'';
$tax = isset($_POST['tax'])? sanitize($_POST['tax']):'';
$sub_total = isset($_POST['sub_total'])? sanitize($_POST['sub_total']):'';
$grand_total = isset($_POST['grand_total'])? sanitize($_POST['grand_total']):'';
$cart_id = isset($_POST['cart_id'])? sanitize($_POST['cart_id']):'';
$description = isset($_POST['description'])? sanitize($_POST['description']):'';
$charge_amount = number_format((int)$grand_total, 2) * 100;
$metadata = array(
    "cart_id"   => $cart_id,
    "tax"       => $tax,
    "sub_total" => $sub_total,
);

// Charge the user's card:
try {
$charge = \Stripe\Charge::create(array(
  "amount" => $charge_amount,
  "currency" => CURRENCY,
  "description" => $description,
  "source" => $token,
  "receipt_email" => $email,
  "metadata" => $metadata)
);

// Adjust inventory
$itemQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
$iresults = mysqli_fetch_assoc($itemQ);
$items = json_decode($iresults['items'], true);
foreach ($items as $item) {
    $newSizes = array();
    $item_id = $item['id'];
    $productQ = $db->query("SELECT sizes FROM products WHERE id = '{$item_id}'");
    $product = mysqli_fetch_assoc($productQ);
    $sizes = sizesToArray($product['sizes']);
    foreach ($sizes as $size) {
        if ($size['size'] == $item['size']) {
            $q = $size['quantity'] - $item['quantity'];
            $newSizes[] = array('size' => $size['size'], 'quantity' => $q);
        } else {
            $newSizes[] = array('size' => $size['size'], 'quantity' => $size['quantity']);
        }
    }
    $sizeString = sizesToString($newSizes);
    $db->query("UPDATE products SET sizes = '{$sizeString}' WHERE id = '{$item_id}'");
}
    
    
// Update cart
$db->query("UPDATE cart SET paid = 1 WHERE id = '{$cart_id}'");
$db->query("INSERT INTO transactions (charge_id, cart_id, full_name, email, street, street2, city, state, zip_code, country, sub_total, tax, grand_total, description, txn_type) 
VALUES ('$charge->id', '$cart_id', '$full_name', '$email', '$street', '$street2', '$city', '$state', '$zip_code', '$country', '$sub_total', '$tax', '$grand_total', '$description', '$charge->object')");

$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? '.'.$_SERVER['HTTP_HOST'] : false;
setcookie(CART_COOKIE, '', 1, "/", $domain, false);
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';
?>
    <h1 class="text-center text-success">Thank You!</h1>
    <p> Your card has been successfully charged <?= money($grand_total); ?>. You have been emailed a reciept. Please check your spam folder if it is not in your inbox. Additionally you can print this page as a receipt.</p>
    <p>Your receipt number is: <strong><?= $cart_id; ?></strong></p>
    <p>Your order will be shipped to the address below.</p>
    <address>
        <?= $full_name; ?><br>
        <?= $street; ?><br>
        <?= (($street2 != '') ? $street2.'<br>' : ''); ?>
        <?= $city.', '.$state.' '.$zip_code; ?><br>
        <?= $country; ?><br>
    </address>
<?php  
include 'includes/footer.php';
} catch(\Stripe\Error\Card $e) {
    // The card has been declined
    echo $e;
}

?>﻿