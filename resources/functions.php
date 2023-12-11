<?php



	/****** GET STUFF ******/



	// get database connection

	function get_db_connection() {

		// set up params

		$dsn = 'mysql:dbname='.DBNAME.';host='.DBHOST;
		$user = DBUSER;
		$password = DBPASS;

		try {

			// create new PDO Object

			$pdo = new PDO( $dsn, $user, $password );

		} catch ( PDOException $e ) {

			// PDO Object failed - display error message

			die( 'Connection failed: '.$e->getMessage() );

		}

		return $pdo;

	}

	// get user id

	function get_user_id( $email ) {

		$e = explode( '@', $email );
		$username = $e[0];
		$domain = $e[1];

		$pdo = get_db_connection();

		$stmt = $pdo->prepare( 'SELECT id FROM accounts WHERE username = :username AND domain = :domain' );

		// bind params to query

		$stmt->bindParam( ':username', $username );
		$stmt->bindParam( ':domain', $domain );

		if ( $stmt->execute() ) {

			// query successful - fetch data

			$result = $stmt->fetch( PDO::FETCH_ASSOC );

			// close database connection

			$pdo = NULL;

			// return user id

			return $result['id'];

		} else {

			// query failed - display error message

			die(
				'Error in functions.php - Function: get_user_id()<br>' .
				'<b>Info:</b> ' . $stmt->errorInfo()[2]
			);

		}

	}

	// get user data by id

	function get_userdata_by_id( $id ) {

		$pdo = get_db_connection();

		$stmt = $pdo->prepare( 'SELECT * FROM accounts WHERE id = :id' );

		// bind params to query

		$stmt->bindParam( ':id', $id );

		if ( $stmt->execute() ) {

			// query successful - fetch data

			$userdata = $stmt->fetch( PDO::FETCH_ASSOC );

			// close database connection

			$pdo = NULL;

			// return userdata

			return $userdata;

		} else {

			// query failed - display error message

			die(
				'Error in functions.php - Function: get_userdata_by_id()<br>' .
				'<b>Info:</b> ' . $stmt->errorInfo()[2]
			);

		}

	}

	// get all domains

	function get_domains() {

		$pdo = get_db_connection();

		$stmt = $pdo->prepare( "SELECT * FROM domains ORDER BY id" );

		if ( $stmt->execute() ) {

			// query successful - fetch data

			$result = $stmt->fetchAll( PDO::FETCH_ASSOC );

			// close database connection

			$pdo = NULL;

			// return domains

			return $result;

		} else {

			// query failed - display error message

			die(
				'Error in functions.php - Function: get_domains()<br>' .
				'<b>Info:</b> ' . $stmt->errorInfo()[2]
			);

		}

	}

	// get domain by id

	function get_domain_by_id( $id ) {

		$pdo = get_db_connection();

		$stmt = $pdo->prepare( "SELECT * FROM domains WHERE id = :id" );

		// bind params to query

		$stmt->bindParam( ':id', $id );

		if ( $stmt->execute() ) {

			// query successful - fetch data

			$result = $stmt->fetchAll( PDO::FETCH_ASSOC );

			// close database connection

			$pdo = NULL;

			// return domain

			return $result['0']['domain'];

		} else {

			// query failed - display error message

			die(
				'Error in functions.php - Function: get_domain_by_id()<br>' .
				'<b>Info:</b> ' . $stmt->errorInfo()[2]
			);

		}

	}

	// get tls policies

	function get_tls_policies() {

		$pdo = get_db_connection();

		$stmt = $pdo->prepare( "SELECT * FROM tlspolicies" );

		if ( $stmt->execute() ) {

			// query successful - fetch data

			$result = $stmt->fetchAll( PDO::FETCH_ASSOC );

			// close database connection

			$pdo = NULL;

			// return policies

			return $result;

		}

	}



	/****** CREATE STUFF ******/



	// create account

	function create_account( $username, $domain, $password, $quota, $enabled, $sendonly, $admin ) {

		$pdo = get_db_connection();

		$stmt = $pdo->prepare( "INSERT INTO accounts (username, domain, password, quota, enabled, sendonly, admin) VALUES (:username, :domain, :password, :quota, :enabled, :sendonly, :admin)" );

		// bind params to query

		$stmt->bindParam( ':username', $username );
		$stmt->bindParam( ':domain', $domain );
		$stmt->bindParam( ':password', $password );
		$stmt->bindParam( ':quota', $quota );
		$stmt->bindParam( ':enabled', $enabled );
		$stmt->bindParam( ':sendonly', $sendonly );
		$stmt->bindParam( ':admin', $admin );

		if ( $stmt->execute() ) {

			// query successful - close database connection

			$pdo = NULL;

			// display success massage

			echo '<p>' . 'Successfully created new account' . '</p>';

		} else {

			die(
				'Error in functions.php - Function: create_account()<br>' .
				'<b>Info:</b> ' . $stmt->errorInfo()[2]
			);

		}

	}

	// create alias

	function create_alias( $source_username, $source_domain, $destination_username, $destination_domain, $enabled ) {

		$pdo = get_db_connection();

		// prepare query

		$stmt = $pdo->prepare( "INSERT INTO aliases (source_username, source_domain, destination_username, destination_domain, enabled) VALUES (:source_username, :source_domain, :destination_username, :destination_domain, :enabled)" );

		// bind params to query

		$stmt->bindParam( ':source_username', $source_username );
		$stmt->bindParam( ':source_domain', $source_domain );
		$stmt->bindParam( ':destination_username', $destination_username );
		$stmt->bindParam( ':destination_domain', $destination_domain );
		$stmt->bindParam( ':enabled', $enabled );

		if ( $stmt->execute() ) {

			// close database connection

			$pdo = NULL;

			echo '<p>' . 'Successfully created new alias' . '</p>';

		} else {

			// query failed - display error message

			die(
				'Error in functions.php - Function: create_alias()<br>' .
				'<b>Info:</b> ' . $stmt->errorInfo()[2]
			);

		}

	}

	// create domain

	function create_domain( $domain ) {

		$pdo = get_db_connection();

		$stmt = $pdo->prepare( "INSERT INTO domains (domain) VALUES (:domain)" );

		// bind params to query

		$stmt->bindParam( ':domain', $domain );

		if ( $stmt->execute() ) {

			// query successful - close database connection

			$pdo = NULL;

			// display success message

			echo '<p>' . 'Successfully created new domain' . '</p>';

		} else {

			// query failed - display error message

			die(
				'Error in functions.php - Function: create_domain()<br>' .
				'<b>Info:</b> ' . $stmt->errorInfo()[2]
			);

		}

	}

	function create_tls_policy( $domain, $policy, $params ) {

		$pdo = get_db_connection();

		$stmt = $pdo->prepare( "INSERT INTO tlspolicies (domain, policy, params) VALUES (:domain, :policy, :params)" );

		// bind params to query

		$stmt->bindParam( ':domain', $domain );
		$stmt->bindParam( ':policy', $policy );
		$stmt->bindParam( ':params', $params );

		if ( $stmt->execute() ) {

			// query successful - close database connection

			$pdo = NULL;

			// display success message

			echo '<p>' . 'Successfully created new policy' . '</p>';

		} else {

			// query failed - display error message

			die(
				'Error in functions.php - Function: create_tls_policy()<br>' .
				'<b>Info:</b> ' . $stmt->errorInfo()[2]
			);

		}

	}



	/****** DELETE STUFF ******/



	// delete account

	function delete_account( $id ) {

		$pdo = get_db_connection();

		$stmt = $pdo->prepare( "DELETE FROM accounts WHERE id = :id" );

		// bind params to query

		$stmt->bindParam( ':id', $id );

		if ( $stmt->execute() ) {

			// query successful - close database connection

			$pdo = NULL;

			// display success message

			echo 'Successfully deleted account';

		} else {

			// query failed - display error message

			die(
				'Error in functions.php - Function: delete_account()<br>' .
				'<b>Info:</b> ' . $stmt->errorInfo()[2]
			);

		}

	}

	// delete alias

	function delete_alias( $id ) {

		$pdo = get_db_connection();

		$stmt = $pdo->prepare( "DELETE FROM aliases WHERE id = :id" );

		// bind params to query

		$stmt->bindParam( ':id', $id );

		if ( $stmt->execute() ) {

			// query successful - close database connection

			$pdo = NULL;

			// display success message

			echo 'Successfully deleted alias';

		} else {

			// query failed - display error message

			die(
				'Error in functions.php - Function: delete_alias()<br>' .
				'<b>Info:</b> ' . $stmt->errorInfo()[2]
			);

		}

	}

	// delete domain

	function delete_domain( $id ) {

		// get domain information

		$domain = get_domain_by_id( $id );

		$pdo = get_db_connection();

		// delete all users of this domain

		$stmt_1 = $pdo->prepare( "DELETE FROM accounts WHERE domain = :domain" );

		// bind params to query

		$stmt_1->bindParam( ':domain', $domain );

		if ( $stmt_1->execute() ) {

			// query successful - delete all aliases of this domain

			$stmt_2 = $pdo->prepare( "DELETE FROM aliases WHERE destination_domain = :domain" );

			// bind params to query

			$stmt_2->bindParam( ':domain', $domain );

			if ( $stmt_2->execute() ) {

				// query successful - delete domain itself

				$stmt_3 = $pdo->prepare( "DELETE FROM domains WHERE domain = :domain" );

				// bind params to query

				$stmt_3->bindParam( ':domain', $domain );

				if ( $stmt_3->execute() ) {

					// query successful - close database connection

					$pdo = NULL;

					// display success message

					echo 'Successfully deleted domain ' . $domain;

				} else {

					// deleting domain failed - display error message

					die(
						'Error in functions.php - Function: delete_domain() - could not delete domain<br>' .
						'<b>Info:</b> ' . $stmt_3->errorInfo()[2]
					);

				}

			} else {

				// deleting aliases failed - display error message

				die(
					'Error in functions.php - Function: delete_domain() - could not delete aliases of domain<br>' .
					'<b>Info:</b> ' . $stmt_2->errorInfo()[2]
				);

			}

		} else {

			// deleting domain failed - display error message

			die(
				'Error in functions.php - Function: delete_domain() - could not delete users of domain<br>' .
				'<b>Info:</b> ' . $stmt_1->errorInfo()[2]
			);

		}

	}

	// delete tls policy

	function delete_tls_policy( $id ) {

		$pdo = get_db_connection();

		$stmt = $pdo->prepare( "DELETE FROM tlspolicies WHERE id = :id" );

		// bind params to query

		$stmt->bindParam( ':id', $id );

		if ( $stmt->execute() ) {

			// query successful - close database connection

			$pdo = NULL;

			// display success message

			echo 'Successfully deleted policy';

		} else {

			// query failed - display error message

			die(
				'Error in functions.php - Function: delete_tls_policy()<br>' .
				'<b>Info:</b> ' . $stmt->errorInfo()[2]
			);

		}

	}



	/****** UPDATE STUFF ******/



	// update user data

	function update_userdata( $id, $password, $quota, $enabled, $sendonly, $admin ) {

		$pdo = get_db_connection();

		$stmt = $pdo->prepare( "UPDATE accounts SET password = :password, quota = :quota, enabled = :enabled, sendonly = :sendonly, admin = :admin WHERE id = :id" );

		// bind params to query

		$stmt->bindParam( ':id', $id );
		$stmt->bindParam( ':password', $password );
		$stmt->bindParam( ':quota', $quota );
		$stmt->bindParam( ':enabled', $enabled );
		$stmt->bindParam( ':sendonly', $sendonly );
		$stmt->bindParam( ':admin', $admin );

		if ( $stmt->execute() ) {

			// query successful - close database connection

			$pdo = NULL;

			// display success message

			echo '<p>' . 'Successfully updated account' . '</p>';

		} else {

			// query failed - display error message

			die(
				'Error in functions.php - Function: update_userdata()<br>' .
				'<b>Info:</b> ' . $stmt->errorInfo()[2]
			);

		}

	}



	/****** CHECK STUFF ******/



	// check db installation

	function check_installation() {

		$pdo = get_db_connection();

		// check for domains table

		$stmt = $pdo->prepare( "SELECT 1 FROM domains" );

		try {
			$stmt->execute();
		} catch (Exception $ex){
			return false;
		}

		if ( $stmt->execute() ) {

			// domains table is present - now check for admin column in accounts table

			if ( count( $pdo->query( "SHOW COLUMNS FROM `accounts` LIKE 'admin'" )->fetchAll() ) ) {

				return true;

			} else {

				// no admin column - quickly alter accounts table

				$alter_stmt = $pdo->prepare( "ALTER TABLE accounts ADD admin boolean DEFAULT '0'" );

				if ( $alter_stmt->execute() ) {

					return true;

				} else {

					// can't create admin column - i don't know what to do anymore...

					die( 'Something went horribly wrong. Maybe consider a fresh install?' );

				}

			}

		} else {

			return false;

		}

		// close db connection

		$pdo = NULL;

	}

	// check if user is admin

	function is_admin( $id ) {

		$pdo = get_db_connection();

		$stmt = $pdo->prepare( "SELECT admin FROM accounts WHERE id = :id" );

		// bind params to query

		$stmt->bindParam( ':id', $id );

		if ( $stmt->execute() ) {

			// query successful - fetch data

			$result = $stmt->fetchAll( PDO::FETCH_ASSOC );

			// close database connection

			$pdo = NULL;

			// return true or false wether user is admin

			if ( $result['0']['admin'] == '1' ) {

				// user is admin - return true

				return true;

			} else {

				// user is no admin - return false

				return false;

			}

		} else {

			// query failed - display error message

			die(
				'Error in functions.php - Function: is_admin()<br>' .
				'<b>Info:</b> ' . $stmt->errorInfo()[2]
			);

		}

	}



	/****** ADDITIONAL FUNCTIONS ******/



	// show domain selection

	function domain_selection() {

		$domains = get_domains();

		echo '<select name="d">';

		foreach ( $domains as $domain ) {

			echo '<option value="' . $domain['domain'] . '"';

			if ( isset( $_GET['d'] ) && $_GET['d'] == $domain['domain'] ) echo 'selected';

			echo '>' . $domain['domain'] . '</option>';

		}

		echo '</select>';

	}

?>
