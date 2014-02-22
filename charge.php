<?php include 'assets/inc/header.php'; ?>
<?php
/* 
 * PROCESS THE FORM, SEND TO STRIPE
 */

if ($_POST) {

	try {
		if (!isset($_POST['stripeToken'])){
			throw new Exception("The Stripe Token was not generated correctly");
		}
		$amount = $_POST['amount'] * 100; // Stripe wants everything in cents
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$org = $_POST['org'];
		$email = $_POST['email'];
		$date = $_POST['date'];
		$internal_notes = $_POST['internal_notes'];
		$sforceLink = $_POST['sforceLink'];

		// Create a Customer
		$customer = Stripe_Customer::create(
			array(
				"card" => $_POST['stripeToken'],
				"description" => $fname . " " . $lname,
				"email" => $email,
				"metadata" => array(
					"First Name"	=> $fname,
					"Last Name"		=> $lname,
					"Organization"	=> $org, 
					"Email"			=> $email,
					"Date"			=> $date,
					"Internal Notes" => $internal_notes,
					"SalesForce URL" => $sforceLink
				)
			)
		);

		// @TODO Save customer to DB	

		$charge = Stripe_Charge::create(
			array(
				"amount" => $amount,
				"currency" => "usd",
				"description" => "",
				"customer" => $customer->id,
				"metadata" => array(
					"First Name"	=> $fname,
					"Last Name"		=> $lname,
					"Description"	=> $date, 
					"Organization"	=> $org, 
					"Email"			=> $email,
					"Date"			=> $date,
					"Internal Notes" => $internal_notes,
					"SalesForce URL" => $sforceLink
				)
			)
		);
		$success = "<h2>Success!</h2>";
		$success .= '<div class="success">You successfully charged <b>$' .$_POST['amount'] . '</b> to ';
		$success .= $customer['metadata']['First Name'] . '\'s card ending in <b>' . $charge['card']['last4'] . '</b></div>';

		//print_r($customer);
		//print_r($charge);

		$link = "http://" . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']) . '/';

		/*
		 * EMAIL TIME!
		 */ 

		// Let's send HTML
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



		// The message
		$message = '
			<style> 
				table {border-collapse: collapse;    border-spacing: 0;}
				th { text-align: left; } 
				th, td { border: 1px solid #ccc; padding: 10px; } 
				.success { font-size: 1.5em; }
				.links { padding: 40px 0; }
				.links a { display: inline-block; margin-bottom: 10px; width: auto; padding: 5px 10px; background-color: #eee; }
			</style>
		<div class="payment-success">
			' . $success . '
		</div>
		<h3>Customer Details</h3>
		<table>
			<tr>
				<th>Name</th>
				<td> ' .$customer["metadata"]["First Name"] . $customer["metadata"]["Last Name"] . '</td>
			</tr>
			<tr>
				<th>Organization</th>
				<td> ' .$customer["metadata"]["Organization"] . '</td>
			</tr>
			<tr>
				<th>Email</th>
				<td><a class="email" href="mailto: ' .$customer["email"] . '"> ' .$customer["email"] . '</a></td>
			</tr>
			<tr>
				<th>Event Date</th>
				<td> ' .$customer["metadata"]["Date"] . '</td>
			</tr>
			<tr>
				<th>SalesForce Link</th>
				<td><a class="url" href=" ' .$customer["metadata"]["SalesForce URL"] . '">Salesforce Link</a></td>
			</tr>
		';

		if ( isset( $customer["metadata"]["address1"]) ):
			$message .= '
				<tr>
					<th>Address</th>
					<td>
						<div class="street-address"> ' .$customer["metadata"]["address1"] . '</div>
						<span class="locality"> ' .$customer["metadata"]["city"] . '</span> , 
						<span class="region"> ' .$customer["metadata"]["state"] . '</span> , 
						<span class="postal-code"> ' .$customer["metadata"]["zip"] . '</span>
					</td>
				</tr>
			';
		endif;

		$message .= '
			<tr>
				<th>Notes:</th>
				<td>
					 ' .stripslashes($customer["metadata"]["Internal Notes"]) . '
				</td>
			</tr>
		</table>

		<div class="links">
			<div><a href="' . $link . 'charges.php">View All Charges</a></div>
			<div><a href="https://manage.stripe.com/' . API_MODE .'/payments/' . $charge["id"]	. '">View charge on Stripe</a></div>
		</div>
		';

			// Send
			mail(EMAIL_RECIPIENT, 'Stripe Payment Success', $message, $headers);

	}
	catch (Exception $e) {
		$error = "<h2>Uh Oh!</h2>";
		$error .= "<pre>" . $e->getMessage() . "</pre>";
	}
}
?>

		<div class="row">

			<header class="clearfix"> 
				<h1>Ecotrust Point Of Sale</h1> 

				<nav class="pull-right">
					<a href="index.php" class="btn btn-primary">Enter A Charge</a>
					<a href="charges.php" class="btn btn-default">View Previous Charges</a>
				</nav>
			</header>

			<!-- to display errors returned by createToken -->
			<?php if(isset($error)): ?>
				<div class="payment-errors"><?= $error ?></div>
			<?php endif; ?>

			<?php if(isset($success)): ?>
				<div class="payment-success">
					<?= $success ?>
				</div>
				<h3>Customer Details</h3>
				<div id="hcard-<?php echo $customer['metadata']['First Name']; ?>-<?php echo $customer['Last Name']; ?>" class="vcard">
					<div class="fn n">
						<span class="given-name"><?php echo $customer['metadata']['First Name']; ?></span>
						<span class="family-name"><?php echo $customer['metadata']['Last Name']; ?></span>
					</div>
					<div class="org"><?php echo $customer['metadata']['Organization']; ?></div>
					<div><a class="email" href="mailto:<?php echo $customer['email']; ?>"><?php echo $customer['email']; ?></a></div>
					<div><a class="url" href="<?php echo $customer['metadata']['SalesForce URL']; ?>">Salesforce Link</a></div>
					<?php if ( isset( $customer['metadata']['address1']) ): ?>
						<div class="adr">
							<div class="street-address"><?php echo $customer['metadata']['address1']; ?></div>
							<span class="locality"><?php echo $customer['metadata']['city']; ?></span> , 
							<span class="region"><?php echo $customer['metadata']['state']; ?></span> , 
							<span class="postal-code"><?php echo $customer['metadata']['zip']; ?></span>
						</div>
					<?php endif; ?>
					<div class="customer-interal-notes">
						<?php echo stripslashes($customer['metadata']['Internal Notes']); ?>
					</div>
				</div>
				<br>
				<br>
				<a href="index.php" class="">Enter A New Charge</a> <br>
				<a href="charges.php" class="">View All Charges</a>
				<div><a href="https://manage.stripe.com/<?php echo API_MODE ; ?>/payments/<?php echo $charge["id"]; ?>">View charge on Stripe</a></div>
			<?php endif; ?>

		</div> <!-- /.row -->

<?php include 'assets/inc/footer.php'; ?>

