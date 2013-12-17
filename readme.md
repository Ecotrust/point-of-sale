# Simple interface to the Stripe API
## Setup:

 1. copy `assets/inc/config-sample.php` to `assets/inc/config.php`
 2. edit `config.php` and include your Stripe test or live secret API key
 3. edit `assets/js/global.js` and include your Stripe test or live publishable API key
 4. $ git submodule init
 5. $ git submodule update

Note that this saves Stripe customers on successful charges but does not currently test to see if that customer already exists. Stripe will email those customers a receipt if the Stripe dashboard is set up to do so.
