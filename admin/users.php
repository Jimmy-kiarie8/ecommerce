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
// delete
if (isset($_GET['delete'])) {
	$delete_id = sanitize($_GET['delete']);
	$db->query("DELETE FROM users WHERE id = '$delete_id' ");
	$_SESSION['success_flash'] = "User was successively deleted";
	header('Location: users.php');
}

if (isset($_GET['add']) || isset($_GET['edit'])) {
	$name = ((isset($_POST['name']))?$_POST['name']:'');
	$email = ((isset($_POST['email']))?$_POST['email']:'');
	$password = ((isset($_POST['password']))?$_POST['password']:'');
	$confirm = ((isset($_POST['confirm']))?$_POST['confirm']:'');
	$permissions = ((isset($_POST['permissions']))?$_POST['permissions']:'');
	$errors 	 = array();

	// edit
	if (isset($_GET['edit'])) {
		$edit_id 	 = $_GET['edit'];
		$equery 	 =  $db->query("SELECT * FROM users WHERE id = '$edit_id'");
		$eresults	 = mysqli_fetch_assoc($equery);
		$name 		 = $eresults['full_name'];
		$email 		 = $eresults['email'];
		$permissions = $eresults['permissions'];
		// $esql     	 = $db->query("SELECT * FROM brand WHERE id ='$edit_id' ");
		// $eresults  	 = mysqli_fetch_assoc($edit_result);
	}

	if ($_POST) {
		
		// 	$required = array('name', 'email', 'permissions');
		// 	foreach ($required as $f) {
		// 		if (empty($_POST[$f])) {
		// 			$errors[] = 'You must enter all fields';
		// 			break;
		// 		}
		// 	}
		// 	//email
		// 	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// 		$errors[] = 'Invalid email address';
		// 	}

		// 	if (!empty($errors)) {
		// 		echo display_errors($errors);
		// 	}
		// 	else{
		// 		//add new users
		// 		$hashed = password_hash($password, PASSWORD_DEFAULT);
				
		// 			$db->query("UPDATE users SET full_name = '$name', email ='$email', permissions ='$permissions' WHERE id = '$edit_id'");
		// 		$_SESSION['success_flash'] = 'User has been successively added';
		// 		header('Location: users.php');
		// 	}
		// }
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
				$db->query("INSERT INTO users(`full_name`, `email`, `password`, `permissions`)VALUES('$name', '$email', '$hashed', '$permissions')");
				$_SESSION['success_flash'] = 'User has been successively added';
				header('Location: users.php');
			}
	}

?>
<h2 class="text-center"><?= ((isset($_GET['edit']))?'Edit':'Add') ?> user</h2><hr>
<form action="users.php?<?= ((isset($_GET['edit']))?'edit='.$edit_id:'add=1'); ?>" method="post">
	<?php
	if (isset($_POST[''])) {
		# code...
	}
		$name 	= '';
		$email 	= '';
		if (isset($_GET['edit'])) {
			$name  = $eresults['full_name'];
			$email = $eresults['email'];
		}else{
			if (isset($_POST)) {
				$name = sanitize($_POST['full_name']);
				$email = sanitize($_POST['email']);
			}
		}
	?>
	<div class="form-group col-md-6">
		<label for="name">Full name</label>
		<input type="text" name="name" id="name" class="form-control" value="<?= $name; ?>">
	</div>

	<div class="form-group col-md-6">
		<label for="email">Email</label>
		<input type="text" name="email" id="email" class="form-control" value="<?= $email; ?>">
	</div>
	<?php if (isset($_GET['add'])): ?>	
		<div class="form-group col-md-6">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="form-control" value="<?= $password; ?>">
		</div>
	    <div class="form-group col-md-6">
			<label for="confirm">Confirm password</label>
			<input type="password" name="confirm" id="confirm" class="form-control" value="<?= $confirm; ?>">
		</div>
	<?php endif ?>
	<div class="form-group col-md-6">
		<label for="permissions">Permissions</label>
		<select name="permissions" id="permissions" name="permissions">
			<option value=""<?= (($permissions == '')?' select':'') ?>></option>
			<option value="editor"<?= (($permissions == 'editor')?' select':'') ?>>Editor</option>
			<option value="admin,editor"<?= (($permissions == 'admin,editor')?' select':'') ?>>Admin</option>
		</select>
	</div>

	<div class="form-group col-md-6 text-right">
		<a href="users.php" class="btn btn-default" id="add">Cancel</a>
		<input type="submit" value="<?= ((isset($_GET['edit']))?'Edit user':'Add user') ?>" class="btn btn-primary">
	</div>
</form>

<?php 
}else{

$userQuery = $db->query("SELECT *FROM users");
?>
<h2 class="text-center">Users Page</h2>
<a href="users.php?add=1" class="btn btn-success pull-right" id="add"><i class="glyphicon glyphicon-user"></i>Add new user</a>
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
					<a href="users.php?delete=<?= $user['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
					<a href="users.php?edit=<?= $user['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
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