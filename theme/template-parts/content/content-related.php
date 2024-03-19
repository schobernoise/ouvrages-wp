<?php
$post_id = get_the_ID();
$project_posts = get_post_meta($post_id, 'projects', false); // Notice the 'false' to get an array of values
$related_livedates = get_post_meta($post_id, 'related_livedates', false);
$related_posts = get_post_meta($post_id, 'related_posts', false);


if (!empty($project_posts) || !empty($related_livedates) || !empty($related_posts)) {

	if (!empty($project_posts)) {
		echo '<div class="flex-col flex bg-schoberDarkRed p-2 xs:col-start-1 xs:col-span-4 sm:col-start-1 sm:col-span-3 sm:items-end lg:col-start-1">
							<h4 class="font-bold text-white mt-0">Verwandte Projekte</h4>';
		// echo (implode(",", $project_posts));
		foreach ($project_posts as $project_post_id) {
			$project_url = get_permalink($project_post_id);
			$project_title = get_the_title($project_post_id);
			// Stellen Sie sicher, dass die URL gültig ist
			if (!empty($project_url)) {
				echo '<a class="link-white" href="' . esc_url($project_url) . '">' . esc_html($project_title) . '</a>';
			}
		}
	}

	if (!empty($related_livedates)) {

		echo '<h4 class="font-bold text-white">Verwandte livedates</h4>';
		// echo (implode(",", $livedate_posts));
		foreach ($related_livedates as $livedate_id) {
			$livedate_url = get_permalink($livedate_id);
			$livedate_title = get_the_title($livedate_id);
			// Stellen Sie sicher, dass die URL gültig ist
			if (!empty($livedate_url)) {
				echo '<a class="link-white" href="' . esc_url($livedate_url) . '">' . esc_html($livedate_title) . '</a>';
			}
		}
	}

	if (!empty($related_posts)) {

		echo '<h4 class="font-bold text-white">Verwandte Beiträge</h4>';
		// echo (implode(",", $related_posts));
		foreach ($related_posts as $post_id) {
			$post_url = get_permalink($post_id);
			$post_title = get_the_title($post_id);
			// Stellen Sie sicher, dass die URL gültig ist
			if (!empty($post_url)) {
				echo '<a class="link-white" href="' . esc_url($post_url) . '">' . esc_html($post_title) . '</a>';
			}
		}
	}

	echo '</div>';
}
