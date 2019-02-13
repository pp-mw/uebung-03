<?php
/**
 * Footer
 *
 * @package AGSV
 **/

?>
<footer id="footer">


	<nav class="footer-menu row">
		<ul id="footer-nav">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer-nav',
					'container'      => '',
					'items_wrap'     => '%3$s',
					'depth'          => 1,
				)
			);
			?>
		</ul>
		</nav>

</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
