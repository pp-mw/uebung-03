<?php
/**
 * Navigations-Funktionen
 *
 * @package AGSV
 **/

class Main_Nav_Walker extends Walker_Nav_Menu {
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$has_sub = is_array( $item->classes ) && in_array( 'menu-item-has-children', $item->classes, true );
		$output .= sprintf(
			'<li class="%s%s%s"><a href="%s">%s%s</a>',
			( $item->current ? 'active current ' : ( $item->current_item_ancestor ? 'active ' : null ) ),
			$has_sub ? 'has-sub ' : null,
			'm' . $item->object_id,
			$item->url,
			$item->title,
			$has_sub ? '<i class="s_icon"><svg role="img" class="symbol" aria-hidden="true" focusable="false"><use xlink:href="' . esc_url( get_template_directory_uri() ) . '/img/icons.svg#plus"></use></svg></i>' : null
		);
	}

	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 0 === $depth ) {
$output .= '<ul class="sub-container">';
} elseif ( 1 === $depth ) {
$output .= '<ul class="sub-container l2">';
}
	}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$output .= '</ul>';
	}
}
