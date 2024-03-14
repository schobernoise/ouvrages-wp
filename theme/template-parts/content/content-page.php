<?php

/**
 * Template part for displaying pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ouvrages-wp
 */

?>

<div class="col-span-4">

	<article id="post-<?php the_ID(); ?>" <?php post_class('h-screen grid grid-cols-4 gap-4 content-center'); ?>>

		<h1 class="font-light col-span-4 lowercase ml-4"><?php echo get_bloginfo('name'); ?></h1>

		<div class="col-span-1"></div>

		<div <?php ouvrages_wp_content_class('entry-content col-span-2 mt-8'); ?>>
			<?php the_content(); ?>



			<?php
			$post_id = get_the_ID(); // Get the current post ID
			$custom_fields = get_post_meta($post_id); // Retrieve all custom fields for the post

			// Initialize an array to hold the organized custom fields
			$organized_fields = [];

			foreach ($custom_fields as $key => $values) {
				// Skip WordPress internal meta fields
				if (strpos($key, '_') === 0) {
					continue;
				}
				// Organize values by key
				if (!array_key_exists($key, $organized_fields)) {
					$organized_fields[$key] = [];
				}
				foreach ($values as $value) {
					if (!empty($value)) { // Check if the value is not empty
						$organized_fields[$key][] = $value;
					}
				}
			}

			if (!empty($organized_fields)) : ?>
				<table style="margin-left: -3rem;">
					<tbody>
						<?php foreach ($organized_fields as $key => $values) : ?>
							<?php if (!empty($values)) : // Check if there are non-empty values
							?>
								<tr class="border-0">
									<th class="text-end align-top"><?php echo esc_html($key); ?></th> <!-- Field Name -->
									<td class="pl-4 pt-0">
										<?php echo implode(', ', $values); ?> <!-- Combined Values -->
									</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>


		</div><!-- .entry-content -->





	</article><!-- #post-<?php the_ID(); ?> -->
</div>

<div class="col-span-4 relative overflow-hidden">
	<?php
	if (has_post_thumbnail()) {
		$large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
	}
	?>

	<img src="<?php echo $large_image_url[0]; ?>" class="h-screen block object-cover w-max absolute right-0">
</div>