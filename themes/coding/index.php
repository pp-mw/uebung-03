<?php
/**
 * Index
 *
 * @package AGSV
 **/

get_header();
?>
<main class="main-content" id="content" content="true">
	<?php
	the_breadcrumb();
	the_title( '<section class="headline"><h1>', '</h1></section>' );
	?>
	<?php
		the_flexible_content( 'flexible' );
	?>
</main>

<?php
get_footer();
