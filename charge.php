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
		$internal_notes = $_POST['internal_notes'];
		$sforceLink = $_POST['sforceLink'];
		$description = $_POST['description'];

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
				"description" => $description,
				"customer" => $customer->id,
				"metadata" => array(
					"First Name"	=> $fname,
					"Last Name"		=> $lname,
					"Organization"	=> $org, 
					"Email"			=> $email,
					"Internal Notes" => $internal_notes,
					"SalesForce URL" => $sforceLink
				)
			)
		);
		$success = "<h2>Success!</h2>";
		$success .= 'You successfully charged <b>$' .$_POST['amount'] . '</b> to ';
		$success .= $customer['metadata']['First Name'] . '\'s card ending in <b>' . $charge['card']['last4'] . '</b>';
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
			<?php endif; ?>

		</div> <!-- /.row -->

<?php include 'assets/inc/footer.php'; ?>

