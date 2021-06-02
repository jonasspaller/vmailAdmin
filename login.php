<div id="login-wrapper" class="valign-wrapper">
	
	<div class="container row">

		<?php

			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

				$email = $_POST['email'];
				$password = $_POST['password'];

				// check password

				$userdata = get_userdata_by_id( get_user_id( $email ) );

				if ( password_verify( $password, $userdata['password'] ) ) {

					session_start();

					$_SESSION['user'] = get_user_id( $email );
					
					header( 'Location: ./' );

				} else {

					header( 'Location: ./?err=' . urlencode( 'Username or password wrong' ) );

				}

			} else {

		?>

		<div class="card col s4 push-s4 blue-grey">

			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">

				<section class="card-content white-text">

					<span class="card-title">vmailAdmin - Login</span>

					<div class="input-field">

						<input type="email" name="email" id="email" required>
						<label for="email">E-Mail</label>

					</div>

					<div class="input-field">

						<input type="password" name="password" id="password" required>
						<label for="password">Password</label>

					</div>

				</section>

				<aside class="card-action">

					<button class="btn-flat amber-text text-darken-2" type="submit">Login</button>

				</aside>

			</form>

		</div>
		
		<noscript>
		
			<p>Please enable JavaScript!</p>
		
		</noscript>

		<?php

			}

		?>
		
	</div>
	
</div>
