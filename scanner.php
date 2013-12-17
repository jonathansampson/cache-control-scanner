<!DOCTYPE html>
<html>
<head>
	<title>Scanner</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<meter max="100" value="0"></meter>
	<script>
	(function () {

		/*
			Typically this code wouldn't be found here, and
			it wouldn't be as sloppy. Many mutation events
			will be unrelated to our lists, so updating
			the meter wouldn't be necessary. Additionally,
			we need to disconnect the observer eventually.
		*/

		// Hint, don't Lint
		"use strict";

		// getElementsByTagName yields a live NodeList
		var meterEl = document.querySelector( "meter" );
		var uls = document.getElementsByTagName( "ul" );

		// Anytime the childList changes, update meter
		var observer = new MutationObserver(function () {
			// Removing one from uls.length to account for titles
			meterEl.value = uls.length - 1;
		});

		// Observing childList mutation events on document.body
		observer.observe( document.body, { childList: true } );

	}());
	</script>
<?php

	// Lots of domains to query, turn off time limits
	set_time_limit(-1);

	// Resources and Helpers
	require "domains.php";
	require "functions.php";
	
	// This uses a few small templates
	$tmpl_dir = "templates/";

	// For testing, randomize and truncate
	// shuffle($domains);
	// $domains = array_slice( $domains, 0, 15 );

	// Identify the headers we'd like to list
	// Additionally, we'll be storing statistical info in $directive_use
	$fields = [ "expires", "pragma", "cache-control", "date" ];
	$directive_use = [];

	// Spits out one of those templates we just discussed
	echo template( "header", $fields );

	// Time for the fun; begin cycling over each domain
	foreach ( $domains as $domain ) {

		// Gets normalized response header arrays
		$headers = collect_headers( $domain );

		// Filteres headers to get only those mentioned in $fields
		$model = array_intersect_key_to_value( $headers, $fields );

		// Templates expect a domain index; modifying viewmodel
		$model["domain"] = $domain;

		// Oh, another template!
		echo template( "record", $model );

		// This is responsible for collecting those stats from above
		log_directives( $model[ "cache-control" ] );

		// We're dealing with a lot of output, flush regularly
		flush();

	}

	// Stats are then rendered here
	build_summary_box();

?>
</body>
</html>
