<?php

/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ouvrages-wp
 */

?>
<div class="pt-8 hidden md:block md:col-span-1 xl:col-span-2 bg-schoberDarkRed text-white h-screen text-center sticky top-0">
	<header id="masthead" class=" grid grid-cols-1 xl:grid-cols-2 gap-4 sticky top-0">
		<?php
		$custom_logo_id = get_theme_mod('custom_logo');
		$logoUrl = wp_get_attachment_image_src($custom_logo_id, 'full');
		?>
		<div id="menu-content" class="xl:col-start-2 sticky top-0">
			<a href="<?php echo home_url(); ?>" class="sticky top-0">
				<img src="<?php echo $logoUrl[0]; ?>" class="w-14 mx-auto mb-4 sticky top-0"></a>

			<nav id="site-navigation" class="mx-auto text-white font-medium sticky top-0" aria-label="<?php esc_attr_e('Main Navigation', 'ouvrages-wp'); ?>">

				<!-- <div class="w-24"> -->
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
						'items_wrap'     => '<ul id="%1$s" class="%2$s sticky top-0" aria-label="submenu">%3$s</ul>',
					)
				);
				?>
				<!-- </div> -->


			</nav>
		</div>



	</header><!-- #masthead -->
</div>