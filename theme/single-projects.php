<?php

/**
 * Template Name: Photography Project
 * Template Post Type: projects
 */

get_header(); ?>



<main id="main" class="col-span-4 xl:col-span-8 mx-8 md:mx-0 lg:mx-0 md:w-full lg:w-full">

	<div class="col-span-8 lg:col-span-4 ">

		<article id="post-<?php the_ID(); ?>" <?php post_class('grid grid-cols-4 gap-4 content-center pt-8'); ?>>

			<div <?php ouvrages_wp_content_class('entry-content col-start-1 col-span-4 col-start-1 sm:col-span-4 sm:col-start-1 md:col-span-3 md:col-start-1 lg:col-start-1 lg:col-span-4 mt-0 project-scroll mx-8'); ?>>


				<?php
				// TODO Duplication
				$post_type = 'projects';
				$archive_link = get_post_type_archive_link($post_type); ?>
				<a href="<?php echo $archive_link ?>">zurück</a>


				<h1 class="font-light col-span-4 lowercase ml-0 mt-0 mb-2">
					<?php the_title(); ?>
				</h1>




				<div class="post-meta flex items-center">
					<span class="post-year text-xl font-bold"><?php echo get_the_date('Y'); ?></span> <!-- Display the year of the post -->

					<?php
					// Get the project-type terms for the current post
					$project_types = get_the_terms(get_the_ID(), 'project-type');

					if (!empty($project_types) && !is_wp_error($project_types)) {
						// If there are terms and no errors, display them
						echo '<span class="project-type">';
						$type_links = array();

						// Loop through each term, and compile a list of links

						// foreach ($project_types as $type) {
						// 	$type_links[] = '<a href="' . esc_url(get_term_link($type)) . '" rel="tag" class="ml-2 inline-flex items-center rounded-md bg-schoberBrightRed px-2 py-1 text-xs font-medium text-white ">' . esc_html($type->name) . '</a>';
						// }

						foreach ($project_types as $type) {
							$type_links[] = '<span rel="tag" class="ml-2 inline-flex items-center rounded-md bg-schoberBrightRed px-2 py-1 text-xs font-medium text-white">' . esc_html($type->name) . '</span>';
						}


						// Join and output the list of links
						echo join('', $type_links);
						echo '</span>';
					}


					?>
				</div>

				<p class="font-bold"><?php echo get_the_excerpt() ?>
				<p>

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
							$exclude_keys = array('images', 'oembed', 'ongoing', 'projects', 'related_livedates', "related_posts");
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

			<?php get_template_part('template-parts/content/content', 'related'); ?>

			<?php get_template_part('template-parts/content/content', 'navigation'); ?>

			</div><!-- .entry-content -->





		</article><!-- #post-<?php the_ID(); ?> -->


	</div>

	<div class="col-span-8 lg:col-span-4 pr-4 xl:pr-0 relative ouvrages-middle-scroll pt-8 lg:h-screen mx-4 md:ml-4 lg:ml-0">
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
		$images = get_post_meta($post_id, 'images', false); // Notice the 'false' to get an array of values

		if (!empty($images)) {
			echo '<div class="masonry-grid columns-2 ">';
			foreach ($images as $image_id) {
				$image_url = wp_get_attachment_url($image_id);
				echo '<div class="masonry-item mb-4">';
				echo '<img src="' . esc_url($image_url) . '" alt="" class="w-full h-auto"/>';
				echo '</div>';
			}
			echo '</div>';
		}
		?>

	</div>


</main><!-- #main -->


<?php
get_footer();
