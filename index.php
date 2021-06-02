<?php

	// check if config.php is present

	if ( !file_exists( './config.php' ) ) header( 'Location: ./setup/' );

	// necessary includes

	require_once( './config.php' );
	require_once( './resources/functions.php' );

	// check if vmailAdmin is installed

	if ( !check_installation() ) header( 'Location: ./setup/' );

    // forbid direct File access

    define('CALLED_FROM_INDEX', true);

	// start session

	session_start();

?>

<!DOCTYPE html>
<html lang="de-DE">

	<head>

		<title>vmailAdmin<?php echo ( !isset( $_SESSION['user'] ) ) ? ' - Login' : ''; ?></title>

		<meta charset="utf-8">
		<meta name="author" content="Jonas Spaller, Dominik Scherbarth">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="theme-color" content="#607d8b">

		<!-- CSS -->

		<link type="text/css" rel="stylesheet" href="./resources/css/materialize.min.css">
		<link type="text/css" rel="stylesheet" href="./resources/css/style.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	</head>

	<body>

		<?php if ( isset( $_SESSION['user'] ) ) : ?>

			<?php $userid = $_SESSION['user']; ?>

			<nav class="blue-grey">

				<div class="nav-wrapper container">

					<a href="./" class="brand-logo">
						vmailAdmin
					</a>

					<ul id="nav-mobile" class="right hide-on-med-and-down">

						<li>

							<?php if ( is_admin( $userid ) ) : ?>

								<a href="?p=accounts">
									<i class="material-icons left">email</i>
									<span>Accounts</span>
								</a>

							<?php else : ?>

								<a href="?p=edit-account">
									<i class="material-icons left">email</i>
									<span>Account</span>
								</a>

							<?php endif; ?>

						</li>

						<?php if ( is_admin( $userid ) ) : ?>

              <li>
                  <a href="?p=aliases">
                      <i class="material-icons left">account_circle</i>
                      <span>Aliases</span>
                  </a>
              </li>

							<li>
								<a href="?p=domains">
									<i class="material-icons left">domain</i>
									<span>Domains</span>
								</a>
							</li>

							<li>
								<a href="?p=tls-policies">
									<i class="material-icons left">security</i>
									<span>TLS policies</span>
								</a>
							</li>

						<?php endif; ?>

						<li>
							<a href="logout.php">
								<i class="material-icons left">power_settings_new</i>
								<span>Logout</span>
							</a>
						</li>

					</ul>

				</div>

			</nav>

			<div class="row">

				<main id="site-content" class="card white col s8 push-s2 black-text">

					<?php

						if ( isset( $_GET['p'] ) ) {

							$page = $_GET['p'];

							include( './content/' . $page . '.php' );

						} elseif ( is_admin( $userid ) ) {

							include( './content/accounts.php' );

						} else {

							include( './content/edit-account.php' );

						}

					?>

				</main>

			</div>

		<?php else : ?>

				<?php require_once( './login.php' ); ?>

		<?php endif; ?>

		<!-- JavaScript -->

		<script type="text/javascript" src="./resources/js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="./resources/js/materialize.min.js"></script>
		<script type="text/javascript" src="./resources/js/functions.js"></script>

	</body>

</html>
