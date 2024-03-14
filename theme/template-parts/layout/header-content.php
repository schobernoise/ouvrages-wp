<?php

/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ouvrages-wp
 */

?>
<div class="pt-8 col-span-2 bg-schoberDarkRed text-white h-screen text-center overflow-hidden ">
	<header id="masthead" class=" grid grid-cols-2 gap-4">


		<?php
		$custom_logo_id = get_theme_mod('custom_logo');
		$logoUrl = wp_get_attachment_image_src($custom_logo_id, 'full');
		?>
		<div id="menu-content" class="col-start-2">
			<img src="<?php echo $logoUrl[0]; ?>" class="w-14 mx-auto mb-4">

			<nav id="site-navigation" class="mx-auto" aria-label="<?php esc_attr_e('Main Navigation', 'ouvrages-wp'); ?>">

				<!-- <div class="w-24"> -->
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
						'items_wrap'     => '<ul id="%1$s" class="%2$s" aria-label="submenu">%3$s</ul>',
					)
				);
				?>
				<!-- </div> -->


			</nav>
		</div>



	</header><!-- #masthead -->
</div>