<?php $exclude_keys = array(
	'images',
	'oembed',
	'ongoing',
	'related_posts',
	'projects',
	'preview_info',
	'projects',
	'related_livedates',
	'sseo_meta_keywords',
	'sseo_meta_title',
	'sseo_meta_description',
	'sseo_fb_title',
	'sseo_fb_description',
	'preview_info',
	'sseo_tw_description',
	'sseo_tw_image',
	'sseo_fb_image',
	'sseo_tw_title',
	'event_date'
); ?>


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

				// Loop through each field
				foreach ($organized_fields as $key => $values) :
					// Skip the entire iteration if the key is in the exclude list
					if (in_array($key, $exclude_keys)) {
						continue; // Skip this key and its values entirely
					}

					// Process and filter values
					$processed_values = array_filter(array_map(function ($value) use ($key) {
						if ($value === '0000-00-00' || $value === '') {
							return ''; // Skip empty values and '0000-00-00'
						}
						if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) { // Check for date format
							$date = DateTime::createFromFormat('Y-m-d', $value);
							if ($date && $date->format('Y-m-d') !== '0000-00-00') {
								return $date->format('j. F Y'); // Correctly formatted date
							}
							return '';
						}
						return $value; // Non-date values
					}, $values));

					// Only display if there are non-empty processed values
					if (!empty($processed_values)) : ?>
						<tr class="border-0">
							<th class="text-end align-top">
								<?php
								echo isset($field_labels[$key]) ? esc_html($field_labels[$key]) : esc_html($key); // Display field label or key
								?>
							</th>
							<td class="pl-4 pt-0 pb-4 align-top">
								<?php
								echo implode("<br>", $processed_values); // Display processed values
								?>
							</td>
						</tr>
					<?php endif; // Check for non-empty processed values
					?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
<?php endif; ?>