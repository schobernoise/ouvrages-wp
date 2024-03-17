<?php

/**
 * Template part for displaying single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ouvrages-wp
 */

?>
<div class="col-span-8 lg:col-span-4 ">

	<article id="post-<?php the_ID(); ?>" <?php post_class('grid grid-cols-4 gap-4 content-center pt-8'); ?>>

		<div <?php ouvrages_wp_content_class('entry-content col-start-1 col-span-4 col-start-1 sm:col-span-4 sm:col-start-1 md:col-span-3 md:col-start-1 lg:col-start-1 lg:col-span-4 mt-0 project-scroll mx-8'); ?>>


			<h1 class="font-light col-span-4 lowercase ml-0 mt-0 mb-2">
				<?php the_title(); ?>
			</h1>
			<div class="post-tags mb-8 text-slate-400">
				<?php
				$post_tags = get_the_tags();
				$separator = ' | ';
				$output = '';

				if (!empty($post_tags)) {
					foreach ($post_tags as $tag) {
						$output .= '<span>' . __($tag->name) . '</span>' . $separator;
					}
				}

				echo (trim($output, $separator));
				?>
			</div>

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
				<div class="xs:col-start-1 xs:col-span-4 sm:col-start-1 sm:col-span-3 sm:items-end lg:col-start-1 sm:ml-20 lg:ml-4 xl:ml-16 mt-8">
					<table>
						<tbody>
							<?php
							// Define an array of keys to be excluded
							$exclude_keys = array('images', 'oembed', 'ongoing', 'related_posts');
							?>
							<?php foreach ($organized_fields as $key => $values) : ?>
								<?php if (!empty($values) && !in_array($key, $exclude_keys)) : // Check if non-empty and not in exclude list
								?>
									<tr class="border-0">
										<th class="text-end align-top">
											<?php
											// Display the label if it exists, otherwise display the field name
											echo isset($field_labels[$key]) ? esc_html($field_labels[$key]) : esc_html($key);
											?>
										</th> <!-- Field Label or Name -->
										<td class="pl-4 pt-0 pb-4 align-top">
											<?php
											// Process each value, check if it's a date and format it
											$processed_values = array_map(function ($value) {
												// Check if the value is a date. Adjust the regex as necessary for your date formats.
												if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
													$date = DateTime::createFromFormat('Y-m-d', $value);
													return $date->format('j. F Y'); // Format the date
												}
												return $value; // Return the original value if it's not a date
											}, $values);

											// Display the processed values
											echo implode("<br>", $processed_values);
											?>
										</td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>

						</tbody>
					</table>
				</div>

			<?php endif; ?>

		</div><!-- .entry-content -->






	</article><!-- #post-<?php the_ID(); ?> -->
</div>

<div class="hidden lg:block col-span-4 relative overflow-hidden">
	<?php
	if (has_post_thumbnail()) {
		$large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');

	?>
		<img src="<?php echo $large_image_url[0]; ?>" class="h-screen block object-cover w-max absolute right-0">
	<?php
	}
	?>


</div>