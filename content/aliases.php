<?php

	// forbid direct file access

	if ( !defined( 'CALLED_FROM_INDEX' ) ) {

		header( 'Location: ../' );
	    die( 'You can\'t access this file directly.' );

	}

?>

<h3 class="card-title">Aliases</h3>

<?php $domains = get_domains(); ?>

<aside class="side-actions">

	<form action="?p=aliases" method="get">

		<input type="hidden" name="p" value="aliases" />

		<label>Domain</label>

		<select name="d">

			<?php foreach ( $domains as $domain ) : ?>

				<option value="<?php echo $domain['domain']; ?>" <?php echo ( isset( $_GET['d'] ) && $_GET['d'] == $domain['domain'] ) ? 'selected' : ''; ?> ><?php echo $domain['domain']; ?></option>

			<?php endforeach; ?>

		</select>

		<button type="submit" class="waves-effect waves-light btn amber darken-2">Select</button>

	</form>

	<div class="flex-helper">

		<a class="waves-effect waves-light btn amber darken-2" href="./?p=create-alias">New Alias</a>

	</div>

</aside>

<table>

	<thead>

		<tr>

			<th>ID</th>
			<th>Source Username</th>
			<th>Source Domain</th>
			<th>Destination Username</th>
			<th>Destination Domain</th>
			<th><span class="center-align">Enabled</span></th>

		</tr>

	</thead>

	<tbody>

		<?php

			try {

				$pdo = get_db_connection();

				if ( isset( $_GET['d'] ) ) {

					$sql = "SELECT * FROM aliases WHERE source_domain = :domain";

				} else {

					$sql = "SELECT * FROM aliases";

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

		<?php foreach ( $result as $alias ) : ?>

			<tr>

				<td><?php echo $alias['id']; ?></td>
				<td><?php echo $alias['source_username']; ?></td>
				<td><?php echo $alias['source_domain']; ?></td>
				<td><?php echo $alias['destination_username']; ?></td>
				<td><?php echo $alias['destination_domain']; ?></td>
				<td><span class="center-align"><?php echo ( $alias['enabled'] == '1' ) ? 'Yes' : 'No'; ?></span></td>
				<td>
					<span class="center-align">
						<a title="Delete Alias" class="blue-grey-text action" href="?p=delete&alias=<?php echo $alias['id']; ?>" onclick="return confirm('Are you sure you want to delete <?php echo $alias['source_username'] . '@' . $alias['source_domain']; ?>?');"><i class="material-icons">delete</i></a>
					</span>
				</td>

			</tr>

		<?php endforeach; ?>

	</tbody>

</table>
