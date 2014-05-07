# Stripe Simple Point Of Sale 
A Point of Sale style admin interface to the Stripe API

## Setup:

 1. Copy `assets/inc/config-sample.php` to `assets/inc/config.php`
 2. Edit `config.php` to include your Stripe API keys and set live/test mode
 3. Edit `config.php` to include your admin's email address
 4. Run `$ git submodule init` on the command line to get the included Stripe PHP Libary
 5. and then run `$ git submodule update` to get the latest version

Note that this saves Stripe customers on successful charges but does not currently test to see if that customer already exists. Stripe will email those customers a receipt if the Stripe dashboard is set up to do so.
