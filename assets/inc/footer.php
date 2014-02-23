		</div><!-- /.container -->


        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
		<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
		<script type="text/javascript">
			<?php // This constant is set in /assets/inc/config.php ?>
			Stripe.setPublishableKey('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');
		</script>
        <script type="text/javascript" src="assets/js/global.js"></script>

	</body>
</html>
