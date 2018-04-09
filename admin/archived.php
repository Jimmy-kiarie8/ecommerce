<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
if (!is_loged_in()) {
	login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';

	$sql1		 = "SELECT * FROM products WHERE deleted = 1";
	$sql1_result = $db->query($sql1); 
if (isset($_GET['refreshed'])) {
	$refresh_id  = (int)$_GET['refreshed'];
	$refresh_id  = sanitize($_GET['refreshed']);
	$rSql	 	 = $db->query("UPDATE products SET deleted = 0 WHERE id = '$refresh_id'");
	$sql	  	 = "SELECT * FROM products WHERE id = '$refresh_id'";
	$sql_result  = $db->query($sql);
	$earchived = mysqli_fetch_assoc($sql1_result);
	header('Location: archived.php');
}
?>

<table class="table table-bordered table-stripped table-condesed">
	<thead>
		<th></th>
		<th>Products</th>
		<th>Price</th>
		<th>Category</th>
		<th>Featured</th>
	</thead>

	<tbody>		
		 	<?php while($earchived = mysqli_fetch_assoc($sql1_result)): echo $earchived['title'];?>
			<tr>
				<td><a href="archived.php?refreshed=<?=$earchived['id'];?>" class="glyphicon glyphicon-refresh btn"></a></td>
				<td><?= $earchived['title']?></td>
				<td><?= $earchived['price']?></td>
				<td><?= $earchived['categories']?></td>
				<td><?= $earchived['featured']?></td>
			</tr>
			<?php endwhile; ?>
	</tbody>
</table>



<?php include 'includes/footer.php'; ?>