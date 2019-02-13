<?php
/**
 * Allgemeine Theme Funktionen
 *
 * @package AGSV
 **/

// ACF.
require_once 'template-parts/acf-definitions.php';
require_once 'template-parts/acf-functions.php';
// Breadcrumb.
require_once 'template-parts/breadcrumb.php';
// HTML Maker laden.
require_once 'template-parts/html-maker.php';
// Kommentare deaktivieren.
require_once 'template-parts/disable-comments.php';
// Navigations-Funktionen bereitstellen.
require_once 'template-parts/nav-walkers.php';
// Funktionen für responsive Bilder.
require_once 'template-parts/picture-functions.php';
// Funktionen für Mailvdrsand.
require_once 'template-parts/mailform.php';
// Title Tag aktiveren.
add_theme_support( 'title-tag' );
// Beitragsbild aktiveren.
add_theme_support( 'post-thumbnails' );
// Bildgrößen registrieren.
add_image_size( 'box_image', 400, 400, true );
add_image_size( 'person_image', 200, 300, true );
// add_image_size( 'content', 900, 9999, true );
// add_image_size( 'slider-small', 320, 160, true );
// add_image_size( 'slider-medium', 768, 384, true );
// add_image_size( 'slider-large', 1024, 512, true );
// add_image_size( 'slider-xlarge', 1440, 770, true );
/**
 * Disable gutenberg style in Front
 **/
function wps_deregister_styles() {
	wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );
/**
 * Entfernt die WP Versionsangaben
 *
 * @param str $src Pfad zur Datei.
 * @param str $handle Handle der Datei.
 */
function ww_remove_ver_css_js( $src, $handle ) {
	$handles_with_version = [ 'ww-script', 'ww-style' ];

	if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) ) {
		$src = remove_query_arg( 'ver', $src );
	}

	return $src;
}
add_filter( 'style_loader_src', 'ww_remove_ver_css_js', 9999, 2 );
add_filter( 'script_loader_src', 'ww_remove_ver_css_js', 9999, 2 );

// XML-RPC API für Fernzugriff deaktivieren.
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Emoji aus dem header entfernen
 **/
function ww_disable_emoji_dequeue_script() {
	wp_dequeue_script( 'emoji' );
}
add_action( 'wp_print_scripts', 'ww_disable_emoji_dequeue_script', 100 );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * Head Links entfernen
 **/
function ww_remove_headlinks() {
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
	remove_action( 'wp_head', 'wp_shortlink_header', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
}
add_action( 'init', 'ww_remove_headlinks' );

/**
 * Registriert die Menüs
 **/
function ww_register_menus() {
	// register_nav_menu( 'lang-nav', 'Sprachnavigation' );
	register_nav_menu( 'meta-nav', 'Metanavigation' );
	register_nav_menu( 'main-nav', 'Hauptnavigation' );
	register_nav_menu( 'service-nav', 'Servicenavigation' );
	register_nav_menu( 'footer-nav', 'Footernavigation' );
}
add_action( 'init', 'ww_register_menus' );

/**
 * Registriert die Widgets
 */
function ww_widgets_init() {
	register_sidebar(
		array(
			'name'          => 'Kontakt',
			'id'            => 'contact',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h2>',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Primary' ),
			'id'            => 'primary',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
	// register_sidebar(
	// array(
	// 'name'          => 'Zahlung',
	// 'id'            => 'payment',
	// 'before_widget' => '',
	// 'after_widget'  => '',
	// 'before_title'  => '<h2>',
	// 'after_title'   => '</h2>',
	// )
	// );
	// register_sidebar(
	// array(
	// 'name'          => 'Versand',
	// 'id'            => 'delivery',
	// 'before_widget' => '',
	// 'after_widget'  => '',
	// 'before_title'  => '<h2>',
	// 'after_title'   => '</h2>',
	// )
	// );
}
add_action( 'widgets_init', 'ww_widgets_init' );

/**
 * Liefert die Body Klassen mit Menü-Index
 *
 * @param string  $menu_position Menü-Position des Hauptmenüs.
 * @param integer $post_id Beitrags-ID optional, Standard aktueller Post.
 */
function get_body_class_index( $menu_position, $post_id = false ) {

	$return    = '';
	$locations = get_nav_menu_locations();

	if ( array_key_exists( $menu_position, $locations ) ) {
		$menu       = wp_get_nav_menu_object( $locations[ $menu_position ] );
		$menu_items = wp_get_nav_menu_items( $menu->term_id );
		$post_id    = $post_id ? $post_id : get_the_ID();

		foreach ( $menu_items as $menu_item ) {
			if ( intval( $menu_item->object_id ) === $post_id ) {
				$return = 'p' . esc_attr( $menu_item->menu_order ) . ' ';
				break;
			}
		}
	}

	$return .= is_front_page() ? 'home' : basename( get_permalink() );

	return $return;

}

/**
 * Gibt die Body Klassen mit Menü-Index aus
 *
 * @param string  $menu_position Menü-Position des Hauptmenüs.
 * @param integer $post_id Beitrags-ID optional, Standard aktueller Post.
 */
function the_body_class_index( $menu_position, $post_id = false ) {

		echo esc_attr( get_body_class_index( $menu_position, $post_id = false ) );

}

/**
 * Liefert Array mit Datei inklusive Template Pfad und Änderungsdatum.
 *
 * @param array $src Pfad zur Datei innerhalb des WordPress Verzeichnisses.
 */
function get_src_path_uri_version( $src ) {
	$src      = '/' . rtrim( $src, '/' );
	$src_path = get_template_directory() . $src;
	$src_uri  = get_template_directory_uri() . $src;

	if ( file_exists( $src_path ) ) {
		return array(
			'uri'     => $src_uri,
			'version' => filemtime( $src_path ),
		);
	}

	return false;
}

/**
 * Ruft wp_enqueue_script setzt das Änderungsdatum der Datei als Version.
 *
 * @param array $handle    Name des Scripts.
 * @param array $src       Pfad zum Script innerhalb des aktuellen Template Verzeichnisses.
 * @param array $deps      Abhängigkeiten zu anderen Scripts.
 * @param array $in_footer True wenn Script vor /body statt vor /head ausgegeben werden soll, default false.
 */
function enqueue_script_with_timestamp( $handle, $src, $deps = array(), $in_footer = false ) {
	$src = get_src_path_uri_version( $src );

	if ( $src ) {
		wp_enqueue_script( $handle, $src['uri'], $deps, $src['version'], $in_footer );
	}
}

/**
 * Ruft wp_enqueue_style setzt das Änderungsdatum der Datei als Version.
 *
 * @param array $handle Name des Styles.
 * @param array $src    Pfad zum Style innerhalb des aktuellen Template Verzeichnisses.
 * @param array $deps   Abhängigkeiten zu anderen Styles.
 * @param array $media  Medien, für die das Style gedacht ist, default all.
 */
function enqueue_style_with_timestamp( $handle, $src, $deps = array(), $media = 'all' ) {
	$src = get_src_path_uri_version( $src );

	if ( $src ) {
		wp_enqueue_style( $handle, $src['uri'], $deps, $src['version'], $media );
	}
}

/**
 * Lädt Skripte und Styles.
 */
function enqueue_styles_scripts() {

	// WordPress jQuery entfernen.
	wp_deregister_script( 'jquery' );

	// Aktuelles jQuery registrieren.
	wp_register_script( 'jquery', 'https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js', array(), false, true );

	// Aktuelles jQuery laden.
	wp_enqueue_script( 'jquery' );

	// Haupt-Skript laden.
	enqueue_script_with_timestamp( 'ww-script', 'js/app.min.js', array( 'jquery' ), true );

	// Typekit laden.
	// wp_enqueue_style( 'typekit', 'https://use.typekit.net/afi2yyo.css' );
	// Haupt-Style laden.
	enqueue_style_with_timestamp( 'ww-style', 'css/template.min.css' );

	// SVG-Unterstützung für IE laden.
	wp_enqueue_script( 'svg4everybody', get_template_directory_uri() . '/js/svg4everybody.min.js', array( 'jquery' ), true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_styles_scripts' );

/**
 * Setzt die WP SEO Metabox nach unten.
 */
function filter_yoast_seo_metabox() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'filter_yoast_seo_metabox' );

/**
 * Fügt neue Query Variablen hinzu
 *
 * @param  array $vars Query Variablen.
 */
function custom_query_vars_filter( $vars ) {
	$vars[] = 'rqsnt';
	$vars[] = 'nlsnt';
	return $vars;
}
add_filter( 'query_vars', 'custom_query_vars_filter' );

/**
 * Kurzinhalt individuelle Wortanzahl
 *
 * @param  integer $limit Wortanzahl.
 */
function excerpt( $limit ) {
	$excerpt = explode( ' ', get_the_excerpt(), $limit );
	if ( count( $excerpt ) >= $limit ) {
		array_pop( $excerpt );
		$excerpt = implode( ' ', $excerpt ) . '...';
	} else {
		$excerpt = implode( ' ', $excerpt );
	}
	$excerpt = preg_replace( '`[[^]]*]`', '', $excerpt );
	return $excerpt;
}

function get_html_sitemap() {
	$args = array(
		'public'      => 1,
		'depth'       => 3,
		'sort_column' => 'menu_order',
		'title_li'    => '',
		'exclude'     => 2318,
	);
	echo '<ul>';
	wp_list_pages( $args );
	echo '</ul>';
}
add_shortcode( 'htmlSitemap', 'get_html_sitemap' );

/**
 * Leitet Templates vom Typ accordion or category zur Elternseite weiter
 *
 * @param  object $post Post Objekt.
 */
function redirect_accordion_parent_ww( $post ) {

	$post_hash = '#' . $post->post_name . '-' . $post->ID;

	if ( $post->post_parent ) {
			$parents = get_post_ancestors( $post->ID );

		foreach ( $parents as $id ) {

			$parent_template = get_post_meta( $id, '_wp_page_template', true );

			if ( 'page_category.php' !== $parent_template && 'page_accordion.php' !== $parent_template ) {

				wp_redirect( get_permalink( $id ) . $post_hash );

				exit;

			}
		}
	}

}

/**
 *  Erzeugt das Format-Dropdown im Tiny MCE Editor.
 *
 * @param array $buttons Anzuzeigende Buttons.
 **/
function set_mce_editor_buttons( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter( 'mce_buttons', 'set_mce_editor_buttons' );

/**
 *  Definitionen für Format-Dropdown im Tiny MCE Editor.
 *
 * @param array $settings Style-Definitionen.
 **/
function set_mce_before_init( $settings ) {
	$style_formats             = array(
		array(
			'title'   => 'Zitat',
			'block'   => 'blockquote',
			'wrapper' => true,
		),
	);
	$settings['style_formats'] = wp_json_encode( $style_formats );
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'set_mce_before_init' );

/**
 * Entfernt die Admin Leiste für Abonnent.
 */
function ww_remove_admin_bar() {
	if ( ! current_user_can( 'edit_posts' ) ) {
		show_admin_bar( false );
	}
}

/**
 * Deaktiviert den Admin Zugang für Abonnent.
 */
function ww_disable_dashboard() {

	$request_uri = filter_input( INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_SPECIAL_CHARS );
	if (
		stripos( $request_uri, '/wp-admin/' ) !== false
		&&
		stripos( $request_uri, 'async-upload.php' ) === false
		&&
		stripos( $request_uri, 'admin-ajax.php' ) === false
		&&
		! current_user_can( 'edit_posts' )
	) {
		wp_redirect( home_url() );
		exit;
	}

}

if ( get_current_blog_id() == 2 ) {  // Only apply privacy to blog ID 2
	add_action( 'after_setup_theme', 'ww_remove_admin_bar' );
	add_action( 'admin_init', 'ww_disable_dashboard' );
	add_action( 'wp', 'private_site' );
}

function private_site() {

	$isLoginPage = strpos( $_SERVER['REQUEST_URI'], 'wp-login.php' ) !== false;

	if ( ! is_user_logged_in() && ! is_admin() && ! $isLoginPage ) {
		$location = get_login_redirect_url( get_bloginfo( 'url' ) );
		header( 'Location: ' . $location );
		exit();
	}
}

// Returns the login URL with a redirect link.
function get_login_redirect_url( $url = '' ) {

	$url = esc_url_raw( $url );
	if ( empty( $url ) ) {
		return false;
	}

	// setup query args
	$query_args = array(
		'redirect_to' => urlencode( $url ),
	);
	return add_query_arg( $query_args, apply_filters( 'ass_login_url', wp_login_url() ) );
}

// Link directly to Media files instead of Attachment pages in search results
function ww_search_media_direct_link( $permalink, $post = null ) {
	if ( is_search() && 'attachment' === get_post_type( $post ) ) {
		$permalink = wp_get_attachment_url( $post->ID );
	}
	return esc_url( $permalink );
}
add_filter( 'the_permalink', 'ww_search_media_direct_link', 10, 2 );

// * Remove type tag from script and style
add_filter( 'style_loader_tag', 'codeless_remove_type_attr', 10, 2 );
add_filter( 'script_loader_tag', 'codeless_remove_type_attr', 10, 2 );
function codeless_remove_type_attr( $tag, $handle ) {
	return preg_replace( "/ type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}

if ( ! function_exists( 'write_log' ) ) {
	/**
	 * Schreibt individuellen Inhalt nach wp-content/debug.log
	 *
	 * @param misc $log Inhalt zur Ausgabe.
	 **/
	function write_log( $log ) {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}
