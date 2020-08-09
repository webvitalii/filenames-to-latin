<?php
/*
Plugin Name: Filenames to latin
Plugin URI: https://wordpress.org/plugins/filenames-to-latin/
Description: Sanitize Cyrillic (Ukrainian, Russian, Belorussian), German, French, Polish, Spanish, Hungarian, Czech, Slovak, Greek, Swedish, Finnish, Latvian, Estonian, Mongolian, Bosnian, Croatian, Serbian, Montenegrin and other filenames to latin during upload.
Version: 2.7
Author: webvitaly
Author URI: http://web-profile.net/wordpress/plugins/
License: GPLv3
*/
function filenames_to_latin_plugin_sanitize( $filename ) {
	$chars_table = array(
		// Cyrillic alphabet
		'/А/' => 'a', '/Б/' => 'b', '/В/' => 'v', '/Г/' => 'g', '/Д/' => 'd',
		'/а/' => 'a', '/б/' => 'b', '/в/' => 'v', '/г/' => 'g', '/д/' => 'd',
		'/Е/' => 'e', '/Ж/' => 'zh', '/З/' => 'z', '/И/' => 'i', '/Й/' => 'j',
		'/е/' => 'e', '/ж/' => 'zh', '/з/' => 'z', '/и/' => 'i', '/й/' => 'j',
		'/К/' => 'k', '/Л/' => 'l', '/М/' => 'm', '/Н/' => 'n', '/О/' => 'o',
		'/к/' => 'k', '/л/' => 'l', '/м/' => 'm', '/н/' => 'n', '/о/' => 'o',
		'/П/' => 'p', '/Р/' => 'r', '/С/' => 's', '/Т/' => 't', '/У/' => 'u',
		'/п/' => 'p', '/р/' => 'r', '/с/' => 's', '/т/' => 't', '/у/' => 'u',
		'/Ф/' => 'f', '/Х/' => 'h', '/Ц/' => 'c', '/Ч/' => 'ch', '/Ш/' => 'sh',
		'/ф/' => 'f', '/х/' => 'h', '/ц/' => 'c', '/ч/' => 'ch', '/ш/' => 'sh',
		'/Щ/' => 'shch', '/Ь/' => '', '/Ю/' => 'ju', '/Я/' => 'ja',
		'/щ/' => 'shch', '/ь/' => '', '/ю/' => 'ju', '/я/' => 'ja',
		// Ukrainian
		'/Ґ/' => 'g', '/Є/' => 'ye', '/І/' => 'i', '/Ї/' => 'yi',
		'/ґ/' => 'g', '/є/' => 'ye', '/і/' => 'i', '/ї/' => 'yi',
		// Russian
		'/Ё/' => 'yo', '/Ы/' => 'y', '/Ъ/' => '', '/Э/' => 'e',
		'/ё/' => 'yo', '/ы/' => 'y', '/ъ/' => '', '/э/' => 'e',
		// Belorussian
		'/Ў/' => 'u',
		'/ў/' => 'u',
		// Polish
		'/Ą/' => 'a', '/Ć/' => 'c', '/Ę/' => 'e', '/Ł/' => 'l', '/Ń/' => 'n',
		'/ą/' => 'a', '/ć/' => 'c', '/ę/' => 'e', '/ł/' => 'l', '/ń/' => 'n',
		'/Ó/' => 'o', '/Ś/' => 's', '/Ź/' => 'z', '/Ż/' => 'z',
		'/ó/' => 'o', '/ś/' => 's', '/ź/' => 'z', '/ż/' => 'z',
		// Swedish, Finnish, Hungarian, Estonian
		'/Ä/' => 'a',
		'/ä/' => 'a',
		'/Ö/' => 'o',
		'/ö/' => 'o',
		'/Ü/' => 'u',
		'/ü/' => 'u',
		// Hungarian
		'/Ő/' => 'o',
		'/ő/' => 'o',
		'/Ű/' => 'u',
		'/ű/' => 'u',
		// Czech
		'/Ě/' => 'e', '/Š/' => 's', '/Č/' => 'c', '/Ř/' => 'r', '/Ž/' => 'z',
		'/ě/' => 'e', '/š/' => 's', '/č/' => 'c', '/ř/' => 'r', '/ž/' => 'z',
		'/Ý/' => 'y', '/Á/' => 'a', '/É/' => 'e', '/Ď/' => 'd', '/Ť/' => 't',
		'/ý/' => 'y', '/á/' => 'a', '/é/' => 'e', '/ď/' => 'd', '/ť/' => 't',
		'/Ň/' => 'n', '/Ú/' => 'u', '/Ů/' => 'u',
		'/ň/' => 'n', '/ú/' => 'u', '/ů/' => 'u',
		// Latvian
		'/Ā/' => 'aa', '/Ē/' => 'ee', '/Ū/' => 'uu', '/Ī/' => 'ii',
		'/ā/' => 'aa', '/ē/' => 'ee', '/ū/' => 'uu', '/ī/' => 'ii',
		'/Ō/' => 'o', '/Ŗ/' => 'r', '/Ģ/' => 'g',
		'/ō/' => 'o', '/ŗ/' => 'r', '/ģ/' => 'g',
		'/Ķ/' => 'k', '/Ļ/' => 'l',
		'/ķ/' => 'k', '/ļ/' => 'l',
		'/Ņ/' => 'n', '/ņ/' => 'n',
		// Slovak
		'/Ĺ/' => 'l', '/Ľ/' => 'l', '/Ŕ/' => 'r',
		'/ĺ/' => 'l', '/ľ/' => 'l', '/ŕ/' => 'r',
		
		// Bosnian, Croatian, Serbian, Montenegrin
		'/Đ/' => 'dj',
		'/đ/' => 'dj',
		// Greek alphabet & modern polytonic characters
		'/Α/' => 'a', '/Β/' => 'v', '/Γ/' => 'g', '/Δ/' => 'd', '/Ε/' => 'e',
		'/α/' => 'a', '/β/' => 'v', '/γ/' => 'g', '/δ/' => 'd', '/ε/' => 'e',
		'/Ζ/' => 'z', '/Η/' => 'i', '/Θ/' => 'th', '/Ι/' => 'i', '/Κ/' => 'k',
		'/ζ/' => 'z', '/η/' => 'i', '/θ/' => 'th', '/ι/' => 'i', '/κ/' => 'k',
		'/Λ/' => 'l', '/Μ/' => 'm', '/Ν/' => 'n', '/Ξ/' => 'x', '/Ο/' => 'o',
		'/λ/' => 'l', '/μ/' => 'm', '/ν/' => 'n', '/ξ/' => 'x', '/ο/' => 'o',
		'/Π/' => 'p', '/Ρ/' => 'r', '/Σ/' => 's', '/Τ/' => 't', '/Υ/' => 'y',
		'/π/' => 'p', '/ρ/' => 'r', '/σ/' => 's', '/τ/' => 't', '/υ/' => 'y',
		'/Φ/' => 'f', '/Χ/' => 'ch', '/Ψ/' => 'ps', '/Ω/' => 'o', '/Ά/' => 'a',
		'/φ/' => 'f', '/χ/' => 'ch', '/ψ/' => 'ps', '/ω/' => 'o', '/ά/' => 'a',
		'/Έ/' => 'e', '/Ή/' => 'i', '/Ί/' => 'i', '/Ό/' => 'o', '/Ύ/' => 'y',
		'/έ/' => 'e', '/ή/' => 'i', '/ί/' => 'i', '/ό/' => 'o', '/ύ/' => 'y',
		'/Ώ/' => 'o', '/Ϊ/' => 'i', '/Ϋ/' => 'y',
		'/ώ/' => 'o', '/ς/' => 's', '/ΐ/' => 'i', '/ϊ/' => 'i', '/ϋ/' => 'y', '/ΰ/' => 'y',
		// Extra chars (http://www.atm.ox.ac.uk/user/iwi/charmap.html)
		'/À/' => 'a', '/Á/' => 'a', '/Â/' => 'a', '/Ã/' => 'a', '/Å/' => 'a',
		'/à/' => 'a', '/á/' => 'a', '/â/' => 'a', '/ã/' => 'a', '/å/' => 'a',
		'/å/' => 'a', '/Å/' => 'a',
		'/Æ/' => 'ae', '/Ç/' => 'c', '/È/' => 'e', '/É/' => 'e', '/Ê/' => 'e',
		'/æ/' => 'ae', '/ç/' => 'c', '/è/' => 'e', '/é/' => 'e', '/ê/' => 'e',
		'/Ë/' => 'e', '/Ì/' => 'i', '/Í/' => 'i', '/Î/' => 'i', '/Ï/' => 'i',
		'/ë/' => 'e', '/ì/' => 'i', '/í/' => 'i', '/î/' => 'i', '/ï/' => 'i',
		'/Ð/' => 'd', '/Ñ/' => 'n', '/Ò/' => 'o', '/Ô/' => 'o', '/Õ/' => 'o',
		'/ð/' => 'd', '/ñ/' => 'n', '/ò/' => 'o', '/ô/' => 'o', '/õ/' => 'o',
		'/ó/' => 'o', '/Ó/' => 'o',
		'/×/' => 'x', '/Ø/' => 'o', '/Ù/' => 'u', '/Ú/' => 'u', '/Û/' => 'u',
		'/×/' => 'x', '/ø/' => 'o', '/ù/' => 'u', '/ú/' => 'u', '/û/' => 'u',
		'/Þ/' => 'p', '/Ÿ/' => 'y',
		'/þ/' => 'p', '/ÿ/' => 'y',
		// Other
		'/№/' => '', '/“/' => '', '/”/' => '', '/«/' => '', '/»/' => '',
		'/„/' => '', '/@/' => '', '/%/' => '', '/‘/' => '', '/’/' => '',
		'/`/' => '', '/´/' => '', '/º/' => 'o', '/ª/' => 'a',
	);
	// override some chars for some languages
	$locale = get_locale();
	switch ( $locale ) {
		case 'uk_UA': // Ukrainian
		case 'uk_ua':
		case 'uk':
			$chars_table_ext = array(
				'/Г/' => 'h',
				'/г/' => 'h',
				'/И/' => 'y',
				'/и/' => 'y'
			);
			$chars_table = array_merge( $chars_table, $chars_table_ext );
			break;
		case 'bg_BG': // Bulgarian
		case 'bg_bg':
			$chars_table_ext = array(
				'/Щ/' => 'sht',
				'/щ/' => 'sht',
				'/Ъ/' => 'a',
				'/ъ/' => 'a'
			);
			$chars_table = array_merge( $chars_table, $chars_table_ext );
			break;
		case 'lv_LV': // Latvian
		case 'lv_lv':
		case 'lv':
			$chars_table_ext = array(
				'/Š/' => 'sh',
				'/š/' => 'sh',
				'/Ž/' => 'zh',
				'/ž/' => 'zh',
				'/Č/' => 'ch',
				'/č/' => 'ch'
			);
			$chars_table = array_merge( $chars_table, $chars_table_ext );
			break;
		case 'mn': // Mongolian
			$chars_table_ext = array(
				'/Е/' => 'ye',
				'/е/' => 'ye',
				'/Ё/' => 'yo',
				'/ё/' => 'yo',
				'/Ж/' => 'j',
				'/ж/' => 'j',
				'/Й/' => 'i',
				'/й/' => 'i',
				'/Х/' => 'kh',
				'/х/' => 'kh',
				'/Ъ/' => 'i',
				'/ъ/' => 'i',
				'/Ь/' => 'i',
				'/ь/' => 'i',
				'/Ц/' => 'ts',
				'/ц/' => 'ts',
				'/Ю/' => 'yu',
				'/ю/' => 'yu',
				'/Я/' => 'ya',
				'/я/' => 'ya',
				'/Ө/' => 'o',
				'/ө/' => 'o',
				'/Ү/' => 'u',
				'/ү/' => 'u'
			);
			$chars_table = array_merge( $chars_table, $chars_table_ext );
			break;
		case 'de': // German
		case 'de_DE':
		case 'de_AT': // German (Austria)
		case 'de_CH': // German (Switzerland)
			$chars_table_ext = array(
				'/Ä/' => 'ae',
				'/ä/' => 'ae',
				'/Ö/' => 'oe',
				'/ö/' => 'oe',
				'/Ü/' => 'ue',
				'/ü/' => 'ue',
				'/ß/' => 'ss'
			);
			$chars_table = array_merge( $chars_table, $chars_table_ext );
			break;
	}
	$friendly_filename = preg_replace( array_keys( $chars_table ), array_values( $chars_table ), $filename ); // replace original chars in filename with friendly chars
	return strtolower( $friendly_filename );
}
add_filter( 'sanitize_file_name', 'filenames_to_latin_plugin_sanitize', 10 );
function filenames_to_latin_plugin_row_meta( $links, $file ) { // add links to plugin meta row
	if ( $file == plugin_basename( __FILE__ ) ) {
		$row_meta = array(
			'support' => '<a href="http://web-profile.net/wordpress/plugins/filenames-to-latin/" target="_blank">' . __( 'Filenames to latin', 'filenames-to-latin' ) . '</a>',
			'donate' => '<a href="http://web-profile.net/donate/" target="_blank">' . __( 'Donate', 'filenames-to-latin' ) . '</a>'
		);
		$links = array_merge( $links, $row_meta );
	}
	return (array) $links;
}
add_filter( 'plugin_row_meta', 'filenames_to_latin_plugin_row_meta', 10, 2 );
