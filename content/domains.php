<?php

	// forbid direct file access

	if ( !defined( 'CALLED_FROM_INDEX' ) || !is_admin( $_SESSION['user'] ) ) {

		header( 'Location: ../' );
	    die( 'You can\'t access this file directly.' );

	}

?>

<?php if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) : ?>

	<?php

		$domain = $_POST['newdomain'];

		create_domain( $domain );

	?>

<?php else : ?>

	<h3 class="card-title">Domains</h3>

	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="inline-form">

		<div class="input-field dark-input">

			<input type="text" name="newdomain" id="newdomain" required>
			<label for="newdomain">New Domainname</label>

		</div>

		<button type="submit" class="waves-effect waves-light btn amber darken-2">Create new domain</button>

	</form>

	<table class="responsive-table">

		<thead>

			<tr>

				<th>ID</th>
				<th>Name</th>

			</tr>

		</thead>

		<tbody>

			<?php $domains = get_domains(); ?>

			<?php foreach ( $domains as $domain ) : ?>

				<tr>

					<td><?php echo $domain['id']; ?></td>
					<td><?php echo $domain['domain']; ?></td>
					<td width="15%">
						<a title="View Accounts" class="blue-grey-text action" href="?p=accounts&d=<?php echo $domain['domain']; ?>"><i class="material-icons">email</i></a>
						<a title="Delete Domain" class="blue-grey-text action" href="?p=delete&domain=<?php echo $domain['id']; ?>" onclick="return confirm('Are you sure you want to delete <?php echo $domain['domain']; ?>? (This will delete all associated accounts!)');"><i class="material-icons">delete</i></a>
					</td>

				</tr>

			<?php endforeach; ?>

		</tbody>

	</table>

<?php endif; ?>
