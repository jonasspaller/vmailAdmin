<?php

	// forbid direct file access

	if ( !defined( 'CALLED_FROM_INDEX' ) || !is_admin( $_SESSION['user'] ) ) {

		header( 'Location: ../' );
	    die( 'You can\'t access this file directly.' );

	}

?>

<?php if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) : ?>

	<?php

		$domain = $_POST['domain'];
		$policy = $_POST['policy'];
		$params = $_POST['params'];

		// hand params over to create funtion

		create_tls_policy( $domain, $policy, $params );

	?>

<?php else : ?>

	<h3 class="card-title">New TLS Policy</h3>

	<form action="?p=create-tls-policy" method="post">

		<div class="row">

			<div class="input-field dark-input col s6">

				<input type="text" name="domain" id="domain" required>
				<label for="domain">Domain</label>

			</div>

			<p class="col s6">

				<label>Policy</label>
				<select name="policy">

					<option value="none">none</option>
					<option value="may">may</option>
					<option value="encrypt">encrypt</option>
					<option value="dane">dane</option>
					<option value="dane-only">dane-only</option>
					<option value="fingerprint">fingerprint</option>
					<option value="verify">verify</option>
					<option value="secure">secure</option>

				</select>

			</p>

		</div>

		<div class="row">

			<div class="input-field dark-input col s12">

				<input type="text" name="params" id="params">
				<label for="params">Params</label>

			</div>

		</div>

		<div class="row">

			<button type="submit" class="waves-effect waves-light btn amber darken-2">Create Policy</button>

		</div>

	</form>

<?php endif; ?>
