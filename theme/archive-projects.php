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


<main id="main" class="col-span-4 xl:col-span-8 mx-8 lg:mx-0 w-full">

	<div class="col-span-8 lg:col-span-4">


		<h1 class="font-light col-span-4 lowercase mt-8">
			<!-- <?php get_the_title() ?> -->
			projekte
		</h1>

		<div class="col-start-1 col-span-4 sm:col-span-3 sm:col-start-2 xl:col-start-2 xl:col-span-2 mt-8 ouvrages-middle-scroll">

			<?php
			$current_year = null; // Track the current year

			if (have_posts()) :
				while (have_posts()) : the_post();
					$post_year = get_the_date('Y'); // Get the year of the current post

					// Check if the year of the current post is different from the current year being processed
					if ($post_year !== $current_year) {
						// Close the previous year's list, if it has been opened
						if (!is_null($current_year)) {
							echo '</ul>'; // Close the previous year's list
						}

						// Output the year heading
						echo '<div class="mt-8"><h4 class="text-2xl font-bold my-4">' . $post_year . '</h4></div>';

						// Start a new list for the year
						echo '<ul class="divide-y divide-gray-200">';
						$current_year = $post_year;
					}
			?>
					<li class="flex items-center py-4 w-full">
						<!-- Thumbnail -->
						<div class="flex-shrink-0">
							<?php if (has_post_thumbnail()) : ?>
								<img src="<?php the_post_thumbnail_url('thumbnail'); ?>" alt="<?php the_title(); ?>" class="w-36 h-20 object-cover">
							<?php endif; ?>
						</div>
						<!-- Post layout -->
						<div class="flex-grow px-4">
							<h3>
								<a href="<?php the_permalink(); ?>">
									<?php the_title(); ?></a>
							</h3>
							<p class="text-gray-600"><?php the_time('Y'); ?></p>
						</div>
						<!-- Custom Taxonomy -->
						<div class="inline-flex items-center rounded-md bg-schoberBrightRed px-2 py-1 w-min text-xs font-medium text-white ring-1 ring-inset ring-gray-500/10">
							<?php
							$terms = get_the_terms(get_the_ID(), 'project-type');
							if ($terms && !is_wp_error($terms)) :
								$term_names = wp_list_pluck($terms, 'name');
								echo implode(', ', $term_names);
							endif;
							?>
						</div>
					</li>
			<?php
				endwhile;
				// Ensure the final list is closed
				echo '</ul>';
				wp_reset_postdata();
			endif;
			?>



		</div><!-- .entry-content -->


	</div>

	<div class="hidden lg:flex col-span-4 relative overflow-hidden justify-center">
		<?php

		$page = get_page_by_path('projekte', OBJECT, 'page');
		$page_id = $page->ID;


		$large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($page_id), 'large');

		?>

		<img src="<?php echo $large_image_url[0]; ?>" class="h-screen block object-cover w-max">
	</div>



</main><!-- #main -->


<?php
get_footer();
