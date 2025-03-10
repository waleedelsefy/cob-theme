<?php

function create_search_table() {
    global $wpdb;
    $table_name      = $wpdb->prefix . 'search';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      search_type varchar(20) NOT NULL,
      keyword     varchar(255) NOT NULL,
      propertie_type   varchar(50) NOT NULL,
      bedrooms    int(11) NOT NULL,
      price       varchar(50) NOT NULL,
      price_from  float DEFAULT 0,
      price_to    float DEFAULT 0,
      date        datetime NOT NULL,
      PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
register_activation_hook( __FILE__, 'create_search_table' );
