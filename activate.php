<?php require_once('html_fragments/header.php');
require_once('functions/activate.php'); ?>
<div id="content">
	<h3>Account verification</h3>
	<br/>
	<?php if (activate($_GET['token']) == TRUE && isset($_SESSION['valid-token'])) { ?>
		<p>Congratulations, your account has been verified !<br/>
		You can now sign in and begin your photographic journey on Camagru.</p>
	<?php ; $_SESSION['valid-token'] = ''; } else { ?>
		</p>Sorry, your account was not found.</p>
	<?php } ?>
</div>
<?php require_once('html_fragments/footer.php'); ?>
