<?php
/**
 * Template Name: Suche
 *
 * @package AGSV
 **/

get_header();
?>
<main class="main-content" id="content" content="true">
	<?php
	the_breadcrumb();
	$s = filter_input( INPUT_POST, 's', FILTER_SANITIZE_SPECIAL_CHARS );
	echo '<section class="headline"><h1>Suchergebnisse für "' . $s . '"</h1></section>';
	echo '<section class="search-result">';


	$swp_query = new SWP_Query(
		array(
			's' => $s,
		)
	);
	if ( ! empty( $swp_query->posts ) ) {
		foreach ( $swp_query->posts as $post ) {
			setup_postdata( $post );
			echo '<article><a href="' . esc_url( get_permalink() ) . '">';
			the_title( '<p>', '</p>' );

			if ( get_the_excerpt() ) {
				echo excerpt( 55 );
			} else {
				while ( have_rows( 'flexible' ) ) {
					the_row();

					if ( get_row_layout() === 'editor' && get_sub_field( 'editor' ) ) {

						$content = get_sub_field( 'editor' );
						echo excerpt( 55, $content );

						break;
					}
				}
			}
			echo '</a></article>';
		}
		wp_reset_postdata();
	} else {
		echo '<h2>Nichts gefunden.</h2>';
	}
		echo '</section>';
	?>
</main>
</div>
<?php
get_footer();
