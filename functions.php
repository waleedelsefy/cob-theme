<?php
/**
 * Capital of Business Theme Functions
 *
 * @package Capital_of_Business
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// List of required files with descriptive comments.
$required_files = array(
	'inc/properties/register_cpt.php',                           // Register custom post types for properties.
	'inc/theme-setup/cob_theme_setup.php',                         // Theme setup functions.
	'inc/theme-setup/enqueue.php',                                 // Enqueue styles and scripts.
	'inc/theme-setup/menus.php',                                   // Register theme menus.
	'inc/theme-setup/Widget/cob_widgets_init.php',                 // Initialize custom widgets.
	'inc/theme-setup/akMinifyHtmlOutput.php',                      // Minify HTML output.
	'inc/redux/config.php',                                        // Redux framework configuration.
	'inc/properties/cob_property_metabox.php',                     // Register property metabox.
	'inc/properties/get_property_details.php',                     // Get property details.
	'inc/properties/cob_create_cob_tables.php',                    // Create custom tables.
	'inc/properties/get_post_city.php',                            // Retrieve post city information.
	'inc/properties/cob_property_gallery.php',                     // Property gallery functionality.
	'inc/services/cob_register_services_post_type.php',            // Register services post type.
	'inc/developer/cob_add_developer_image_field.php',              // Add developer image field.
	'inc/city/cob_add_city_image_field.php',                       // Add city image field.
	'inc/theme-setup/cob_register_slider_post_type.php',           // Register slider post type.
	'inc/real-estate-expert/add_real_estate_expert_role.php',        // Add real estate expert role.
	'inc/real-estate-expert/real_estate_expert_extra_profile_fields.php', // Extra profile fields for experts.
	'inc/contact-forms/contact_entries_menu.php',                  // Contact entries menu.
	'inc/contact-forms/contact_form_submission.php',               // Handle contact form submissions.
	'inc/jobs/jobs_post_type.php',                                 // Register jobs post type.
	'inc/jobs/job_tags_taxonomy.php',                              // Register job tags taxonomy.
	'inc/jobs/job_qualifications_meta_box.php',                    // Job qualifications metabox.
	'inc/jobs/submit_job_application.php',                         // Submit job application.
	'inc/jobs/job_applicants_menu_page.php',                       // Job applicants menu page.
	'inc/transients/delete_transients.php',                        // Delete transients functionality.
	'inc/properties/featured_project_metabox.php',                 // Featured project metabox.
	'inc/properties/render-project-facilities-metabox.php',        // Render project facilities metabox.
	'inc/properties/cob_add_compounds_developer_city.php',        // Render project facilities metabox.
	'inc/properties/dido_theme_property_developer_editor.php',        // Render project facilities metabox.
	'inc/city/cob_add_compound_image_field.php',        // Render project facilities metabox.
	'inc/city/cob_add_compounds_columns.php',        // Render project facilities metabox.
	'inc/city/cob_save_compounds_developer_city_field.php',        // Render project facilities metabox.
);

// Include required files using locate_template to ensure the file exists.
foreach ( $required_files as $file ) {
	$filepath = locate_template( $file );
	if ( $filepath ) {
		require_once $filepath;
	} else {
		// Log missing file for debugging.
		error_log( sprintf( 'Required file missing: %s', $file ) );
	}
}

/**
 * Remove WordPress version for security reasons.
 *
 * @return string Empty string.
 */
function cob_remove_wp_version() {
	return '';
}
add_filter( 'the_generator', 'cob_remove_wp_version' );

/**
 * Clear factory cache by deleting transients related to factories.
 *
 * @param int $post_id Post ID.
 */
function cob_clear_factory_cache( $post_id ) {
	global $wpdb;
	$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_latest_factories_%'" );
}
add_action( 'save_post_factory', 'cob_clear_factory_cache' );

/**
 * Retrieve theme icon markup.
 *
 * @param string $name Icon name.
 * @param int    $size Icon size (default 24).
 *
 * @return string SVG markup for the icon, or an empty string if not found.
 */
function cob_theme_icon( $name, $size = 24 ) {
	$icons = array(
		'location' => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 ' . $size . ' ' . $size . '" xmlns="http://www.w3.org/2000/svg"><!-- SVG content for location icon --></svg>',
		'area'     => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 ' . $size . ' ' . $size . '" xmlns="http://www.w3.org/2000/svg"><!-- SVG content for area icon --></svg>',
	);
	return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}
