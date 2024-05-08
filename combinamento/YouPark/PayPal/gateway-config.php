<?php 
// PayPal configuration
define('PAYPAL_ID', 'goretti@business.com'); //Business Email or sandbox email for test 
$mode='test'; // test or live 
define('PAYPAL_RETURN_URL', 'https://hog-inspired-stork.ngrok-free.app/Scabello5CII/paypal-integration-php-kit-main/paypal-integration-php-kit-main/success.php');
define('PAYPAL_CANCEL_URL', 'https://hog-inspired-stork.ngrok-free.app/Scabello5CII/paypal-integration-php-kit-main/paypal-integration-php-kit-main/cancel.php');
define('PAYPAL_NOTIFY_URL', 'https://hog-inspired-stork.ngrok-free.app/Scabello5CII/paypal-integration-php-kit-main/paypal-integration-php-kit-main/ipn.php');
define('PAYPAL_CURRENCY', 'EUR');
// Change not required
if($mode=='live')
{
define('PAYPAL_URL','https://www.paypal.com/cgi-bin/webscr');
}
else
{
define('PAYPAL_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');	
}

?>
<!-- Techno Smarter - https://technosmarter.com/php/tutorial -->