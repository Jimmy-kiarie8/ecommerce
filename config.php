<?php 
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/ecommerce/');
define('CART_COOKIE', 'SBw34qwUy76hdf4q');
define('CART_COOKIE_EXPIRE', time() + (86400 *30));
define('TAXRATE', 0.087);
define('CURRENCY', 'usd');
define('CHECKOUTMODE', 'TEST'); // change to LIVE when done

// if (CHECKOUTMODE == 'TEST') {
	define('STRIPE_PRIVATE', 'sk_test_v3d85RfJF0kFxNmIcHqOgDHT');
	define('STRIPE_PUBLIC', 'pk_test_Z1SSVcCKm1a0NsjwhGKAAWkV');
	
	
// }

// if (CHECKOUTMODE == 'LIVE') {
// 	define('STRIPE_PRIVATE', 'sk_test_v3d85RfJF0kFxNmIcHqOgDHT');
// 	define('STRIPE_PUBLIC', 'pk_test_Z1SSVcCKm1a0NsjwhGKAAWkV');
	
	
// }


?>