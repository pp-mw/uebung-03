<?php
/**
 * Seite
 *
 * @package AGSV
 **/

get_header();
?>
<main class="main-content" id="content" content="true">
	<?php
	the_breadcrumb();
	the_title( '<section class="headline"><h1>', '</h1></section>' );
	the_content();
	?>
</main>
</div>
<?php
get_footer();
