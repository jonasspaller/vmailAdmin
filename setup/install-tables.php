<?php if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) : ?>

	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
		
		<section class="card-content white-text">
			
			<span class="card-title">vmailAdmin Setup - Step 2</span>
			
			<p>Great! Now the only thing left to do is to create an admin account and you're ready to go.</p>
		
			<div class="input-field">

				<input type="text" name="adminname" id="adminname" required>
				<label for="adminname">Username</label>

			</div>

			<div class="input-field">

				<input type="text" name="admindomain" id="admindomain" required>
				<label for="admindomain">Domain</label>

			</div>

			<div class="input-field">

				<input type="password" name="adminpass" id="adminpass" required>
				<label for="adminpass">Password</label>

			</div>
			
		</section>
		
		<div class="card-action">
		
			<button class="btn-flat amber-text text-darken-2" type="submit">Install vmailAdmin</button>
		
		</div>
	
	</form>

<?php else : ?>

	<?php

		// create database tables

		$pdo = get_db_connection();

		// domains table

		try {
			
			$query = "CREATE TABLE IF NOT EXISTS `domains` (
				`id` int unsigned NOT NULL AUTO_INCREMENT,
				`domain` varchar(255) NOT NULL,
				PRIMARY KEY (`id`),
				UNIQUE KEY (`domain`)
			) CHARSET=latin1;";
	
			$pdo->exec( $query );
			
			echo '<p class="white-text">' . 'Successfully created domains table' . '</p>';
			
		} catch ( PDOException $e ) {
			
			die( '<p class="white-text">' . 'Could\'nt create domains table. Error: ' . $e->getMessage() . '</p>' );
			
		}

		// accounts table

		try {
			
			$query = "CREATE TABLE IF NOT EXISTS `accounts` (
				`id` int unsigned NOT NULL AUTO_INCREMENT,
				`username` varchar(64) NOT NULL,
				`domain` varchar(255) NOT NULL,
				`password` varchar(255) NOT NULL,
				`quota` int unsigned DEFAULT '0',
				`enabled` boolean DEFAULT '0',
				`sendonly` boolean DEFAULT '0',
				`admin` boolean DEFAULT '0',
				PRIMARY KEY (id),
				UNIQUE KEY (`username`, `domain`),
				FOREIGN KEY (`domain`) REFERENCES `domains` (`domain`)
			) CHARSET=latin1;";
	
			$pdo->exec( $query );
			
			echo '<p class="white-text">' . 'Successfully created accounts table' . '</p>';
			
		} catch ( PDOException $e ) {
			
			die( '<p class="white-text">' . 'Could\'nt create accounts table. Error: ' . $e->getMessage() . '</p>' );
			
		}

		// aliases table

		try {
			
			$query = "CREATE TABLE IF NOT EXISTS `aliases` (
				`id` int unsigned NOT NULL AUTO_INCREMENT,
				`source_username` varchar(64) NOT NULL,
				`source_domain` varchar(255) NOT NULL,
				`destination_username` varchar(64) NOT NULL,
				`destination_domain` varchar(255) NOT NULL,
				`enabled` boolean DEFAULT '0',
				PRIMARY KEY (`id`),
				UNIQUE KEY (`source_username`, `source_domain`, `destination_username`, `destination_domain`),
				FOREIGN KEY (`source_domain`) REFERENCES `domains` (`domain`)
			) CHARSET=latin1;";
	
			$pdo->exec( $query );
			
			echo '<p class="white-text">' . 'Successfully created aliases table' . '</p>';
			
		} catch ( PDOException $e ) {
			
			die( '<p class="white-text">' . 'Could\'nt create aliases table. Error: ' . $e->getMessage() . '</p>' );
			
		}

		// tlspolicies table

		try {
			
			$query = "CREATE TABLE IF NOT EXISTS `tlspolicies` (
				`id` int unsigned NOT NULL AUTO_INCREMENT,
				`domain` varchar(255) NOT NULL,
				`policy` enum('none', 'may', 'encrypt', 'dane', 'dane-only', 'fingerprint', 'verify', 'secure') NOT NULL,
				`params` varchar(255),
				PRIMARY KEY (`id`),
				UNIQUE KEY (`domain`)
			) CHARSET=latin1;";
	
			$pdo->exec( $query );
			
			echo '<p class="white-text">' . 'Successfully created tlspolicies table' . '</p>';
			
		} catch ( PDOException $e ) {
			
			die( '<p class="white-text">' . 'Could\'nt create tlspolicies table. Error: ' . $e->getMessage() . '</p>' );
			
		}

		// insert admin account

		$adminname = strtolower( $_POST['adminname'] );
		$admindomain = strtolower( $_POST['admindomain'] );

		// hash given password

		$salt = substr( sha1( rand() ), 0, 16 );
		$adminpass = crypt( $_POST['adminpass'], '$6$$salt' );

		try {
			
			$stmt = $pdo->prepare( "INSERT INTO domains (domain) VALUES (:domain)" );
			$stmt->execute( array( ':domain' => $admindomain ) );

			$stmt = $pdo->prepare( "INSERT INTO accounts (username, domain, password, quota, enabled, sendonly, admin) VALUES (:username, :domain, :password, 0, 1, 0, 1)" );
			$stmt->execute( array(
				':username' => $adminname,
				':domain' => $admindomain,
				':password' => $adminpass
			) );
			
			echo '<p class="white-text">' . 'Successfully created ' . $adminname . '@' . $admindomain . '</p>';
			
		} catch ( Exception $e ) {
			
			die( '<p class="white-text">' . 'Couldn\'t create admin account. Error: ' . $e->getMessage() . '</p>' );
			
		}
		
		// close pdo connection

		$pdo = null;

	?>

	<aside class="card-action">

		<a href="../" class="amber-text text-darken-2">Login to vmailAdmin</a>

	</aside>

<?php endif; ?>
