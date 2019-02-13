<?php
/**
 * Header
 *
 * @package AGSV
 **/

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js" data-path="<?php echo esc_url( get_template_directory_uri() ); ?>" itemscope itemtype="http://schema.org/WebPage">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php wp_head(); ?>
	</head>

	<body class="<?php the_body_class_index( 'main-menu' ); ?>">
		<div class="outer">
		<ul id="skiplinks">
		  <li><a class="show-on-focus" href="#main-menu">Zum Hauptmenü</a></li>
		  <li><a class="show-on-focus" href="#search">Zur Suche</a></li>
		  <li><a class="show-on-focus" href="#content">Zum Inhalt</a></li>
		  <li><a class="show-on-focus" href="#footer">Zu den Service-Informationen</a></li>
		</ul>
		<header class="expanded row fluid-header">
		  <div class="header">
			<a class="logo" href="<?php echo home_url(); ?>">
			  <img  src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/coding-jour-fixe.svg" alt="Coding Jour Fixe">
			</a>
			<span>
			  Webwerk Coding Jour Fixe
			</span>
			</div>
		</header>
			<!-- Beginn Suche -->
			<div class="fadein-area">
		<div role="search" class="search-bar" id="search">
				<div class="row search-item">
				<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
						<input class="search-field input-focus" name="s" placeholder="Suchbegriff eingeben..." title="Suchbegriff eingeben" value="" type="text">
						<button type="submit" class="btn btn-senden">Suchen</button>
						<button type="button" class="btn btn-cancel">Abbrechen</button>
					</form>
					</div>
				</div>
		<!-- End Suche -->
		<!-- LOG IN -->
			<?php
			$login_data = array(
				'logout'   => null,
				'username' => null,
				'password' => null,
			);
			$login_data = filter_input_array( INPUT_POST );
			$get_logout = filter_input( INPUT_GET, 'logout', FILTER_VALIDATE_BOOLEAN );
			if ( ( is_array( $login_data ) && array_key_exists( 'logout', $login_data ) && $login_data['logout'] ) || $get_logout ) {
				wp_clear_auth_cookie();
				wp_redirect( get_permalink() );
				exit;
			} elseif ( isset( $login_data['username'] ) ) {
				$username = $login_data['username'];
				$pass     = $login_data['password'];
				if ( strpos( $username, '@' ) ) {
					$user = get_user_by( 'email', $username );
				} else {
					$user = get_user_by( 'login', $username );
				}
				if ( $user && wp_check_password( $pass, $user->data->user_pass, $user->ID ) ) {
					wp_set_auth_cookie( $user->ID );
					wp_redirect( get_permalink() );
					exit;
				} else {
					$error = true;
				}
			}
			{
				?>
				<div id="login" <?php echo $error ? 'class="open"' : null; ?>>
					<div class="row login-item">
				<form class="ppjadmin_login" action="<?php the_permalink(); ?>" method="post" id="ppjadmin">
					<div class="user-login">
						<label for="username">E-Mail-Adresse</label>
			<input class="input-focus" id="username" type="text" name="username">
			<?php
			if ( $error ) {
				?>
				<div class="error">Benutzername und/oder Passwort falsch!</div>
				<?php
			}
			?>
			</div>
			<div class="user-pw">
						<label for="password">Passwort</label>
			<input id="password" type="password" name="password">
			</div>
					<div class="user-button">
						<button class="btn-login" type="submit">Login</button>
						<a class="lost-pw" href="<?php echo esc_url( wp_lostpassword_url( get_permalink() ) ); ?>"><span>Passwort vergessen?</span></a>
					</div>
							</form>
					</div>
					</div>
						<?php
						}
			?>
			<!-- END LOG IN -->
			</div>
		<!-- Service Navigation -->
		<div class="header-bar row">
		  <div class="mobile-buttons">
			<button class="toggle menu-button" data-for="menu-main" title="Menü ein-/ausblenden" type="button" aria-haspopup="true" aria-expanded="false">
				<span class="menu-button-box">
				  <span class="menu-button-inner"></span>
				</span>
				<span class="menu-button-label hide-for-small-only">Menü</span>
			  </button>
		  </div>
				<nav class="service-menu">
					<ul id="service-nav">
						<li id="style-toggle">
							<a href="#" id="style-toggle-btn"><svg role="img" class="symbol" aria-hidden="true" focusable="false"><use xlink:href="<?php echo get_template_directory_uri(); ?>/img/icons.svg#contrast1"></use></svg></a>
						</li>
						<li id="style-control">
							<span>Darstellung:</span>
							<a href="#" id="style-normal"><span>normal</span></a><span>&nbsp;/&nbsp;</span>
							<a href="#" id="style-contrast"><span>Kontrast</span></a>
						</li>
						<li id="btn-search">
				  <a class="btn-fade btn-suche" data-area="search" href="#"><svg role="img" class="symbol" aria-hidden="true" focusable="false">
				  <use xlink:href="<?php echo get_template_directory_uri(); ?>/img/icons.svg#search"></use>
				  </svg></a>
			  </li>
			  <li id="btn-contact"><a href="<?php echo home_url( '/kontakt/' ); ?>"><svg role="img" class="symbol" aria-hidden="true" focusable="false"><use xlink:href="<?php echo get_template_directory_uri(); ?>/img/icons.svg#phone"></use></svg></a>
			  </li>
				<?php if ( is_user_logged_in() ) { ?>
			  <li id="btn-logout">
				  <a class="btn-fade btn-logout" href="?logout=true"><svg role="img" class="symbol" aria-hidden="true" focusable="false"><use xlink:href="<?php echo get_template_directory_uri(); ?>/img/icons.svg#logout"></use>
				  </svg></a>
			  </li>
			<?php } else { ?>
				<li id="btn-login">
				  <a class="btn-fade btn-login" data-area="login" href="#"><svg role="img" class="symbol" aria-hidden="true" focusable="false"><use xlink:href="<?php echo get_template_directory_uri(); ?>/img/icons.svg#login-2"></use>
				  </svg></a>
			  </li>
			<?php } ?>
					</ul>
				</nav>
			</div>
			<!-- End Service Navigation -->
			<div class="content row">
		  <nav class="nav-main">
			<ul id="menu-main" class="menu-main">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'main-nav',
								'walker'         => new Main_Nav_Walker(),
								'container'      => '',
								'items_wrap'     => '%3$s',
								'depth'          => 3,
							)
						);
						?>
					</ul>
				</nav>
				<!-- End Hauptnavigation -->
