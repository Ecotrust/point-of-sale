<?php
if ( API_MODE == 'test' ) : ?> 
	<h4 class="text-danger">You have TEST MODE set in the config. Anything posted will not be charged to a customer.</h4>
<?php endif; ?>

<form action="charge.php" method="POST" id="payment-form" role="form" class="clearfix">

	<fieldset>
		<legend> Customer Information</legend>

		<div class="form-group">
			<label>Customer Name</label>
			<div class="form-inline">
				<input type="text" value="<?php if(isset($_POST['fname'])) echo $_POST['fname']; ?>" name="fname" placeholder="First Name" class="form-control" required >
				<input type="text" value="<?php if(isset($_POST['lname'])) echo $_POST['lname']; ?>" name="lname" placeholder="Last Name" class="form-control" required >
			</div>
		</div>

		<div class="form-group">
			<label>Organization</label>
			<input type="text" size="40" value="<?php if(isset($_POST['org'])) echo $_POST['org']; ?>" name="org" placeholder="Organization Name" class="form-control">
		</div>

		<div class="form-group">
			<label>Email Address <span class="help">Receipt will be mailed to this address</span></label>
			<input type="text" size="40" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" name="email" placeholder="person@place.com" class="form-control" required >
		</div>

		<!-- 
		<div class="form-group">
			<label>Address</label>
			<input type="text" size="40" name="address1" placeholder="Street Address 1" class="form-control">
			<input type="text" size="40" name="address2" placeholder="Street Address 2" class="form-control">
			<div class="form-inline">
				<input type="text" size="10" name="city" placeholder="City" class="form-control">
				<input type="text" size="3" name="state" placeholder="ST" class="form-control">
				<input type="text" size="10" name="zip" placeholder="Zip" class="form-control">
		</div>
		-->
		<div class="form-group">
			<label>Date of event (MM-DD-YYYY)</label>
			<input type="text" name="date" placeholder="MM-DD-YYYY" class="form-control">
		</div>


		<div class="form-group">
			<label>Salesforce Link</label>
			<input type="text" name="sforceLink" value="<?php if(isset($_POST['sforceLink'])) echo $_POST['sforceLink']; ?>" placeholder="paste a url from salesforce" class="form-control">
		</div>


	</fieldset>

	<!--
	<fieldset>
		<legend> Item Information</legend>

		<div class="form-group">
			<label>Item <span class="help">Need Multiple? Fixed dropdown list?</span></label>
			<input type="text" name="item" placeholder="Dropdown list?" class="form-control">
		</div>

		<div class="form-group">
			<label>Date of event (MM-DD-YYYY)</label>
			<input type="text" name="date" placeholder="MM-DD-YYYY" class="form-control">
		</div>

		<div class="form-group">
			<label>Amount</label>
			<input type="text" size="20" name="amount" placeholder="amount" class="form-control">
		</div>

		<div class="form-group">
			<label>Notes</label>
			<textarea type="text" name="notes" placeholder="Enter any notes. Email to customer?" class="form-control"></textarea>
		</div>

	</fieldset>
	-->

	<fieldset>
		<legend>Card Information</legend>

		<div class="form-group">
			<label>Name on Card</label>
			<input type="text" name="nameoncard" placeholder="Name on card" class="form-control">
		</div>

		<div class="form-group card-number">
			<label>Card Number</label>
			<input type="text" size="20" name="ccnum" autocomplete="off" placeholder="CC Number" class="card-number form-control"  required />
		</div>

		<div class="form-group card-cvc">
			<label>CVC/Secret Code</label>
			<input type="text" size="4" autocomplete="off" name="cvc" placeholder="CVC" class="card-cvc form-control"  required />
		</div>

		<div class="form-group">
			<label>Expiration (MM/YYYY)</label>
			<div class="form-inline">
				<input type="text" size="2"  placeholder="Month" class="card-expiry-month form-control" required />
				<span> / </span>
				<input type="text" size="4"  placeholder="Year" class="card-expiry-year form-control" required />
			</div>
		</div>

		<div class="form-group">
			<label>Amount</label>
			<div class="input-group">
				<span class="input-group-addon">$</span>
				<input type="text" size="20" value="<?php if(isset($_POST['amount'])) echo $_POST['amount']; ?>" name="amount" placeholder="amount" class="form-control" required >
			</div>
		</div>

		<div class="form-group">
			<label>Internal Note <span class="help">Not shared with customer.</span></label>
			<textarea type="text" maxlength="200" name="internal_notes" placeholder="Enter any notes." class="form-control"><?php if(isset($_POST['internal_notes'])) echo $_POST['internal_notes']; //white space is silly ?> </textarea>
		</div>

	</fieldset>

	<button id="submit-button" type="submit" class="clearfix btn btn-lg btn-primary submit-button">Submit Payment</button>

</form>
