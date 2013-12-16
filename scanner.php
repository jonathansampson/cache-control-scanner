<!DOCTYPE html>
<html>
<head>
	<title>Scanner</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
<?php

	require "domains.php";
	require "functions.php";
	
	$tmpl_dir = "templates/";

	// For testing, randomize and truncate
	shuffle($domains);
	$domains = array_slice( $domains, 0, 5 );

	// Headers we are primarily interested in
	$fields = [ "expires", "pragma", "cache-control", "date" ];

	echo template( "header", $fields );

	foreach ( $domains as $domain ) {

		// Gets normalized response header arrays
		$headers = collect_headers( $domain );

		// Filteres headers to get only those mentioned in $fields
		$model = array_intersect_key_to_value( $headers, $fields );

		// Templates expect a domain index; modifying viewmodel
		$model["domain"] = $domain;

		echo template( "record", $model );

		// We're dealing with a lot of output, flush regularly
		flush();

	}

?>
</body>
</html>
