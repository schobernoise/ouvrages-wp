global $post;
$cont = strip_tags($post->post_content); // Strip markup
$cont = str_replace(array("\n", "\r", "\t"), ' ', $cont); // Change line breaks and tabs to single space
$cont = str_replace(array('"',"'"), '', $cont); // Strip " and '
$cont = substr($cont, 0, 160); // Set the length to 160