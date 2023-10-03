<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tailwind_theme
 */

?>

<header id="masthead" class="container flex flex-col mx-auto bg-white">

	<div class="relative flex flex-wrap items-center justify-between w-full bg-white group py-7 shrink-0">
		<div>
		<?php
		if ( is_front_page() ) :
			?>
			<h1><?php bloginfo( 'name' ); ?></h1>
			<?php
		else :
			?>
			<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
		endif;

		$tailwind_theme_description = get_bloginfo( 'description', 'display' );
		if ( $tailwind_theme_description || is_customize_preview() ) :
			?>
			<p><?php echo $tailwind_theme_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
		<?php endif; ?>
	</div>

	<nav id="site-navigation" aria-label="<?php esc_attr_e( 'Main Navigation', 'tailwind-theme' ); ?>" class="items-center justify-between hidden gap-12 text-black md:flex">
		<button aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'tailwind-theme' ); ?></button>

		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
				'items_wrap'     => '<ul id="%1$s" class="%2$s" aria-label="submenu">%3$s</ul>',
			)
		);
		?>
	</nav><!-- #site-navigation -->
	</div>
</header><!-- #masthead -->
