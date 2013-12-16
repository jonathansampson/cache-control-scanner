<?php

	// Gathers headers, normalizes key casing, and return resulting array
	function collect_headers( $domain, $protocol = "http" ) {
		$headers = get_headers( $protocol . "://" . $domain, 1 );
		return array_change_key_case( $headers, CASE_LOWER );
	}

	// Return all values from $master whose $key appears in $keys
	function array_intersect_key_to_value( $master, $keys ) {
		$output = [];
		foreach ( $keys as $key ) {
			$output[ $key ] = array_key_exists( $key, $master ) ? $master[ $key ] : "";
		}
		return $output;
	}

	// Quick templating function using basic handlebars-style syntax
	// Pass markup in as $template, and viewmodel in as $data
	function template( $template, $data ) {

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
