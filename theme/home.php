<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ouvrages-wp
 */

get_header();
?>


<main id="main" class="col-span-8">

	<h1>blog</h1>


	<div class=" col-span-4">
		<!-- List container -->
		<ul class="divide-y divide-gray-200">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<!-- List item for each post -->
					<li class="py-4">
						<article>
							<h2 class="text-xl font-semibold text-gray-900"><a href="<?php the_permalink(); ?>" class="hover:text-schoberDarkRed"><?php the_title(); ?></a></h2>
							<p class=" text-gray-700"><?php the_excerpt(); ?></p>
							<div class="text-gray-600 text-sm mt-2"><?php the_time('F j, Y'); ?></div>
						</article>
					</li>
			<?php endwhile;
			endif; ?>
		</ul>
	</div>

	<div class="col-span-4 relative overflow-hidden">
		<?php
		if (has_post_thumbnail()) {
			$large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
		}
		?>

		<img src="<?php echo $large_image_url[0]; ?>" class="h-screen block object-cover w-max absolute right-0">
	</div>

</main><!-- #main -->


<?php
get_footer();
