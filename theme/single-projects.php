<?php

/**
 * Template Name: Project Template
 * Template Post Type: projects
 */



get_header(); ?>



<main id="main" class="col-span-4 xl:col-span-8 md:mx-0 lg:mx-0 md:w-full lg:w-full overflow-hidden">

	<div class="col-span-8 lg:col-span-4 pr-0 md:pr-4 xl:pr-0 relative project-scroll md:pt-8 lg:h-screen mx-4 md:ml-4 lg:ml-0 pb-16 overflow-hidden">

		<article id="post-<?php the_ID(); ?>" <?php post_class('grid grid-cols-4 gap-4 content-center md:pt-8 pb-0'); ?>>
			<?php
			// TODO Duplication
			$post_type = 'projects';
			$archive_link = get_post_type_archive_link($post_type); ?>
			<a href="<?php echo $archive_link ?>">zurück</a>
			<div <?php ouvrages_wp_content_class('entry-content col-start-1 col-span-4 col-start-1 sm:col-span-4 sm:col-start-1 md:col-span-3 md:col-start-1 lg:col-start-1 lg:col-span-4 mt-0 project-scroll mx-8'); ?>>


				<h1 class="font-light col-span-4 lowercase ml-0 mt-0 mb-2">
					<?php the_title(); ?>
				</h1>
				<div class="post-tags mb-4">
					<p class="link-muted"><?php the_tags(''); ?></p>
				</div>



				<div class="post-meta flex items-center">
					<span class="post-year text-xl font-bold"><?php echo get_the_date('Y'); ?></span> <!-- Display the year of the post -->

					<div class="inline-flex items-center types-badgers  ml-4 md:ml-0">
						<?php the_terms(get_the_ID(), 'project-type',  $sep = " ");  ?>
					</div>
				</div>

				<p class="font-bold"><?php echo get_the_excerpt() ?>
				<p>

					<?php the_content(); ?>


					<?php get_template_part('template-parts/content/content', 'customfields'); ?>


					<?php get_template_part('template-parts/content/content', 'related'); ?>

					<?php get_template_part('template-parts/content/content', 'navigation'); ?>

			</div><!-- .entry-content -->

		</article><!-- #post-<?php the_ID(); ?> -->


	</div>

	<div class="col-span-8 lg:col-span-4 md:pr-4 xl:pr-0 relative project-scroll pt-8 lg:h-screen mx-4 md:ml-4 lg:ml-0 pb-16">
		<?php
		if (has_post_thumbnail()) {
			$large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
		?>
			<div class="col-span-2 mb-4">
				<img src="<?php echo $large_image_url[0]; ?>" class=" object-contain w-full">
			</div>
		<?php
		}
		?>


		<?php
		// Assuming you have the post ID in $post_id
		$images = get_post_meta(get_the_ID(), 'images', false); // Notice the 'false' to get an array of values

		if (!empty($images)) {
			echo '<div class="masonry-grid columns-1 ">';
			foreach ($images as $image_id) {
				$image_url = wp_get_attachment_url($image_id);
				echo '<div class="masonry-item mb-4">';
				echo '<img src="' . esc_url($image_url) . '" alt="" class="w-full h-auto"/>';
				echo '</div>';
			}
			echo '</div>';
		} else {
			echo get_post_meta($post_id, 'images');
		}
		?>

	</div>


</main><!-- #main -->


<?php
get_footer();
