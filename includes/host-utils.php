<?php

function get_server_config() {
	$HTTP_HOST = $_SERVER['HTTP_HOST'];

	$isStagingServer = str_contains($HTTP_HOST, 'staging-website.coschedule.com');

	$isLocalServer = str_contains($HTTP_HOST, '.local');

  if ( $isStagingServer ) {
		return [
			'env_name' => 'staging',
		];
	} else if ( $isLocalServer ) {
		return [
			'env_name' => 'local',
		];
	} else {
    return [
			'env_name' => 'production',
		];
		die();
	}
}

?>
