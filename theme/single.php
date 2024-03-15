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

<section id="primary">
	<main id="main">
		<h2>HELLO POST</h2>
		<?php
		/* Start the Loop */
		while (have_posts()) :
			the_post();
			get_template_part('template-parts/content/content', 'single');

			if (is_singular('post')) {
				// Previous/next post navigation.
				the_post_navigation(
					array(
						'next_text' => '<span aria-hidden="true">' . __('Next Post', 'ouvrages-wp') . '</span> ' .
							'<span class="sr-only">' . __('Next post:', 'ouvrages-wp') . '</span> <br/>' .
							'<span>%title</span>',
						'prev_text' => '<span aria-hidden="true">' . __('Previous Post', 'ouvrages-wp') . '</span> ' .
							'<span class="sr-only">' . __('Previous post:', 'ouvrages-wp') . '</span> <br/>' .
							'<span>%title</span>',
					)
				);
			}

			// If comments are open, or we have at least one comment, load
			// the comment template.
			if (comments_open() || get_comments_number()) {
				comments_template();
			}

		// End the loop.
		endwhile;
		?>

	</main><!-- #main -->
</section><!-- #primary -->

<?php
get_footer();
