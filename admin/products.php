<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
if (!is_loged_in()) {
	login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';

//delete product
if (isset($_GET['delete'])) {
	$id = $_GET['delete'];
	$db->query("UPDATE products SET deleted = 1 WHERE id = '$id' ");
	header('Location: products.php');
}


$dbpath = '';
if (isset($_GET['add']) || isset($_GET['edit'])) {
$brandQuery  = $db->query("SELECT * FROM brand ORDER BY brand");
$parentQuery = $db->query("SELECT * FROM categories WHERE parent=0 ORDER BY category");
$title 		 = ((isset($_POST['title']) && $_POST['title']!='' )?sanitize($_POST['title']):'');
$brand  	 = ((isset($_POST['brand']) && !empty($_POST['brand']) )?sanitize($_POST['brand']):'');
$parent  	 = ((isset($_POST['parent']) && !empty($_POST['parent']) )?sanitize($_POST['parent']):'');
$category  	 = ((isset($_POST['category']) && !empty($_POST['category']) )?sanitize($_POST['category']):'');
$price 		 = ((isset($_POST['price']) && $_POST['price']!='' )?sanitize($_POST['price']):'');
$list_price  = ((isset($_POST['list_price']) && $_POST['list_price']!='' )?sanitize($_POST['list_price']):'');
$description = ((isset($_POST['description']) && $_POST['description']!='' )?sanitize($_POST['description']):'');
$sizes 		 = ((isset($_POST['sizes']) && $_POST['sizes']!='' )?sanitize($_POST['sizes']):'');
$sizes 		 = rtrim($sizes, ',');
$saved_image = '';
if (isset($_GET['edit'])) {
	$edit_id = (int)$_GET['edit'];
	$productResult =  $db->query("SELECT * FROM products WHERE id=$edit_id");
	$product 	   =  mysqli_fetch_assoc($productResult);

	if (isset($_GET['delete_image'])) {
		$image_url = $_SERVER['DOCUMENT_ROOT'].$product['image'];echo $image_url;
		unlink($image_url);
		$db->query("UPDATE products SET image='' WHERE id = '$edit_id'");
		header('Location: products.php?edit='.$edit_id);
	}


	$category 	   =  ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['categories']);
	$title 		   =  ((isset($_POST['title']) && $_POST['title']!='' )?sanitize($_POST['title']):$product['title']);
	$brand 		   =  ((isset($_POST['brand']) && $_POST['brand']!='' )?sanitize($_POST['brand']):$product['brand']);
	$parentQ   	   =  $db->query("SELECT * FROM categories WHERE id='$category'");
	$parentResults =  mysqli_fetch_assoc($parentQ);
	$parent		   =  ((isset($_POST['parent']) && $_POST['parent']!='' )?sanitize($_POST['parent']):$parentResults['parent']);
	$price 		   =  ((isset($_POST['price']) && $_POST['price']!='' )?sanitize($_POST['price']):$product['price']);
	$list_price    =  ((isset($_POST['list_price']) && $_POST['list_price']!='' )?sanitize($_POST['list_price']):$product['list_price']);
	$description   =  ((isset($_POST['description']) && $_POST['description']!='' )?sanitize($_POST['description']):$product['description']);
	$sizes   	   =  ((isset($_POST['sizes']) && $_POST['sizes']!='' )?sanitize($_POST['sizes']):$product['sizes']);
	$sizes 		   = rtrim($sizes, ',');
	$saved_image   = (($product['image'])?$product['image']:'');
	$dbpath		   = $saved_image;
}
 	if (!empty($sizes)) {
		$sizeString = sanitize($sizes);
		$sizeString = rtrim($sizeString, ',');
		$sizesArray = explode(',', $sizeString);
		$sArray 	= array();
		$qArray		= array();

		foreach ($sizesArray as $ss) {
			$s 	    = explode(':', $ss);
			$sArray[] = $s[0];
			$qArray[] = $s[1];
		}

	}else{
		$sizesArray = array();
	} 

if($_POST){
	$errors 	  = array();

	$required = array('title', 'brand', 'price', 'parent', 'child', 'sizes');
	foreach ($required as $field) {
		if ($_POST[$field] == '') {
			$errors[] = 'all fields with astrisk are required';
			break;
		}
	}
	if (!empty($_FILES)) {
		$photo 	    = $_FILES['photo'];
		$name	    = $photo['name'];
		$nameArray  = explode('.', $name);
		$fileName   = $nameArray[0];
		$fileExt    = $nameArray[1];
		$mime	    = explode('/', $photo['type']);
		$mimeType   = $mime[0];
		$mimeExt    = $mime[1];
		$tmpLoc	    = $photo['tmp_name'];
		$fileSize   = $photo['size'];
		$allowed    = array('png','jpg','jpeg','gif');
		$uploadName = md5(microtime()).'.'.$fileExt;
		$uploadPath = BASEURL.'images/products/'.$uploadName;
		$dbpath		= '/ecommerce/images/products/'.$uploadName;
		if ($mimeType != 'image') {
			$errors[] ='The file must be an image';
		}
		if (!in_array($fileExt, $allowed)) {
			$errors[] = 'The file extension must be png, jpg,jpeg or gif';
		}
		if ($fileSize > 25000000) {
			$errors[] = 'File size must be less than 25MB';
		}
		if ($fileExt != $mimeExt && ($mimeType == 'jpeg' && $fileExt != 'jpg')) {
			$errors[] = 'file extension does not match the file';
		}
	}
	if (!empty($errors)) {
		echo display_errors($errors);
	}
	else{
		//upload files and insert to database
		if (!empty($_FILE)) {
			move_uploaded_file($tmpLoc, $uploadPath);
		}
		$insertsql = "INSERT INTO products(`title`,`price`,`list_price`,`brand`,`categories`,`sizes`,`image`,`description`) VALUES('$title','$price','$list_price','$brand','$category','$sizes','$dbpath','$description') ";
		if (isset($_GET['edit'])) {
			$insertsql = "UPDATE products SET title = '$title', price = '$price',list_price='$list_price',brand = '$brand',categories = '$category',sizes = '$sizes',image = '$dbpath',description = '$description' WHERE id = '$edit_id' ";
		}
		$db->query($insertsql);
		header('Location: products.php');
	}
}
?>

<h2 class="text-center"><?= ((isset($_GET['edit']))?'Edit':'Add a'); ?> product</h2><hr>
<form action="products.php?<?= ((isset($_GET['edit']))?'edit='.$edit_id:'add=1'); ?>" method="POST" enctype="multipart/form-data">
	<div class="form-group col-md-3">
		<label for="title">Title*:</label>
		<input type="text" name="title" class="form-control" id="title" value="<?= $title ?>">
	</div>

	<div class="form-group col-md-3">
		<label for="brand">Brand*:</label>
		<select name="brand" id="brand" class="form-control">
			<option value=""<?= (($brand == '')?' selected':'') ?>></option>
			<?php while($b = mysqli_fetch_assoc($brandQuery)) : ?>
				
				<option value="<?= $b['id'] ?>"<?= (($brand == $b['id'])?' selected':'') ?>><?= $b['brand'] ?></option>

			<?php endwhile; ?>
		</select>
	</div>

	<div class="form-group col-md-3">
		<label for="parent">Parent category*:</label> 
		<select name="parent" id="parent" class="form-control">
				<option value="" <?= (($parent=='')?' selected':'') ?> ></option>
			<?php  while($p=mysqli_fetch_assoc($parentQuery)) : ?>
				<option value="<?=$p['id']; ?>" <?=(($parent==$p['id'])?' selected':'') ?>><?=$p['category']?></option>
			<?php endwhile; ?>
		</select>
	</div>

	<div class="form-group col-md-3">
		<label for="child">Child Category*:</label>
		<select name="child" id="child" class="form-control"></select>
	</div>

	<div class="form-group col-md-3">
		<label for="price">Price*:</label>
		<input type="text" name="price" id="price" class="form-control" value="<?= $price; ?>">
	</div>

	<div class="form-group col-md-3">
		<label for="list_price">list_price:</label>
		<input type="text" name="list_price" id="list_price" class="form-control" value="<?= $list_price; ?>">
	</div>

	<div class="form-group col-md-3">
		<label>Quantity & Sizes*:</label>
		<button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity & Sizes</button>
	</div>

	<div class="form-group col-md-3">
		<label for="sizes">Sizes & Qty Preview*:</label>
		<input type="text" name="sizes" id="sizes" class="form-control" value="<?= $sizes; ?>" readonly>
	</div>

	<div class="form-group col-md-6">
	<?php if($saved_image!=''): ?>
		<div class="saved-image">
			<img src="<?= $saved_image;?>" alt="saved image"><br>
			<a href="products.php?delete_image=1&edit=<?= $edit_id; ?>" class="text-warning">Delete image</a>
		</div>
	<?php else: ?>
		<label for="photo">Product photo*:</label>
		<input type="file" name="photo" id="photo" class="form-control" value="<?= ((isset($_POST['photo']))?$_POST['photo']:''); ?>">
	<?php endif; ?>
	</div>

	<div class="form-group col-md-6">
		<label for="description">Description*:</label>
		<textarea name="description" id="description" class="form-control" rows="6"><?= $description ?></textarea>
	</div>
	
	<div class="form-group pull-right">
		<a href="products.php" class="btn btn-default">Cancle</a>
		<input type="submit" value="<?= ((isset($_GET['edit']))?'Edit':'Add a'); ?> product" class="btn btn-success">
	</div>
	<div class="clearfix"></div>
</form>
<!--form end-->
<!--modal-->
<div class="modal fade" id="sizesModal" aria-labelledby="sizesModalLabel" aria-hidden="true" role="dialog" tabindex="-1">
   <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title text-center" id="sizesModalLabel">Size & Quantity</h4>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
            <?php for ($i=1; $i <= 12 ; $i++) : ?>
            	<div class="form-group col-md-4">
            		<label for="size<?= $i ;?>">Size</label>
            		<input type="text" id="size<?= $i ;?>" name="size<?= $i ;?>" value="<?= ((!empty($sArray[$i-1]))?$sArray[$i-1]:'') ?>" class="form-control">
            	</div>

            	<div class="form-group col-md-2">
            		<label for="qty<?= $i ;?>">Quantity</label>
            		<input type="number" name="qty<?= $i ;?>" id="qty<?= $i ;?>" value="<?= ((!empty($qArray[$i-1]))?$qArray[$i-1]:'') ?>" class="form-control" min="0">
            	</div>
            <?php endfor; ?>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="button" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save Changes</button>
          </div>
      </div>
   </div>
</div>

<!--modal-->
<?php
}else{
$sql 	 = "SELECT * FROM products WHERE deleted=0";
$presult = $db->query($sql);

if (isset($_GET['featured'])) {
	$id 	  = $_GET['id'];
	$featured = $_GET['featured'];
	$featuredSql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
	$db->query($featuredSql);
	header('Location: products.php');

}
 ?>

<h2 class="text-center">Products</h2>
<a href="products.php?add=1" class="btn pull-right" id="add-product-btn">Add product</a>
<div class="clearfix"></div>
<hr>

 

<table class="table table-condensed table-striped table-bordered">
	<thead>
		<th></th>
		<th>Product</th>
		<th>Price</th>
		<th>Categories</th>
		<th>Featured</th>
		<th>Sold</th>
	</thead>

	<tbody>
	<?php while($products=mysqli_fetch_assoc($presult)) : 
		$childID  = $products['categories'];
		$catsql   = "SELECT * FROM categories WHERE id = '$childID'";
		$result	  = $db->query($catsql);
		$child 	  = mysqli_fetch_assoc($result);
		$parentID = $child['parent'];
		$psql	  = "SELECT * FROM categories WHERE id= '$parentID'";
		$presults = $db->query($psql);
		$parent   = mysqli_fetch_assoc($presults);
		$category = $parent['category'].'~'.$child['category'];
	?>
		<tr>
			<td>
				<a href="products.php?edit=<?= $products['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
				<a href="products.php?delete=<?= $products['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
			</td>
			<td><?= $products['title'];?></td>
			<td><?=money($products['price']);?></td>
			<td><?= $category;?></td>
			<td>
				<a href="products.php?featured=<?= (($products['featured']==0)?'1':'0'); ?> & id= <?= $products['id']; ?>" class="btn btn-default btn-xs">
					<span class="glyphicon glyphicon-<?= (($products['featured'])?'minus':'plus'); ?>"></span>
				</a>
				&nbsp<?= (($products['featured'] == 1)?'Featured product':''); ?>
			</td>
			<td>0</td>
		</tr>
	<?php endwhile; ?>
	</tbody>
</table>

 <?php } include 'includes/footer.php'; ?>

 <script>
 	jQuery('document').ready(function () {
 		get_child_options('<?=$category?>');
 	});
 </script>