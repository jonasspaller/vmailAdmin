<?php

	// forbid direct file access

	if ( !defined( 'CALLED_FROM_INDEX' ) || !is_admin( $_SESSION['user'] ) ) {

		header( 'Location: ../' );
	    die( 'You can\'t access this file directly.' );

	}

?>

<?php if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) : ?>

	<?php

		$username = $_POST['username'];
		$domain = $_POST['d'];

		// password

		$salt = substr( sha1( rand() ), 0, 16 );
		$password = crypt( $_POST['password'], '$6$$salt' );

		// quota

		if ( !empty( $_POST['quota'] ) ) {

			$quota = $_POST['quota'];

		} else {

			$quota = '0';

		}

		// enabled

		if ( isset( $_POST['enabled'] ) ) {

			$enabled = $_POST['enabled'];

		} else {

			$enabled = '0';

		}

		// sendonly

		if ( isset( $_POST['sendonly'] ) ) {

			$sendonly = $_POST['sendonly'];

		} else {

			$sendonly = '0';

		}

		// admin

		if ( isset( $_POST['admin'] ) ) {

			$admin = $_POST['admin'];

		} else {

			$admin = '0';

		}

		// hand params over to create funtion

		create_account( $username, $domain, $password, $quota, $enabled, $sendonly, $admin );

	?>

<?php else : ?>

	<h3 class="card-title">New User</h3>

	<form action="?p=create-account" method="post">

		<div class="row">

			<div class="input-field dark-input col s6">

				<input type="text" name="username" id="username" required>
				<label for="username">Username</label>

			</div>

				<p class="col s6">

					<label>Domain</label>
					<?php domain_selection(); ?>

				</p>

		</div>

		<div class="row">

			<div class="input-field dark-input col s6">

				<input type="password" name="password" id="password" required>
				<label for="password">Password</label>

			</div>

			<div class="input-field dark-input col s6">

				<input type="number" name="quota" id="quota">
				<label for="quota">Quota in Mb</label>

			</div>

		</div>

		<div class="row">

			<p class="col s4">

				<input type="checkbox" class="filled-in" name="enabled" id="enabled" value="1" checked>
				<label for="enabled">Enabled</label>

			</p>

			<p class="col s4">

				<input type="checkbox" class="filled-in" name="sendonly" value="1" id="sendonly">
				<label for="sendonly">Sendonly</label>

			</p>

			<p class="col s4">

				<input type="checkbox" class="filled-in" name="admin" value="1" id="admin">
				<label for="admin">Admin</label>

			</p>

		</div>

		<div class="row">

			<button type="submit" class="waves-effect waves-light btn amber darken-2">Create Account</button>

		</div>

	</form>

<?php endif; ?>
