<?php

/**
 * The template for displaying all pages
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

<?php
// Setup the custom query arguments
$args = array(
	'post_type' => 'livedates', // or your custom post type if different
	'posts_per_page' => -1, // Adjust as needed, -1 for all posts
	'meta_key' => 'event_date', // Your custom field
	'orderby' => 'meta_value', // Order by the custom field value
	'order' => 'DESC', // Newest posts first
	'meta_query' => array(
		array(
			'key' => 'event_date',
			'value' => array(''), // Possible to add conditions for the value
			'compare' => '!=', // Exclude posts without a valid event_date
			'type' => 'DATETIME', // Ensure correct ordering by treating meta value as a date
		),
	),
);

// The custom query
$custom_query = new WP_Query($args);

?>


<main id="main" class="col-span-4 xl:col-span-8 mx-8 lg:mx-0 md:w-max lg:w-full">

	<div class="col-span-8 lg:col-span-4 ">


		<h1 class="font-light col-span-4 lowercase mt-8">
			<!-- <?php get_the_title() ?> -->
			live
		</h1>

		<div class="col-start-1 col-span-4 sm:col-span-3 sm:col-start-2 xl:col-start-2 xl:col-span-2 mt-8 project-scroll ">

			<?php
			$current_year = null; // Track the current year
			if ($custom_query->have_posts()) : while ($custom_query->have_posts()) : $custom_query->the_post();
					$event_date = get_post_meta(get_the_ID(), 'event_date', true);
					// Check if the event_date is not empty

					if ($event_date != "0000-00-00 00:00:00") {
						$date = DateTime::createFromFormat('Y-m-d H:i:s', $event_date); // Adjust the format as needed

					} else {
						$date = DateTime::createFromFormat('Y-m-d H:i:s', "2099-01-01 19:00:00");
					}


					$post_year = $date->format('Y'); // Get the year of the current post

					// Check if the year of the current post is different from the current year being processed
					if ($post_year !== $current_year) {
						if (!is_null($current_year)) {
							// Close the previous year's list, if open
							echo '</div>';
						}
						echo '<h4 class="text-2xl font-bold my-4 mt-8">' . $post_year . '</h4>'; // Output the year heading
						echo '<div class="divide-y divide-gray-200">'; // Start a new "list" for the year
						$current_year = $post_year;
					}
			?>
					<div class="flex items-center py-4 w-full">
						<!-- Date layout -->
						<div class="flex-shrink-0 text-center">
							<p class="text-4xl font-bold"><?php echo $date->format('d'); ?></p> <!-- Day -->
							<p class="text-xs font-medium mt-2"><?php echo $date->format('F'); ?></p> <!-- Month -->
							<p class="text-normal font-bold mt-2"><?php echo $date->format('H:m'); ?></p> <!-- Month -->
						</div>
						<!-- Post layout -->
						<div class="flex-grow px-4">

							<h3 class="text-xs mb-0">
								<a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a>
							</h3>
							<?php
							// Displaying ongoing
							$post_id = get_the_ID(); // Get the current post ID.
							$location = get_post_meta($post_id, 'location'); // Retrieve the value of 'location' custom field.

							// Check if 'location' is true and display the badge.
							if ($location) {
								echo '<span class=" text-xs font-semibold mb-2 mt-0">' . $location[0] . '</span>';
							}
							?>
							<div class="flex items-center">
								<p class="text-gray-600"><?php $date->format('Y'); ?></p>
								<!-- Custom Taxonomy -->
								<div class="inline-flex items-center break-keep">
									<?php
									$terms = get_the_terms(get_the_ID(), 'livedate-type');
									if ($terms && !is_wp_error($terms)) :
										$term_names = wp_list_pluck($terms, 'name');
										// echo implode('', $term_names);
										echo '<span class="project-type break-keep">';
										$type_links = array();

										foreach ($term_names as $type) {
											$type_links[] = '<span rel="tag" class="ml-2 inline-flex items-center rounded-md bg-schoberBrightRed px-2 py-1 text-xs font-medium text-white">' . esc_html($type) . '</span>';
										}

										// Join and output the list of links
										echo join('', $type_links);
										echo '</span>';

									endif;
									?>
								</div>
							</div>

						</div>


					</div>
			<?php
				endwhile;
				echo '</div>'; // Close the last "list"
				wp_reset_postdata();
			endif;
			?>


		</div><!-- .entry-content -->


	</div>

	<div class="hidden lg:flex col-span-4 relative overflow-hidden justify-center">
		<?php

		$page = get_page_by_path('live', OBJECT, 'page');
		$page_id = $page->ID;


		$large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($page_id), 'large');

		?>

		<img src="<?php echo $large_image_url[0]; ?>" class="h-screen block object-cover w-max absolute">
	</div>



</main><!-- #main -->


<?php
get_footer();
