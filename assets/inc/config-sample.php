<?php

$dir = getcwd(); // __dir__ not working correctly locally.
require $dir.'/assets/lib/stripe-php/lib/Stripe.php';
Stripe::setApiKey("STRIPE-SECRET-API-KEY-HERE");

?>
