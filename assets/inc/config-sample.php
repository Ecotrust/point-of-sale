<?php

$dir = getcwd(); // __dir__ not working correctly locally.
require $dir.'/assets/lib/stripe-php/lib/Stripe.php';

// will send a manual reciept to this address
define('EMAIL_RECIPIENT', 'foo@bar.com');
define('API_MODE', 'test');

if ( API_MODE == 'test' ) { 
	Stripe::setApiKey("STRIPE-SECRET-TEST-API-KEY-HERE");
} else {
	Stripe::setApiKey("STRIPE-SECRET-LIVE-API-KEY-HERE");
}

?>
