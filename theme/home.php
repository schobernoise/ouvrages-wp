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


		<div class="col-start-1 col-span-4  sm:col-span-3 sm:col-start-2 xl:col-start-2 xl:col-span-2 mt-8 ouvrages-middle-scroll">

			<!-- List container -->
			<ul class="divide-y divide-gray-200">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<!-- List item for each post -->
						<li class="py-4">
							<article>
								<h2 class="text-xl font-semibold text-gray-900 mb-1"><a href="<?php the_permalink(); ?>" class="hover:text-gray-600"><?php the_title(); ?></a></h2>
								<!-- Display Tags -->
								<div class="post-tags mb-4 text-slate-400">
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

		?>

		<img src="<?php echo $large_image_url[0]; ?>" class="h-screen block object-cover w-max ">
	</div>



</main><!-- #main -->


<?php
get_footer();
