<?php
/**
 * Suchergebnisse
 *
 * @package AGSV
 **/

get_header();
?>
<main class="main-content" id="content" content="true">
	<?php
	the_breadcrumb();
	echo '<section class="headline"><h1>Suchergebnisse für "' . get_search_query() . '"</h1></section>';
	echo '<section class="search-result">';
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			echo '<article><a class="result" href="' . esc_url( get_permalink() ) . '">';
			the_title( '<h3>', '</h3>' );

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
	} else {
		echo '<h2>Nichts gefunden.</h2>';
	}

	echo '</section>';
	?>
</main>
</div>
<?php get_footer(); ?>
