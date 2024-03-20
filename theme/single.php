<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ouvrages-wp
 */


get_header();
?>


<main id="main" class="col-span-4 xl:col-span-8 mx-4 md:mx-0 lg:mx-0 md:w-full lg:w-full">

	<?php

	/* Start the Loop */
	while (have_posts()) :
		the_post();

	?>

		<div class="col-span-8 lg:col-span-4 ">

			<article id="post-<?php the_ID(); ?>" <?php post_class('grid grid-cols-4 gap-4 content-center pt-8'); ?>>

				<div <?php ouvrages_wp_content_class('entry-content col-start-1 col-span-4 col-start-1 sm:col-span-4 sm:col-start-1 md:col-span-3 md:col-start-1 lg:col-start-1 lg:col-span-4 mt-0 project-scroll mx-8'); ?>>

					<?php
					// TODO Duplication
					$post_type = 'post';
					$archive_link = get_post_type_archive_link($post_type); ?>
					<a href="<?php echo $archive_link ?>">zurück</a>

					<h3><?php
						$categories = get_the_category(); // Fetch all categories for the post
						$separator = ' '; // Separator between categories
						$output = '';

						if ($categories) {
							// First, display parent categories with links
							foreach ($categories as $category) {
								if ($category->parent == 0) { // Check if it's a parent category
									$output .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" alt="' . esc_attr(sprintf(__('View all posts in %s', 'textdomain'), $category->name)) . '">' . esc_html($category->name) . '</a>' . $separator;

									// Now, find and display child categories without links
									$child_categories = get_categories(array('parent' => $category->term_id));
									foreach ($child_categories as $child) {
										$output .= esc_html($child->name) . $separator; // Display child category name without link
									}
								}
							}

							// Output the categories, trimming the trailing separator
							echo trim($output, $separator);
						}
						?></h3>
					<h1 class="font-light col-span-4 lowercase ml-0 mt-0 mb-2">
						<?php the_title(); ?>
					</h1>
					<div class="post-tags mb-4">
						<p class="link-muted"><?php the_tags(''); ?></p>
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
									$exclude_keys = array('images', 'oembed', 'ongoing', 'related_posts', 'projects', 'related_livedates');
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
							<?php get_template_part('template-parts/content/content', 'related'); ?>

							<?php get_template_part('template-parts/content/content', 'navigation'); ?>
						</div>

					<?php endif; ?>






				</div><!-- .entry-content -->






			</article><!-- #post-<?php the_ID(); ?> -->

		</div>

		<div class="hidden lg:block col-span-4 relative overflow-hidden">

			<?php if (has_post_thumbnail()) : ?>
				<img src="<?php the_post_thumbnail_url(); ?>" class="h-screen block object-cover w-max right-0">
			<?php endif; ?>

		</div>


	<?php
	endwhile; // End of the loop.
	?>

</main><!-- #main -->


<?php
get_footer();
