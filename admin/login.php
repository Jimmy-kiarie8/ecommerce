<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
include 'includes/head.php';
$email     = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email 	   = rtrim($email);
$password  = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password  = rtrim($password);
$hashed	   = password_hash($password, PASSWORD_DEFAULT);
$errors    = array();
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
				 if (empty($_POST['email']) || empty($_POST['password'])) {
				 	$errors[] = 'please enter all fields.';
				 }

				 //validate email
				 if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				 	$errors[] = 'You must enter a valid email';
				 }

				 //password length
				 if (strlen($password) < 6) {
				 	$errors[] = 'Password must have atleast 6 characters';
				 }


				 //check if email exists
				 $query = $db->query("SELECT * FROM users WHERE email = '$email' ");
				 $user = mysqli_fetch_assoc($query);
				 $usercount    = mysqli_num_rows($query);echo $usercount;
				 
				 if ($usercount < 1) {
				 	$errors[] = 'User doesn\'t exist in our database';
				 }

				 //verify password
				 if (!password_verify($password, $user['password'])) {
				 	$errors[] = 'Wrong password';
				 }



				 //check for errors
				 if (!empty($errors)) {
				 	echo display_errors($errors);
				 }else{
				 	$user_id = $user['id'];
				 	login($user_id);
				 }
			}

		 ?>


	</div>
	<h2 class="text-center">Login</h2>
	<form action="login.php" method="post">
		<div class="form-group">
			<label for="email">Email</label>
			<input type="email" id="email" name="email" class="form-control" value="<?= $email; ?>">
		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="form-control" value="<?= $password; ?>">
		</div>

		<div class="form-group">
			<input type="submit" value="login" class="btn btn-primary">
		</div>
	</form>
	<p class="text-right btn"><a href="/ecommerce/index.php" alt="home">Visit Site</a></p>
</div>

<?php include 'includes/footer.php'; ?>