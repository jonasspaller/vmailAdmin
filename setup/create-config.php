<?php if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) : ?>
	
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">

		<section class="card-content white-text">

			<span class="card-title">vmailAdmin Setup - Step 1</span>

			<p>In order to use vmailAdmin you need to tell us in which database we can store our necessary data. Just fill out the form below and we will take care of the config file.</p>

			<div class="input-field">

				<input type="text" name="dbhost" id="dbhost" required>
				<label for="dbhost">Database Host</label>

			</div>

			<div class="input-field">

				<input type="text" name="dbname" id="dbname" required>
				<label for="dbname">Database Name</label>

			</div>

			<div class="input-field">

				<input type="text" name="dbuser" id="dbuser" required>
				<label for="dbuser">Database User</label>

			</div>

			<div class="input-field">

				<input type="password" name="dbpass" id="dbpass">
				<label for="dbpass">Password</label>

			</div>

		</section>

		<div class="card-action">

			<button class="btn-flat amber-text text-darken-2" type="submit">Create config file</button>

		</div>

	</form>

<?php else : ?>

	<?php

		$dbhost = $_POST['dbhost'];
		$dbname = $_POST['dbname'];
		$dbuser = $_POST['dbuser'];
		$dbpass = $_POST['dbpass'];

		// create config.php content

		$content = "<?php" . "\n";
		$content .= "\t" . "define('DBHOST', '" . $dbhost . "');" . "\n";
		$content .= "\t" . "define('DBNAME', '" . $dbname . "');" . "\n";
		$content .= "\t" . "define('DBUSER', '" . $dbuser . "');" . "\n";
		$content .= "\t" . "define('DBPASS', '" . $dbpass . "');" . "\n";
		$content .= "?>";

		// put content into file

		try {

			file_put_contents( '../config.php', $content );

			header( 'Location: ./' );

		} catch ( Exception $e ) {

			die( '<p>An error occured while writing to config.php:</p>' . $e->getMessage );

		}

	?>

<?php endif; ?>
