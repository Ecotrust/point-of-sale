# Simple interface to the Stripe API
## Setup:

 * copy `assets/inc/config-sample.php` to `assets/inc/config.php`
 * edit `config.php` and include your Stripe test or live secret API key
 * edit `assets/js/global.js` and include your Stripe test or live publishable API key

Note that this saves Stripe customers on successful charges but does not currently test to see if that customer already exists. Stripe will email those customers a receipt if the Stripe dashboard is set up to do so.
