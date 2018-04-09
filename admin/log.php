<?php 
$_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
include 'includes/head.php';

if ($_POST) {
	$email     = sanitize($_POST['email']);
	$email     = rtrim($email);
	$password  = sanitize($_POST['password']);
	$password  = rtrim($password);
	//CHECK FOR ERRORS
	if (empty($email)) {
		# code...
	}
}


 ?>
<style>
body{
	background: #f0f0f0;
}
form{
	width: 50%;
	margin: auto;
	background: #fff;
	padding: 30px;
}
</style>
<form action="log.php" method="post">
	<h2 class="text-center">Login</h2>
	<div class="form-group">
		<label for="email">Email:</label>
		<input type="email" name="email" class="form-control" placeholder="Enter your email">
	</div>

	<div class="form-group">
		<label for="password">Password:</label>
		<input type="password" name="password" class="form-control" placeholder="Enter your password">
	</div>

	<div class="form-group">
		<input type="submit" name="submit" value="Login" class="form-control btn-primary">
	</div>
</form>






 <?php include 'includes/footer.php' ?>