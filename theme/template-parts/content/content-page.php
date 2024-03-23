<?php

/**
 * Template part for displaying pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ouvrages-wp
 */

?>

<div class="col-span-8 lg:col-span-4 ">

	<article id="post-<?php the_ID(); ?>" <?php post_class('h-screen grid grid-cols-4 gap-4'); ?>>



		<div <?php ouvrages_wp_content_class('entry-content col-start-1 col-span-4 sm:col-span-3  xl:ml-4 xl:col-start-1 xl:col-span-3 mt-8'); ?>>

			<h1 class="font-light col-span-4 lowercase ml-0">
				<?php the_title(); ?>
			</h1>
			<?php the_content(); ?>

		</div><!-- .entry-content -->

		<?php get_template_part('template-parts/content/content', 'customfields'); ?>




	</article><!-- #post-<?php the_ID(); ?> -->
</div>

<div class="hidden lg:block col-span-4 relative overflow-hidden">
	<?php
	if (has_post_thumbnail()) {
		$large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
	?>
		<img src="<?php echo $large_image_url[0]; ?>" class="h-screen block object-cover w-max">
	<?php
	}
	?>


</div>