<?php

/**
 * Template Name: Generic Project
 * Template Post Type: projects
 */

get_header(); ?>


<main id="main" class="col-span-4 xl:col-span-8 mx-8 lg:mx-0">

	<?php

	/* Start the Loop */
	while (have_posts()) :
		the_post();

	?><h1>RABARABER</h1><?php

					endwhile; // End of the loop.
						?>

</main><!-- #main -->


<?php
get_footer();
