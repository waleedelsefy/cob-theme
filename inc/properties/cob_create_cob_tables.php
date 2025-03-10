<?php
/**
 * Create Custom Tables on Plugin Activation
 */
function cob_create_custom_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $table_property_details = $wpdb->prefix . 'property_details';
    $table_payment_plans = $wpdb->prefix . 'payment_plans';

    $sql_property_details = "CREATE TABLE IF NOT EXISTS $table_property_details (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        post_id BIGINT(20) UNSIGNED NOT NULL,
        area FLOAT DEFAULT NULL,
        price FLOAT DEFAULT NULL,
        max_price FLOAT DEFAULT NULL,
        min_price FLOAT DEFAULT NULL,
        rooms INT(11) DEFAULT NULL,
        bathrooms INT(11) DEFAULT NULL,
        reference_number VARCHAR(100) DEFAULT NULL,
        delivery_year INT(11) DEFAULT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY post_id (post_id)
    ) $charset_collate;";

    $sql_payment_plans = "CREATE TABLE IF NOT EXISTS $table_payment_plans (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        post_id BIGINT(20) UNSIGNED NOT NULL,
        down_payment_percentage FLOAT DEFAULT NULL,
        years INT(11) DEFAULT NULL,
        PRIMARY KEY (id),
        KEY post_id (post_id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql_property_details);
    dbDelta($sql_payment_plans);
}

register_activation_hook(__FILE__, 'cob_create_custom_tables');
