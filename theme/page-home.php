<?php

/**
 * The template for the frontpage
 *
 * This is the template that displays all pages by default. Please note that
 * this is the WordPress construct of pages: specifically, posts with a post
 * type of `page`.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ouvrages-wp
 */

get_header();
?>


<main id="main" class="col-span-4 xl:col-span-8 mx-8 lg:mx-0">

	<?php

	/* Start the Loop */
	while (have_posts()) :
		the_post();
	?>


		<div class="col-span-8 lg:col-span-4 ">

			<article id="post-<?php the_ID(); ?>" <?php post_class(' grid grid-cols-4 gap-4 content-center pt-20'); ?>>

				<h1 class="font-light col-span-4 lowercase ml-0 sm:ml-4">
					<?php echo get_bloginfo('name'); ?>
				</h1>

				<div <?php ouvrages_wp_content_class('entry-content col-start-1 col-span-4 col-start-1 sm:col-span-3 sm:col-start-2 xl:col-start-2 xl:col-span-2 mt-8 project-scroll'); ?>>


					<?php the_content(); ?>

					<?php get_template_part('template-parts/content/content', 'customfields'); ?>



					<div class="p-2 col-start-1 col-span-4  sm:col-span-3 sm:col-start-2 xl:col-start-2 xl:col-span-2 mt-8 bg-schoberDarkRed ">

						<h4 class="font-bold text-white mt-0">Neuester Beitrag</h4>
						<?php

						$recent_posts = wp_get_recent_posts(array(
							'numberposts' => 1, // Number of recent posts thumbnails to display
							'post_status' => 'publish' // Show only the published posts
						));
						foreach ($recent_posts as $recent) {
							echo '<a class="link-white"  href="' . get_permalink($recent["ID"]) . '">' . get_the_title($recent["ID"]) . '</a>';
						}
						?>
					</div>

				</div><!-- .entry-content -->



			</article><!-- #post-<?php the_ID(); ?> -->
		</div>

		<div class="hidden lg:block col-span-4 relative overflow-hidden">
			<?php
			if (has_post_thumbnail()) {
				$large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
			}
			?>

			<img src="<?php echo $large_image_url[0]; ?>" class="h-screen block object-cover w-max absolute right-0">
		</div>

	<?php

	endwhile; // End of the loop.
	?>

</main><!-- #main -->


<?php
get_footer();
