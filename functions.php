<?php

	// Gathers headers, normalizes key casing, and return resulting array
	function collect_headers ( $domain, $protocol = "http" ) {

		$headers = get_headers( $protocol . "://" . $domain, 1 );

		return array_change_key_case( $headers, CASE_LOWER );

	}

	// Return all values from $master whose $key appears in $keys
	function array_intersect_key_to_value ( $master, $keys ) {

		$output = [];

		foreach ( $keys as $key ) {
			$output[ $key ] = array_key_exists( $key, $master ) ? $master[ $key ] : "";
		}

		return $output;

	}

	// Quick templating function using basic handlebars-style syntax
	// Pass markup in as $template, and viewmodel in as $data
	function template ( $template, $data ) {

		global $tmpl_dir;

		// ex: {{ domain }}, or {{ cache-control }}
		$pattern = "/{{\s?([a-z-]+)\s?}}/i";

		return preg_replace_callback( $pattern, function ( $m ) use ($data) {
			
			$return = "";

			if ( array_key_exists( $m[1], $data ) ) {
				$return = $data[ $m[1] ];
				if ( is_array( $return ) ) {
					$return = join( "<br>\r\n", $return );
				}
			}

			return $return;

		}, file_get_contents( $tmpl_dir . $template . ".tmpl" ) );

	}

	// This function is responsible for quantifying directives
	function log_directives ( $source ) {

		global $directive_use;

		if ( is_array( $source ) ) {
			$source = join( ",", $source );
		}

		// Would love to extend this to check values too
		// 0 or Negative Expirations, and Pragma: no-cache specifically
		preg_match_all("/([a-z-]+)/i", $source, $matches);

		foreach( $matches[1] as $directive ) {
			if ( ! array_key_exists( $directive, $directive_use ) ) {
				$directive_use[ $directive ] = 0;
			}
			$directive_use[ $directive ] += 1;
		}
		
	}

	// This shows the end result for most-used directives
	function build_summary_box () {

		global $tmpl_dir, $directive_use;

		$sum = array_sum( $directive_use );

		arsort( $directive_use, SORT_NUMERIC );
		
		foreach ( $directive_use as $key => $value ) {
			$percent = number_format( 100 * ($value/$sum), 2 );
			$directive_use[ $key ] = "$value ($percent%)";
		}

		require( $tmpl_dir . "summary.php" );

	}
