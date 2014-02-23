<?php

// Find the Stripe API Library. Feel free to hard code this.
$dir = getcwd(); // __dir__ not working correctly locally.
require $dir.'/assets/lib/stripe-php/lib/Stripe.php';

// Will send a manual reciept to this address
define('EMAIL_RECIPIENT', 'foo@bar.com');

// Define your current working mode ('test' or 'live')
define('API_MODE', 'test');

// Insert all (4) of your API keys here. Previous constant will allow switching.
// Keys are available at https://manage.stripe.com/account/apikeys
if ( API_MODE == 'test' ) { 
	
	// Test Secret Key:
	Stripe::setApiKey("sk_test_SECRET---TEST---KEY");

	// Test Publishable Key:	
	define('STRIPE_PUBLISHABLE_KEY', 'pk_test_PUBLISHABLE---TEST---KEY' );

} else {
	
	// Live Secret Key:	
	Stripe::setApiKey("sk_live_SECRET---LIVE---KEY");

	// Live Publishable Key:
	define('STRIPE_PUBLISHABLE_KEY', 'pk_live_PUBLISHABLE---LIVE---KEY' );
}

?>
