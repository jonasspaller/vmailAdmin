<?php

	// forbid direct file access

	if ( !defined( 'CALLED_FROM_INDEX' ) || !is_admin( $userid ) ) {

		header( 'Location: ../' );
	    die( 'You can\'t access this file directly.' );

	}

?>

<h3 class="card-title">TLS Policies</h3>

<a class="waves-effect waves-light btn amber darken-2" href="?p=create-tls-policy">New Policy</a>

<table>

	<thead>

		<tr>

			<th>ID</th>
			<th>Domain</th>
			<th>Policy</th>
			<th>Params</th>

		</tr>

	</thead>

	<tbody>

		<?php $policies = get_tls_policies(); ?>

		<?php foreach ( $policies as $policy ) : ?>

			<tr>

				<td><?php echo $policy['id']; ?></td>
				<td><?php echo $policy['domain']; ?></td>
				<td><?php echo $policy['policy']; ?></td>
				<td><?php echo $policy['params']; ?></td>
				<td>
					<span class="center-align">
						<a title="Delete Policy" class="blue-grey-text action" href="?p=delete&policy=<?php echo $policy['id']; ?>" onclick="return confirm('Are you sure you want to delete this policy?');"><i class="material-icons">delete</i></a>
					</span>
				</td>

			</tr>

		<?php endforeach; ?>

	</tbody>

</table>
