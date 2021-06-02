<?php

	// forbid direct file access

	if ( !defined( 'CALLED_FROM_INDEX' ) || !is_admin( $_SESSION['user'] ) ) {

		header( 'Location: ../' );
	    die( 'You can\'t access this file directly.' );

	}

?>

<?php if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) : ?>

	<?php

		$source_username = $_POST['source_username'];
    $source_domain = $_POST['d'];
    $destination_username = $_POST['destination_username'];
    $destination_domain = $_POST['destination_domain'];

		// enabled

		if ( isset( $_POST['enabled'] ) ) {

			$enabled = $_POST['enabled'];

		} else {

			$enabled = '0';

		}

		// hand params over to create funtion

		create_alias( $source_username, $source_domain, $destination_username, $destination_domain, $enabled );

	?>

<?php else : ?>

	<h3 class="card-title">New Alias</h3>

	<form action="?p=create-alias" method="post">

		<div class="row">

			<div class="input-field dark-input col s6">

				<input type="text" name="source_username" id="source_username" required>
				<label for="source_username">Source Username</label>

			</div>

				<p class="col s6">

					<label>Domain</label>
					<?php domain_selection(); ?>

				</p>

		</div>

		<div class="row">

			<div class="input-field dark-input col s6">

				<input type="text" name="destination_username" id="destination_username" required>
				<label for="destination_username">Destination Username</label>

			</div>

			<div class="input-field dark-input col s6">

				<input type="text" name="destination_domain" id="destination_domain" required>
				<label for="destination_domain">Destination Domain</label>

			</div>

		</div>

		<div class="row">

			<p class="col s4">

				<input type="checkbox" class="filled-in" name="enabled" id="enabled" value="1" checked>
				<label for="enabled">Enabled</label>

			</p>

		</div>

		<div class="row">

			<button type="submit" class="waves-effect waves-light btn amber darken-2">Create Alias</button>

		</div>

	</form>

<?php endif; ?>
