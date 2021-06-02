<?php

	// forbid direct file access

	if ( !defined( 'CALLED_FROM_INDEX' ) || !is_admin( $_SESSION['user'] ) ) {

		header( 'Location: ../' );
		die( 'You can\'t access this file directly.' );

	}

	// check what to delete

	if ( isset( $_GET['account'] ) ) {
		
		// check if user wants to delete himself

		if ( $_GET['account'] != $userid ) {

			// different user - delete account

			delete_account( $_GET['account'] );

		} else {

			header( 'Location: ./?p=accounts&err=' . urlencode( 'You can\'t delete yourself.' ) );

		}
		
	} elseif ( isset( $_GET['alias'] ) ) {
		
		// delete alias
		
		delete_alias( $_GET['alias'] );
		
	} elseif( isset( $_GET['domain'] ) ) {
		
		// delete domain
		
		delete_domain( $_GET['domain'] );
		
	} elseif ( isset( $_GET['policy'] ) ) {

		// delete policy

		delete_tls_policy( $_GET['policy'] );

	} else {
		
		// nothing set - go back to home
		
		header( 'Location: ./' );
		
	}

?>
