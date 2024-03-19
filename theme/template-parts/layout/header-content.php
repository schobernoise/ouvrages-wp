<?php

/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ouvrages-wp
 */

?>

<?php
$custom_logo_id = get_theme_mod('custom_logo');
$logoUrl = wp_get_attachment_image_src($custom_logo_id, 'full');
?>

<!-- Hamburger Icon -->
<div class="mobile-menu-button-wrapper md:hidden mx-auto pl-24 fixed top-0 flex flex-col justify-center items-center z-50 pt-4 w-screen backdrop-blur-2xl">
	<button class="outline-none mobile-menu-button transition duration-500 ease-[cubic-bezier(0.010, 0.950, 0.000, 0.965)] text-2xl text-schoberDarkRed">
		<!-- <img src="<?php echo $logoUrl[0]; ?>" class="w-12 h-12 mb-2"> -->
		fs
	</button>
	<hr class="menu-divider h-0.5 block w-24 bg-schoberDarkRed border-0 mb-0 pb-0 transition duration-500 ease-[cubic-bezier(0.010, 0.950, 0.000, 0.965)]">
</div>


<div class="mobile-menu md:pt-8 hidden md:block md:col-span-1 xl:col-span-2  transition duration-700 ease-[cubic-bezier(0.010, 0.950, 0.000, 0.965)]  bg-schoberDarkRed text-white h-screen w-screen  text-center md:w-36 lg:w-auto lg:relative fixed left-0 top-0 z-40">
	<header id="masthead" class=" grid grid-cols-1 xl:grid-cols-2 gap-4 h-min mt-40">

		<div id="menu-content" class="xl:col-start-2">
			<a href="<?php echo home_url(); ?>">
				<img src="<?php echo $logoUrl[0]; ?>" class="w-8 md:w-14 mx-auto mb-8 "></a>

			<nav id="site-navigation" class="mx-auto text-white font-medium " aria-label="<?php esc_attr_e('Main Navigation', 'ouvrages-wp'); ?>">

				<!-- <div class="w-24"> -->
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
						'items_wrap'     => '<ul id="%1$s" class="%2$s " aria-label="submenu">%3$s</ul>',
					)
				);
				?>
				<!-- </div> -->


			</nav>
		</div>



	</header><!-- #masthead -->
</div>