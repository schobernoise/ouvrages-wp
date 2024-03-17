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


<main id="main" class="col-span-4 xl:col-span-8 mx-8 md:mx-0 lg:mx-0 md:w-full lg:w-full">

	<?php

	/* Start the Loop */
	while (have_posts()) :
		the_post();

		get_template_part('template-parts/content/content', 'single');

	// if (is_singular('post')) {
	// 	// Previous/next post navigation.
	// 	the_post_navigation(
	// 		array(
	// 			'next_text' => '<span aria-hidden="true">' . __('Next Post', 'ouvrages-wp') . '</span> ' .
	// 				'<span class="sr-only">' . __('Next post:', 'ouvrages-wp') . '</span> <br/>' .
	// 				'<span>%title</span>',
	// 			'prev_text' => '<span aria-hidden="true">' . __('Previous Post', 'ouvrages-wp') . '</span> ' .
	// 				'<span class="sr-only">' . __('Previous post:', 'ouvrages-wp') . '</span> <br/>' .
	// 				'<span>%title</span>',
	// 		)
	// 	);
	// }

	endwhile; // End of the loop.
	?>

</main><!-- #main -->


<?php
get_footer();
