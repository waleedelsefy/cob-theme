<?php
/**
 * Register Custom Post Types and Taxonomies
 *
 * @package Capital_of_Business
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get Property Details from Custom Table
 */
function get_property_details($field, $post_id = null) {
    global $wpdb;

    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $table_property_details = $wpdb->prefix . 'property_details';

    $property = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_property_details WHERE post_id = %d", $post_id), ARRAY_A);

    return $property[$field] ?? null;
}
