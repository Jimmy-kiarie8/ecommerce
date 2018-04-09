<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
if (!is_loged_in()) {
	login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
$sql 	  = "SELECT * FROM categories WHERE parent=0";
$result   = $db->query($sql);
$errors   = array();
$category = '';
$post_parent   = '';
//edit
if (isset($_GET['edit']) && !empty($_GET['edit'])) {
	$edit_id  = (int)$_GET['edit'];
	$edit_id  = sanitize($edit_id);
	$esql	  = "SELECT * FROM categories WHERE id='$edit_id' ";
	$Eresult  = $db->query($esql);
	$Ecategory = mysqli_fetch_assoc($Eresult);

}

//delete 
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
	$delete_id = (int)$_GET['delete'];
	$delete_id = sanitize($delete_id);
	$sql 	   = "SELECT * FROM categories WHERE id='$delete_id' ";
	$result	   = $db->query($sql);
	$category  = mysqli_fetch_assoc($result);
	if ($category['parent'] == 0) {
		$sql = "DELETE FROM categories WHERE parent = '$delete_id' ";
		$db->query($sql);
	}
	$dsql	   = "DELETE FROM categories WHERE id='$delete_id' ";
	$db->query($dsql);
	header('Location: categories.php');
}


//process form
if (isset($_POST) && !empty($_POST)) {
	$post_parent   = sanitize($_POST['parent']);
	$category 	   = sanitize($_POST['category']);
	$sqlform  	   = "SELECT * FROM categories WHERE category='$category' AND parent='$post_parent'";
	if (isset($_GET['edit'])) {
		$id 	   = $Ecategory['id'];
		$sqlform   = "SELECT * FROM categories WHERE category='$category' AND parent='$post_parent' AND id !='$id'";	
	}
	$fresult  = $db->query($sqlform);
	$count	  = mysqli_num_rows($fresult);

	//if category is brank
	if ($category == '') {
		$errors[] .= 'Please enter a Category.';
	}

	//if Category exists
	if ($count > 0) {
		$errors[] .= $category. ' Already exist please choose another category';
	}

	//Display error or update database
	if (!empty($errors)) {
		//display errors
		$display = display_errors($errors);?>

<script>
	jQuery('document').ready(function(){
		jQuery('#errors').html('<?= $display?>');
	});
</script>


	<?php 
		}else{
			//update&insert database
			$updatesql = "INSERT INTO categories(category, parent) VALUES('$category', '$post_parent') ";
			if (isset($_GET['edit'])) {
				$updatesql = "UPDATE categories SET category = '$category', parent = '$post_parent' WHERE id = '$edit_id' ";
				header('Location: categories.php');
			}
			$db->query($updatesql);
			header('Location: categories.php');
		}
}

$parent_value   = 0;
$category_value = '';
if (isset($_GET['edit'])) {
	$category_value = $Ecategory['category'];
	$parent_value	= $Ecategory['parent'];
}else {
	if (isset($_POST['edit'])) {
			$category_value = $category;
			$parent_value	= $post_parent;
		}	
}

 ?>
<h2 class="text-center">Categories</h2><hr>
<div class="row">
<!--Form-->
	<div class="col-md-6">

		<form id="catform" action="categories.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post" class="form">
			<legend><?=((isset($_GET['edit']))?'Edit':'Add');  ?> Category</legend>
			<div id="errors"></div>
			<div class="form-group">
				<label for="parent">Parent</label>
				<select name="parent"  id="parent" class="form-control">
					<option value="0"<?= (($parent_value == 0)?' selected="selected"':''); ?>>Parent</option>
					<?php while($parent=mysqli_fetch_assoc($result)) : ?>
						<option value="<?=$parent['id'];?>"<?= (($parent_value == $parent['id'])?' selected=selected':''); ?>><?=$parent['category'];?></option>
					<?php endwhile; ?>
				</select>
			</div>

			<div class="form-group">
				<label for="category">Category</label>
				<input type="text" name="category" class="form-control" id="category" value="<?= $category_value; ?>">
			</div>

			<div class="form-group">
				<input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add a'); ?> category" class="btn btn-success btn-lg">
			</div>
		</form>
	</div>
<!--Form End-->


<!--Categories Table-->
	<div class="col-md-6">
		<table class="table table-bordered">
			<thead>
				<th>Category</th>
				<th>Parent</th>
				<th></th>
			</thead>
		
			<tbody>
			<?php 
				$sql 	= "SELECT * FROM categories WHERE parent=0";
				$result = $db->query($sql);
				while($parent=mysqli_fetch_assoc($result)) : 
				$parent_id = (int)$parent['id'];
				$sql2  	   = "SELECT * FROM categories  WHERE parent='$parent_id'";
				$Cresult    = $db->query($sql2);
			?>
				<tr class="bg">
					<td><?= $parent['category']; ?></td>
					<td>parent</td>
					<td>
						<a href="categories.php?edit=<?= $parent['id'];?>" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
						<a href="categories.php?delete=<?= $parent['id'];?>" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
					</td>
				</tr>
			<?php while($child=mysqli_fetch_assoc($Cresult)) : ?>
				<tr class="bg-info">
					<td><?= $child['category']; ?></td>
					<td><?= $parent['category']; ?></td>
					<td>
						<a href="categories.php?edit=<?= $child['id'];?>" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
						<a href="categories.php?delete=<?= $child['id'];?>" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
					</td>
				</tr>
			<?php endwhile; ?>

			<?php endwhile; ?>
			</tbody>
		</table>
	</div>
<!--Categories Table End-->
</div>

 <?php include 'includes/footer.php'; ?>