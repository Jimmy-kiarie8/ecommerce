<?php
require_once '../core/init.php';
if (!is_loged_in()) {
	header('Location: login.php');
}
include 'includes/head.php';
include 'includes/navigation.php';
//session_destroy();
?>
<h4 class="text-center">Administrator Home</h4>
<?php 
include 'includes/footer.php';
?>