# Simple Point Of Sale type admin interface to the Stripe API
## Setup:

 1. copy `assets/inc/config-sample.php` to `assets/inc/config.php`
 2. edit `config.php` and include your Stripe API keys
 3. edit `config.php` and include your admin's email address
 4. $ git submodule init
 5. $ git submodule update

Note that this saves Stripe customers on successful charges but does not currently test to see if that customer already exists. Stripe will email those customers a receipt if the Stripe dashboard is set up to do so.
