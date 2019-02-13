<?php
/**
 * ACF Funktionen
 *
 *  @package AGSV
 **/


/**
 * Gibt die Inhalte eines Editors der flexiblen ACF Felder zurück
 *
 * @param string $flexible ACF Objekt des Abschnitts.
 */
function get_acf_editor( $flexible ) {

	 $content = $flexible['editor'];
	 $content = '<section class="text">' . $content . '</section>';

	 return $content;
}


/**
 * Gibt die Inhalte eines Abschnitts der flexiblen ACF Felds zurück
 *
 * @param string $flexible ACF Objekt des Abschnitts.
 */
function get_flexible_row( $flexible ) {

	$get_tag = new HtmlMaker();
	$content = false;

	foreach ( $flexible as $row ) {

		if ( isset( $row['acf_fc_layout'] ) && function_exists( 'get_acf_' . $row['acf_fc_layout'] ) ) {

			$content .= call_user_func( 'get_acf_' . $row['acf_fc_layout'], $row );

		}
	}

	return $content;
}

/**
 * Gibt die Inhalte eines flexiblen ACF Felds zurück
 *
 * @param string $field ACF Feld, das verwendet werden soll.
 */
function get_flexible_content( $field ) {

	$flexible = get_field_object( $field );
	$content  = false;

	if ( is_array( $flexible ) && isset( $flexible['value'] ) && is_array( $flexible['value'] ) ) {

		$content = get_flexible_row( $flexible['value'] );

		return $content;

	}

	return false;
}

/**
 * Gibt die Inhalte eines flexiblen ACF Felds aus
 *
 * @param string $field ACF Feld, das verwendet werden soll.
 */
function the_flexible_content( $field ) {

	echo get_flexible_content( $field );
}
