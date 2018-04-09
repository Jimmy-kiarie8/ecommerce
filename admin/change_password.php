<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
include 'includes/head.php';
$hashed		   = $user_data['password'];
$old_password  = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password  = rtrim($old_password);
$password  = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password  = rtrim($password);
$new_hashed = password_hash($password, PASSWORD_DEFAULT);
$confirm  = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm  = rtrim($confirm);	
$errors    = array();
$user_id  = $user_data['id'];
?>
<style>
	body{
		background-image: url("/ecommerce/images/land.jpg");
		background-size: 100vw 100vh;
		background-attachment: fixed;
	}
</style>


<div id="login-form">
	<div>
		<?php 

			if ($_POST) {
				//form validation
				 if (empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])) {
				 	$errors[] = 'please enter all fields.';
				 }

				 //password length
				 if (strlen($password) < 6) {
				 	$errors[] = 'Password must have atleast 6 characters';
				 }

				 if ($password != $confirm) {
				 		$errors[] = 'New Password and confirm don\'t match';
				 	}	

				 //verify password
				 if (!password_verify($old_password, $hashed)) {
				 	$errors[] = 'Wrong old password';
				 }



				 //check for errors
				 if (!empty($errors)) {
				 	echo display_errors($errors);
				 }else{
				 	//change password
				 	$db->query("UPDATE users SET password = '$new_hashed' WHERE id='$user_id' ");
				 	$_SESSION['success_flash'] = 'Your password has been updated';
				 	header('Location: index.php');
				 }
			}

		 ?>


	</div>
	<h2 class="text-center">Change password</h2>
	<form action="change_password.php" method="post">
		<div class="form-group">
			<label for="old_password">Old password</label>
			<input type="password" id="old_password" name="old_password" class="form-control" value="<?= $old_password; ?>">
		</div>

		<div class="form-group">
			<label for="password">New Password</label>
			<input type="password" name="password" id="password" class="form-control" value="<?= $password; ?>">
		</div>

		<div class="form-group">
			<label for="confirm">Confirm new password</label>
			<input type="password" name="confirm" id="confirm" class="form-control" value="<?= $confirm; ?>">
		</div>

		<div class="form-group">
			<input type="submit" value="login" class="btn btn-primary">
		</div>

		<div class="form-group">
			<a href="index.php" class="btn" style="color: #fff; float: right;">Cancel</a>
		</div>
	</form>
	<p class="text-right btn"><a href="/ecommerce/index.php" alt="home">Visit Site</a></p>
</div>

<?php include 'includes/footer.php'; ?>