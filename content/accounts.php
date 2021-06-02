<?php

	// forbid direct file access

	if ( !defined( 'CALLED_FROM_INDEX' ) || !is_admin( $userid ) ) {

		header( 'Location: ../' );
	    die( 'You can\'t access this file directly.' );

	}

?>

<h3 class="card-title">Accounts</h3>

<aside class="side-actions">

	<form action="?p=accounts" method="get">

		<input type="hidden" name="p" value="accounts" />

		<label>Domain</label>

		<?php domain_selection(); ?>

		<button type="submit" class="waves-effect waves-light btn amber darken-2">Select</button>

	</form>

	<div class="flex-helper">

		<a class="waves-effect waves-light btn amber darken-2" href="?p=create-account">New User</a>

	</div>

</aside>

<table>

	<thead>

		<tr>

			<th>ID</th>
			<th>Username</th>
			<th>Domain</th>
			<th><span class="center-align">Quota</span></th>
			<th><span class="center-align">Enabled</span></th>
			<th><span class="center-align">Sendonly</span></th>
			<th><span class="center-align">Admin</span></th>

		</tr>

	</thead>

	<tbody>

		<?php

			try {

				$pdo = get_db_connection();

				if ( isset( $_GET['d'] ) ) {

					$sql = "SELECT * FROM accounts WHERE domain = :domain";

				} else {

					$sql = "SELECT * FROM accounts";

				}

				$stmt = $pdo->prepare( $sql );
				if ( isset( $_GET['d'] ) ) $stmt->bindParam( ':domain', $_GET['d'] );
				$stmt->execute();
				$result = $stmt->fetchAll( PDO::FETCH_ASSOC );

				$pdo = null;

			} catch ( Exception $e ) {

				die( 'An error occured: ' . $e->getMessage() );

			}

		?>

		<?php foreach ( $result as $account ) : ?>

			<tr>

				<td><?php echo $account['id']; ?></td>
				<td><?php echo $account['username']; ?></td>
				<td><?php echo $account['domain']; ?></td>
				<td><span class="center-align"><?php echo ( $account['quota'] == '0' ) ? 'Unlimited' : $account['quota'] . 'Mb'; ?></span></td>
				<td><span class="center-align"><?php echo ( $account['enabled'] == '1' ) ? 'Yes' : 'No'; ?></span></td>
				<td><span class="center-align"><?php echo ( $account['sendonly'] == '1' ) ? 'Yes' : 'No'; ?></span></td>
				<td><span class="center-align"><?php echo ( $account['admin'] == '1' ) ? 'Yes' : 'No'; ?></span></td>
				<td>
					<span class="center-align">
						<a title="Edit this account" class="blue-grey-text action" href="?p=edit-account&a=<?php echo $account['id']; ?>"><i class="material-icons">mode_edit</i></a>
						<a title="Delete Account" class="blue-grey-text action" href="?p=delete&account=<?php echo $account['id']; ?>" onclick="return confirm('Are you sure you want to delete <?php echo $account['username'] . '@' . $account['domain']; ?>?');"><i class="material-icons">delete</i></a>
					</span>
				</td>

			</tr>

		<?php endforeach; ?>

	</tbody>

</table>
