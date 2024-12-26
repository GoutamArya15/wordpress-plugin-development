<?php

/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

// Adds theme support for post formats.
if (! function_exists('twentytwentyfive_post_format_setup')) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_post_format_setup()
	{
		add_theme_support('post-formats', array('aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'));
	}
endif;
add_action('after_setup_theme', 'twentytwentyfive_post_format_setup');

// Enqueues editor-style.css in the editors.
if (! function_exists('twentytwentyfive_editor_style')) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_editor_style()
	{
		add_editor_style(get_parent_theme_file_uri('assets/css/editor-style.css'));
	}
endif;
add_action('after_setup_theme', 'twentytwentyfive_editor_style');

// Enqueues style.css on the front.
if (! function_exists('twentytwentyfive_enqueue_styles')) :
	/**
	 * Enqueues style.css on the front.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_enqueue_styles()
	{
		wp_enqueue_style(
			'twentytwentyfive-style',
			get_parent_theme_file_uri('style.css'),
			array(),
			wp_get_theme()->get('Version')
		);
	}
endif;
add_action('wp_enqueue_scripts', 'twentytwentyfive_enqueue_styles');

// Registers custom block styles.
if (! function_exists('twentytwentyfive_block_styles')) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_block_styles()
	{
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __('Checkmark', 'twentytwentyfive'),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action('init', 'twentytwentyfive_block_styles');

// Registers pattern categories.
if (! function_exists('twentytwentyfive_pattern_categories')) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_pattern_categories()
	{

		register_block_pattern_category(
			'twentytwentyfive_page',
			array(
				'label'       => __('Pages', 'twentytwentyfive'),
				'description' => __('A collection of full page layouts.', 'twentytwentyfive'),
			)
		);

		register_block_pattern_category(
			'twentytwentyfive_post-format',
			array(
				'label'       => __('Post formats', 'twentytwentyfive'),
				'description' => __('A collection of post format patterns.', 'twentytwentyfive'),
			)
		);
	}
endif;
add_action('init', 'twentytwentyfive_pattern_categories');

// Registers block binding sources.
if (! function_exists('twentytwentyfive_register_block_bindings')) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_register_block_bindings()
	{
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x('Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive'),
				'get_value_callback' => 'twentytwentyfive_format_binding',
			)
		);
	}
endif;
add_action('init', 'twentytwentyfive_register_block_bindings');

// Registers block binding callback function for the post format name.
if (! function_exists('twentytwentyfive_format_binding')) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function twentytwentyfive_format_binding()
	{
		$post_format_slug = get_post_format();

		if ($post_format_slug && 'standard' !== $post_format_slug) {
			return get_post_format_string($post_format_slug);
		}
	}
endif;
// ahfahsfahs ahsfhasfha


add_filter('manage_plugins_columns', function ($columns) {
    $columns['download_plugin'] = __('Download Plugin', 'textdomain');
    return $columns;
});

// Display the download button in the new column
add_action('manage_plugins_custom_column', function ($column_name, $plugin_file) {
    if ('download_plugin' === $column_name) {
        // Extract the plugin folder name from the plugin file
        $plugin_folder = basename(dirname($plugin_file));

        echo '
        <button class="button button-primary download-plugin-btn" data-plugin-folder="' . esc_attr($plugin_folder) . '">
            ' . __('Download', 'textdomain') . '
        </button>
        ';
    }
}, 10, 2);

// Enqueue the necessary JavaScript for AJAX
add_action('admin_enqueue_scripts', function() {
    wp_enqueue_script('plugin-download-ajax', get_template_directory_uri() . '/js/plugin-download.js', ['jquery'], null, true);
    wp_localize_script('plugin-download-ajax', 'pluginDownload', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('plugin_download_nonce')
    ]);
});

// Handle the download request via AJAX
add_action('wp_ajax_download_plugin', function() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'plugin_download_nonce')) {
        wp_send_json_error(['message' => __('Invalid nonce', 'textdomain')]);
    }

    // Check if the user has permission to install plugins
    if (!current_user_can('install_plugins')) {
        wp_send_json_error(['message' => __('You do not have sufficient permissions.', 'textdomain')]);
    }

    if (isset($_POST['plugin_folder'])) {
        $plugin_folder = sanitize_text_field($_POST['plugin_folder']);
        $plugin_path = WP_PLUGIN_DIR . '/' . $plugin_folder;

        // Validate plugin folder existence
        if (!file_exists($plugin_path)) {
            wp_send_json_error(['message' => __('Plugin folder does not exist.', 'textdomain')]);
        }

        // Define the path to save the zip file in wp-content/uploads/
        $upload_dir = wp_upload_dir();
        $download_zip = $upload_dir['basedir'] . '/' . $plugin_folder . '.zip';

        // Handle directory (plugin folder) download
        if (is_dir($plugin_path)) {
            $zip = new ZipArchive();
            if ($zip->open($download_zip, ZipArchive::CREATE) !== true) {
                wp_send_json_error(['message' => __('Could not create zip file.', 'textdomain')]);
            }

            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($plugin_path, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                $relative_path = $plugin_folder . '/' . substr($file->getRealPath(), strlen($plugin_path) + 1);
                $zip->addFile($file->getRealPath(), $relative_path);
            }

            $zip->close();

            // Send the URL for download
            wp_send_json_success([
                'url' => $upload_dir['baseurl'] . '/' . $plugin_folder . '.zip'
            ]);
        }

        // If the plugin is a single file, handle that
        if (is_file($plugin_path)) {
            wp_send_json_success([
                'url' => $upload_dir['baseurl'] . '/' . basename($plugin_folder)
            ]);
        }

        wp_send_json_error(['message' => __('Invalid plugin path.', 'textdomain')]);
    }
});





