<?php

/**
 * ouvrages-wp functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ouvrages-wp
 */

if (!defined('OUVRAGES_WP_VERSION')) {
	/*
	 * Set the theme’s version number.
	 *
	 * This is used primarily for cache busting. If you use `npm run bundle`
	 * to create your production build, the value below will be replaced in the
	 * generated zip file with a timestamp, converted to base 36.
	 */
	define('OUVRAGES_WP_VERSION', '0.1.0');
}

if (!defined('OUVRAGES_WP_TYPOGRAPHY_CLASSES')) {
	/*
	 * Set Tailwind Typography classes for the front end, block editor and
	 * classic editor using the constant below.
	 *
	 * For the front end, these classes are added by the `ouvrages_wp_content_class`
	 * function. You will see that function used everywhere an `entry-content`
	 * or `page-content` class has been added to a wrapper element.
	 *
	 * For the block editor, these classes are converted to a JavaScript array
	 * and then used by the `./javascript/block-editor.js` file, which adds
	 * them to the appropriate elements in the block editor (and adds them
	 * again when they’re removed.)
	 *
	 * For the classic editor (and anything using TinyMCE, like Advanced Custom
	 * Fields), these classes are added to TinyMCE’s body class when it
	 * initializes.
	 */
	define(
		'OUVRAGES_WP_TYPOGRAPHY_CLASSES',
		'prose prose-neutral max-w-none prose-a:text-primary'
	);
}

if (!function_exists('ouvrages_wp_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ouvrages_wp_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ouvrages-wp, use a find and replace
		 * to change 'ouvrages-wp' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('ouvrages-wp', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __('Primary', 'ouvrages-wp'),
				'menu-2' => __('Footer Menu', 'ouvrages-wp'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		add_theme_support('custom-logo');

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		// Add support for editor styles.
		add_theme_support('editor-styles');

		// Enqueue editor styles.
		add_editor_style('style-editor.css');
		add_editor_style('style-editor-extra.css');

		// Add support for responsive embedded content.
		add_theme_support('responsive-embeds');

		// Remove support for block templates.
		remove_theme_support('block-templates');
	}
endif;
add_action('after_setup_theme', 'ouvrages_wp_setup');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ouvrages_wp_widgets_init()
{
	register_sidebar(
		array(
			'name'          => __('Footer', 'ouvrages-wp'),
			'id'            => 'sidebar-1',
			'description'   => __('Add widgets here to appear in your footer.', 'ouvrages-wp'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'ouvrages_wp_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function ouvrages_wp_scripts()
{
	wp_enqueue_style('ouvrages-wp-style', get_stylesheet_uri(), array(), OUVRAGES_WP_VERSION);
	wp_enqueue_script('ouvrages-wp-script', get_template_directory_uri() . '/js/script.min.js', array(), OUVRAGES_WP_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'ouvrages_wp_scripts');

/**
 * Enqueue the block editor script.
 */
function ouvrages_wp_enqueue_block_editor_script()
{
	wp_enqueue_script(
		'ouvrages-wp-editor',
		get_template_directory_uri() . '/js/block-editor.min.js',
		array(
			'wp-blocks',
			'wp-edit-post',
		),
		OUVRAGES_WP_VERSION,
		true
	);
}
add_action('enqueue_block_editor_assets', 'ouvrages_wp_enqueue_block_editor_script');

/**
 * Enqueue the script necessary to support Tailwind Typography in the block
 * editor, using an inline script to create a JavaScript array containing the
 * Tailwind Typography classes from OUVRAGES_WP_TYPOGRAPHY_CLASSES.
 */
function ouvrages_wp_enqueue_typography_script()
{
	if (is_admin()) {
		wp_enqueue_script(
			'ouvrages-wp-typography',
			get_template_directory_uri() . '/js/tailwind-typography-classes.min.js',
			array(
				'wp-blocks',
				'wp-edit-post',
			),
			OUVRAGES_WP_VERSION,
			true
		);
		wp_add_inline_script('ouvrages-wp-typography', "tailwindTypographyClasses = '" . esc_attr(OUVRAGES_WP_TYPOGRAPHY_CLASSES) . "'.split(' ');", 'before');
	}
}
add_action('enqueue_block_assets', 'ouvrages_wp_enqueue_typography_script');

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function ouvrages_wp_tinymce_add_class($settings)
{
	$settings['body_class'] = OUVRAGES_WP_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter('tiny_mce_before_init', 'ouvrages_wp_tinymce_add_class');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';



/**
 * Plugin Name: is_page_X capability
 * Description: Grant the current user access to fields or groups based on the ID or slug of the current page being edited. Capability <code>is_page_contact-us</code> will be granted on page with slug <code>contact-us</code>. <code>is_page_123</code> will be granted on page with ID <code>123</code>.
 */

/**
 * For a capability starting with "is_page_", grant the capability to the current user
 * if the slug or ID of the currently viewed page is the same as whatever comes after the "is_page_" prefix.
 *
 * For example:
 *     "is_page_contact-us" will be granted on page with slug "contact-us".
 *     "is_page_123" will be granted on page with ID 123.
 *
 * @see https://developer.wordpress.org/reference/hooks/map_meta_cap/
 */
add_filter(
	'map_meta_cap',
	function ($caps, $cap, $user_id, $args) {
		$prefix = 'is_page_';
		$prefix_length = strlen($prefix);

		if (
			$prefix === substr($cap, 0, $prefix_length)
			&& array_key_exists('post', $_GET) // Only applies once a new page has been saved and refreshed.
		) {
			$post_object = get_post(intval($_GET['post']));

			if ('page' === $post_object->post_type) {
				$slug_or_id = substr($cap, $prefix_length);

				if (is_numeric($slug_or_id)) {
					// The capability is providing an ID in the form is_page_123.
					if ($post_object->ID !== intval($slug_or_id)) {
						// If is_page_123 does not match the current page ID being 123, don't allow.
						$caps = ['do_not_allow'];
					} else {
						// If the ID does match, require the user have the capability to edit pages.
						$caps = ['edit_pages'];
					}
				} else {
					// The capability is providing a slug in the form is_page_contact-us.
					if ($post_object->post_name !== $slug_or_id) {
						// If is_page_contact-us does not match the current page slug being contact-us, don't allow.
						$caps = ['do_not_allow'];
					} else {
						// If the slug does match, require the user have the capability to edit pages.
						$caps = ['edit_pages'];
					}
				}
			}
		}

		return $caps;
	},
	10,
	4
);


add_filter('nav_menu_css_class', 'special_nav_class', 10, 2);

function special_nav_class($classes, $item)
{
	if (in_array('current-menu-item', $classes)) {
		$classes[] = 'active ';
	}
	return $classes;
}


function hueman_add_meta_tags()
{

	global $post;

	if (is_singular()) {

		$des_post = $post->post_excerpt;
		$des_post = mb_substr($des_post, 0, 300, 'utf8');
		echo '<meta name="description" content="' . $des_post . '" />' . "\n";
	}

	if (is_home()) {

		echo '<meta name="description" content="' . get_bloginfo("description") . '" />' . "\n";
	}

	if (is_page()) {

		$des_post = $post->post_excerpt;
		echo '<meta name="description" content="' . $des_post . '" />' . "\n";
	}

	if (is_category()) {

		$des_cat = strip_tags(category_description());

		echo '<meta name="description" content="' . $des_cat . '" />' . "\n";
	}
}

add_action('wp_head', 'hueman_add_meta_tags');


function my_custom_search_form()
{
	$form = '<form role="search" method="get" id="searchform" class="search-form" action="' . home_url('/') . '" >
    <div>
        <label class="screen-reader-text" for="s">' . __('Search for:') . '</label>
        <input class="search-field" type="text" value="' . get_search_query() . '" name="s" id="s" />
        <button type="submit" id="search-submit" class="search-icon"><svg fill="#ffffff" height="16px" width="16px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 488.4 488.4" xml:space="preserve" stroke="#ffffff">

		<g id="SVGRepo_bgCarrier" stroke-width="0"/>

		<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

		<g id="SVGRepo_iconCarrier"> <g> <g> <path d="M0,203.25c0,112.1,91.2,203.2,203.2,203.2c51.6,0,98.8-19.4,134.7-51.2l129.5,129.5c2.4,2.4,5.5,3.6,8.7,3.6 s6.3-1.2,8.7-3.6c4.8-4.8,4.8-12.5,0-17.3l-129.6-129.5c31.8-35.9,51.2-83,51.2-134.7c0-112.1-91.2-203.2-203.2-203.2 S0,91.15,0,203.25z M381.9,203.25c0,98.5-80.2,178.7-178.7,178.7s-178.7-80.2-178.7-178.7s80.2-178.7,178.7-178.7 S381.9,104.65,381.9,203.25z"/> </g> </g> </g>

		</svg></button>
    </div>
    </form>';

	return $form;
}
add_filter('get_search_form', 'my_custom_search_form');
