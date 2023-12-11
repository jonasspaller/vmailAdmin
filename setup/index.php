<?php

	// necessary includes

	if ( file_exists( '../config.php' ) ) require_once( '../config.php' );
	require_once( '../resources/functions.php' );

?>

<!DOCTYPE html>
<html lang="de-DE">

	<head>

		<title>vmailAdmin - Installation</title>

		<meta charset="utf-8">
		<meta name="author" content="Jonas Spaller, Dominik Scherbarth">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="theme-color" content="#607d8b">

		<!-- CSS -->

		<link type="text/css" rel="stylesheet" href="../resources/css/materialize.min.css">
		<link type="text/css" rel="stylesheet" href="../resources/css/style.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	</head>

	<body>

		<div id="login-wrapper" class="valign-wrapper">

			<div class="container row">

				<div class="card col s6 push-s3 blue-grey">

					<?php

						if ( !file_exists( '../config.php' ) ) {

							include( 'create-config.php' );

						} elseif ( !check_installation() ) {

							include( 'install-tables.php' );

						} else {

					?>

						<section class="card-content white-text">

							<span class="card-title">vmailAdmin is already installed!</span>

							<p>You can go ahead and use vmailAdmin to manage your virtual mail accounts. Have fun!</p>

						</section>

						<aside class="card-action">

							<a href="../">Login to vmailAdmin</a>

						</aside>

					<?php

						}

					?>

				</div>

			</div>

		</div>

		<!-- JavaScript -->

		<script type="text/javascript" src="../resources/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="../resources/js/materialize.min.js"></script>

	</body>

</html>
