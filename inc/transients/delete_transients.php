<?php
/**
 * Handle deletion of transients when the admin bar button is clicked.
 */
function cob_handle_delete_transients() {
    // Check if the current user has the required capability.
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // If the URL contains the delete action.
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'delete_transients' ) {
        global $wpdb;

        // Delete all transients (including site transients).
        $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'" );

        // Redirect to the same page without the action parameter and add a confirmation flag.
        wp_redirect( remove_query_arg( 'action' ) . '&deleted_transients=1' );
        exit;
    }
}
add_action( 'admin_init', 'cob_handle_delete_transients' );

/**
 * Display an admin notice after successful deletion.
 */
function cob_admin_notices() {
    if ( isset( $_GET['deleted_transients'] ) && $_GET['deleted_transients'] == 1 ) {
        echo '<div class="updated notice"><p>' . __( 'Transients deleted successfully.', 'cob_theme' ) . '</p></div>';
    }
}
add_action( 'admin_notices', 'cob_admin_notices' );

/**
 * Add a button in the admin bar for deleting transients.
 *
 * @param WP_Admin_Bar $wp_admin_bar The WP_Admin_Bar instance.
 */
function cob_add_delete_transients_button( $wp_admin_bar ) {
    // Check if the current user has the required capability.
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Build the URL for deleting transients.
    $delete_url = add_query_arg( 'action', 'delete_transients', admin_url() );

    // Define the admin bar node.
    $args = array(
        'id'    => 'delete_transients',
        'title' => __( 'Delete Transients', 'cob_theme' ),
        'href'  => $delete_url,
        'meta'  => array( 'class' => 'delete-transients-button' )
    );
    $wp_admin_bar->add_node( $args );
}
add_action( 'admin_bar_menu', 'cob_add_delete_transients_button', 100 );
