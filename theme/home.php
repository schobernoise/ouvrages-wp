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


<main id="main" class="col-span-4 xl:col-span-8 mx-8 lg:mx-0">

	<div class="col-span-8 lg:col-span-4 ">


		<h1 class="font-light col-span-4 lowercase mt-8">
			<!-- <?php get_the_title() ?> -->
			blog
		</h1>


		<div class="col-start-1 col-span-4  sm:col-span-3 sm:col-start-2 xl:col-start-2 xl:col-span-2 mt-8 project-scroll">

			<!-- List container -->
			<ul class="divide-y divide-gray-200">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


						<!-- List item for each post -->
						<li class="py-4">
							<article>
								<h4 class="archive-post-category"> <?php
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
																	?></h4>
								<h2 class="text-xl font-semibold text-gray-900 mb-1"><a href="<?php the_permalink(); ?>" class="hover:text-gray-600"><?php the_title(); ?></a></h2>
								<!-- Display Tags -->
								<div class="post-tags mb-4">
									<p class="link-muted"><?php the_tags(''); ?></p>
								</div>
								<p class="text-gray-700"><?php the_excerpt(); ?></p>
								<div class="text-gray-600 text-sm mt-2"><?php the_time('F j, Y'); ?></div>
							</article>
						</li>
				<?php endwhile;
				endif; ?>
			</ul>

			<hr class="h-px my-8 bg-gray-200 border-1 dark:bg-gray-700">


		</div><!-- .entry-content -->


	</div>

	<div class="hidden lg:flex col-span-4 relative overflow-hidden justify-center">
		<?php

		$page = get_page_by_path('blog', OBJECT, 'page');
		$page_id = $page->ID;


		$large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($page_id), 'large');

		if ($large_image_url) :
		?>

			<img src="<?php echo $large_image_url[0]; ?>" class="h-screen block object-cover w-max ">
		<?php endif; ?>
	</div>



</main><!-- #main -->


<?php
get_footer();
