<?php
require_once '../core/init.php';
if (!is_loged_in()) {
	login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';

$sql     = "SELECT * FROM brand ORDER BY brand";
$results = $db->query($sql);

$errors =array();

//Edit brand
if (isset($_GET['edit']) && !empty($_GET['edit'])) {
	$edit_id 	 = (int)$_GET['edit'];
	$edit_id 	 = sanitize($edit_id);
	$sql2     	 = "SELECT * FROM brand WHERE id ='$edit_id' ";
	$edit_result = $db->query($sql2);
	$eBrand  	 = mysqli_fetch_assoc($edit_result);
}
//Delete brand

if(isset($_GET['delete']) && !empty($_GET['delete'])) {
	$delete_id = (int)$_GET['delete'];
	$delete_id = sanitize($delete_id);
	$sql 	   = "DELETE FROM brand WHERE id='$delete_id'";
	$db->query($sql);
	// header("Location: brands.php");
	http_redirect();
}


//if submited
if (isset($_POST['add_submit'])) {
	$brand = sanitize($_POST['brand']);
	//check if empty
	if ($_POST['brand'] == '') {
		$errors[].="Please enter a brand name!";
	}
	//check if brand exists in database
	$sql 	= "SELECT * FROM brand WHERE brand='$brand'";
	if (isset($_GET['edit'])) {
		$sql = "SELECT * FROM brand WHERE brand='$brand' AND id != '$edit_id'";
	}
	$result  = $db->query($sql);
	$count   = mysqli_num_rows($result);

	if ($count > 0) {
		$errors[].=$brand.' already exists! Please choose another brand...';
	}
	//display error
	if (!empty($errors)) {
		echo display_errors($errors);
	}else{
		//add brand to database
		$sql = "INSERT INTO brand(brand) VALUES('$brand')";
		if (isset($_GET['edit'])) {
			$sql = "UPDATE brand SET brand = '$brand' WHERE id = '$edit_id'";
		}
		$db->query($sql);
		header("Location: brands.php");
	}
}
?>
<h2 class="text-center"r>Brand Home</h2><hr>
<!--brand form-->
<div class="text-center">
	<form action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post" class="form-inline">
		<div class="form-group">
		<?php
			$brand_value ='';
			if (isset($_GET['edit'])) {
				$brand_value = $eBrand['brand'];
			}else{
				if (isset($_POST['brand'])) {
					$brand_value = sanitize($_POST['brand']);
				}
			}

		 ?>
			<label for="brand"><?= ((isset($_GET['edit']))?'Edit':'Add a'); ?> brand</label>
			<input type="text" name="brand" value="<?= $brand_value ?>" id="brand" class="form-control">
			<?php if(isset($_GET['edit'])): ?>
				<a href="brands.php" class="btn btn-default">Cancle</a>
			<?php endif; ?>
			<input type="submit" name="add_submit" value="<?= ((isset($_GET['edit']))?'edit':'Add a'); ?> brand" class="btn btn-primary">
		</div>
	</form>
</div><hr>
<!--brand form-->


<table id="table" class="table table-bordered table-stripped table-condensed">
	<thead>
		<th></th>
		<th>Brand</th>
		<th></th>
	</thead>

	<tbody>
	  <?php while($brand = mysqli_fetch_assoc($results)) : ?>
		<tr>
			<td><a href="brands.php?edit=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
			<td><?= $brand['brand']; ?></td>
			<td><a href="brands.php?delete=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
		</tr>
	  <?php endwhile ?>
	</tbody>
</table>



<?php 
include 'includes/footer.php';
?>