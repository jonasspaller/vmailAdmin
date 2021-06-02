<?php

	// forbid direct file access

	if ( !defined( 'CALLED_FROM_INDEX' ) ) {

		header( 'Location: ../' );
	    die( 'You can\'t access this file directly.' );

	}

?>

<?php

	if ( isset( $_GET['a'] ) && is_admin( $userid ) ) {

		$user_to_edit = $_GET['a'];

	} else {

		$user_to_edit = $userid;

	}

	// get userdata

	$userdata = get_userdata_by_id( $user_to_edit );

?>

<?php if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) : ?>

	<?php

		// password

		$salt = substr( sha1( rand() ), 0, 16 );
		$newpassword = crypt( $_POST['password'], '$6$$salt' );

		if ( empty( $_POST['password'] ) ) $newpassword = $userdata['password'];

		// quota

		$quota = ( isset( $_POST['quota'] ) && ( !empty( $_POST['quota'] ) || $_POST['quota'] == '0' ) ) ? $_POST['quota'] : $userdata['quota'];

		// enabled

		$enabled = ( isset( $_POST['enabled'] ) ) ? $_POST['enabled'] : $userdata['enabled'];

		// sendonly

		$sendonly = ( isset( $_POST['sendonly'] ) ) ? $_POST['sendonly'] : $userdata['sendonly'];

		// admin

		$admin = ( isset( $_POST['admin'] ) ) ? $_POST['admin'] : $userdata['admin'];

		// hand over params to update function

		update_userdata( $user_to_edit, $newpassword, $quota, $enabled, $sendonly, $admin );

	?>

<?php else : ?>

	<h3 class="card-title">Edit Account - <?php echo $userdata['username'] .'@' . $userdata['domain']; ?></h3>

	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">

		<div class="row">

			<div class="input-field dark-input col s6">

				<input type="password" name="password" id="password">
				<label for="password">New Password</label>

			</div>

			<?php if ( is_admin( $userid ) ) : ?>

				<div class="input-field dark-input col s6">

					<input type="number" name="quota" id="quota" value="<?php echo $userdata['quota']; ?>">
					<label for="quota">Quota in Mb (set 0 to disable)</label>

				</div>

			<?php endif; ?>

		</div>

		<?php if ( is_admin( $userid ) ) : ?>

			<div class="row">

				<p class="col s4">

					<input type="checkbox" class="filled-in" name="enabled" id="enabled" value="1" <?php echo ( $userdata['enabled'] == '1' ) ? 'checked' : ''; ?>>
					<label for="enabled">Enabled</label>

				</p>

				<p class="col s4">

					<input type="checkbox" class="filled-in" name="sendonly" value="1" id="sendonly" <?php echo ( $userdata['sendonly'] == '1' ) ? 'checked' : ''; ?>>
					<label for="sendonly">Sendonly</label>

				</p>

				<p class="col s4">

					<input type="checkbox" class="filled-in" name="admin" value="1" id="admin" <?php echo ( $userdata['admin'] == '1' ) ? 'checked' : ''; ?>>
					<label for="admin">Admin</label>

				</p>

			</div>

		<?php endif; ?>

		<div class="row">

			<button type="submit" class="waves-effect waves-light btn amber darken-2">Save</button>

		</div>

	</form>

<?php endif; ?>
