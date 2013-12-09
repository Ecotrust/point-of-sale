<?php include 'assets/inc/header.php'; ?>
<?php
	//TODO add time range
	//TODO pagination
	//TODO disputed charges 
?>

<div class="row">
	<header class="clearfix"> 
		<h1>Ecotrust Point Of Sale</h1> 

		<nav class="pull-right">
			<a href="index.php" class="btn btn-default">Enter A Charge</a>
			<a href="charges.php" class="btn btn-primary">View Previous Charges</a>
		</nav>
	</header>

<?php 

if (isset($_GET['customer']) && $_GET['customer'] !== NULL){
	$customerID = $_GET['customer'];
	$charges = Stripe_Charge::all(array("count" => 100, "customer" => $customerID )); 
	$customer = Stripe_Customer::retrieve($customerID);
?>

	<header class="customer-info">
		<?php // pointless until we have local customer lookup with stripe ID; ?>
		<h2>Transactions for Customer:</h2>

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
	</header>

<?php 
} else { //no customer set
	$charges = Stripe_Charge::all(array("count" => 100)); 
}
?>



	<table class="table" id="charges">

		<thead>
			<tr>
				<th>Charge ID</th>
				<th>Date</th>
				<th class="paid-th">Status</th>
				<th class="amount-th">Total</th>
				<th>Description</th>
				<th class="fname-th">First Name</th>
				<th class="lname-th">Last Name</th>
				<th>Organization</th>
				<th>Email</th>
				<th>Internal Notes</th>
				<th>SalesForce Link</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="11" style="font-size: 1.6em;">Visit the<a href="https://manage.stripe.com/dashboard">Stripe dashboard</a> to see more charges and filter by date</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach($charges['data'] as $data=>$charge): ?>
			<tr>
				<td class="charge-id">
					<?php echo $charge['id']; ?>
				</td>
				<td class="charge-date">
					<?php echo date('m-d-Y h:m', $charge['created']); ?>
				</td>
				<td class="paid">
					<?php echo $charge['status']; ?>
					<?php if ($charge['paid'] && $charge['refunded'] == 0): ?>
						<span class="paid-true">Paid</span>
					<?php elseif ($charge['refunded'] == 1) : ?>
						<span class="paid-refunded">Refunded</span>
					<?php else: ?>
						<span class="paid-false">Unpaid</span>
					<?php endif; ?>	
				</td>
				<td class="amount">
					<?php if ($charge['refunded'] == 1){echo "-";} ?>$<?php echo ($charge['amount'] / 100); ?>
				</td>
				<td class="description">
					<div>
						<?php echo stripslashes($charge['description']); ?>
					</div>
				</td>
				<td class="first-name">
					<?php echo $charge['metadata']['First Name']; ?>
				</td>
				<td class="last-name">
					<?php if ($charge['customer'] !== NULL): ?>
					<a href="charges.php?customer=<?php echo $charge['customer']; ?>" title="show only this customer's charges">
						<?php echo $charge['metadata']['Last Name']; ?>
					</a>
	
					<?php else: ?>
					<?php echo $charge['metadata']['Last Name']; ?>
					<?php endif; ?>
				</td>
				<td class="organization">
					<?php echo $charge['metadata']['Organization']; ?>
				</td>
				<td class="email">
					<a href="mailto:<?php echo $charge['metadata']['Email']; ?>">
						<?php echo $charge['metadata']['Email']; ?>
					</a>
				</td>
				<td class="internal-notes">
					<div>
						<?php echo stripslashes($charge['metadata']['Internal Notes']); ?>
					</div>
				</td>
				<td class="sf-link">
					<a href="<?php echo $charge['metadata']['SalesForce URL']; ?>">
						Salesforce Link
					</a>
				</td>
			</tr>
		<?php endforeach; ?>

		</tbody>
	</table>
</div>


<?php include 'assets/inc/footer.php'; ?>

