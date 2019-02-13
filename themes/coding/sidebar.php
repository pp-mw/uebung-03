<div id="menu-wrapper">
  <nav class="main-nav" aria-label="<?php _e( 'Hauptmenü', 'ww' ); ?>">
<ul id="main-menu">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'main-nav',
				'walker'         => new Main_Nav_Walker(),
				'container'      => '',
				'items_wrap'     => '%3$s',
				'depth'          => 1,
			)
		);
		?>
</ul>
</nav>

</div>
