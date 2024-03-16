<?php

/**
 * Template Name: Photography Project
 * Template Post Type: projects
 */

get_header(); ?>



<main id="main" class="col-span-4 xl:col-span-8 mx-8 lg:mx-0 md:w-max lg:w-full">


	<div class="col-span-8 lg:col-span-4 ">


		<article id="post-<?php the_ID(); ?>" <?php post_class('grid grid-cols-4 gap-4 content-center pt-8'); ?>>



			<div <?php ouvrages_wp_content_class('entry-content col-start-1 col-span-4 col-start-1 sm:col-span-3 sm:col-start-2 lg:col-start-1 lg:col-span-4 mt-0 project-scroll mx-8'); ?>>


				<h1 class="font-light col-span-4 lowercase ml-0 sm:ml-4 mt-0">
					<?php the_title(); ?>
				</h1>

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
					<div class="xs:col-start-1 xs:col-span-4 sm:col-start-1 sm:col-span-3 sm:items-end lg:col-start-1  sm:ml-20 lg:ml-4 xl:ml-16 mt-8">
						<table>
							<tbody>
								<?php foreach ($organized_fields as $key => $values) : ?>
									<?php if (!empty($values)) : // Check if there are non-empty values
									?>
										<tr class="border-0">
											<th class="text-end align-top"><?php echo esc_html($key); ?></th> <!-- Field Name -->
											<td class="pl-4 pt-0 pb-4 align-top">
												<?php echo implode("<br>", $values); ?> <!-- Combined Values -->
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

	<div class="hidden lg:block col-span-4 relative ouvrages-middle-scroll pt-8 h-screen">
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
