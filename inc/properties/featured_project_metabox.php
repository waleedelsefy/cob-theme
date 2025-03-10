<?php
function add_featured_project_metabox() {
    add_meta_box(
        'featured_project',
        __( 'Featured Project', 'cob-theme' ),
        'render_featured_project_metabox',
        'projects',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'add_featured_project_metabox' );

function render_featured_project_metabox( $post ) {
    $featured = get_post_meta( $post->ID, '_is_featured', true );
    ?>
    <label for="is_featured">
        <input type="checkbox" name="is_featured" id="is_featured" value="yes" <?php checked( $featured, 'yes' ); ?>>
        <?php _e( 'Mark as Featured', 'your-text-domain' ); ?>
    </label>
    <?php
}

function save_featured_project_metabox( $post_id ) {
    if ( isset( $_POST['is_featured'] ) && $_POST['is_featured'] === 'yes' ) {
        update_post_meta( $post_id, '_is_featured', 'yes' );
    } else {
        update_post_meta( $post_id, '_is_featured', '' );
    }
}
add_action( 'save_post', 'save_featured_project_metabox' );


add_action( 'save_post', 'save_featured_project_metabox' );
function cob_add_featured_column( $columns ) {
    $new_columns = [];
    foreach ( $columns as $key => $value ) {
        $new_columns[ $key ] = $value;
        if ( 'title' === $key ) {
            $new_columns['featured'] = __( 'Featured', 'cob_theme' );
        }
    }
    return $new_columns;
}
add_filter( 'manage_projects_posts_columns', 'cob_add_featured_column' );

function cob_show_featured_column( $column, $post_id ) {
    if ( 'featured' === $column ) {
        $is_featured = get_post_meta( $post_id, '_is_featured', true );
        $class = ( 'yes' === $is_featured ) ? 'dashicons dashicons-star-filled featured' : 'dashicons dashicons-star-empty not-featured';
        echo '<span class="toggle-featured" data-postid="' . esc_attr( $post_id ) . '" style="cursor:pointer;">';
        echo '<span class="' . esc_attr( $class ) . '"></span>';
        echo '</span>';
    }
}
add_action( 'manage_projects_posts_custom_column', 'cob_show_featured_column', 10, 2 );

function cob_toggle_featured_project() {
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'toggle_featured_nonce' ) ) {
        wp_send_json_error( array( 'message' => __( 'Nonce verification failed', 'cob_theme' ) ) );
    }
    if ( ! current_user_can( 'edit_post', $_POST['post_id'] ) ) {
        wp_send_json_error( array( 'message' => __( 'You are not allowed to edit this post', 'cob_theme' ) ) );
    }

    $post_id = intval( $_POST['post_id'] );
    $current = get_post_meta( $post_id, '_is_featured', true );

    if ( 'yes' === $current ) {
        update_post_meta( $post_id, '_is_featured', '' );
        $new_status = '';
    } else {
        update_post_meta( $post_id, '_is_featured', 'yes' );
        $new_status = 'yes';
    }

    wp_send_json_success( array( 'new_status' => $new_status ) );
}
add_action( 'wp_ajax_toggle_featured_project', 'cob_toggle_featured_project' );

function cob_enqueue_admin_featured_script( $hook ) {
    global $post_type;
    if ( 'edit.php' !== $hook || 'projects' !== $post_type ) {
        return;
    }
    wp_enqueue_script(
        'cob-featured-toggle',
        get_template_directory_uri() . '/admin/js/featured-toggle.js',
        array( 'jquery' ),
        '1.0',
        true
    );
    wp_localize_script( 'cob-featured-toggle', 'cobFeatured', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'toggle_featured_nonce' ),
    ) );
}
add_action( 'admin_enqueue_scripts', 'cob_enqueue_admin_featured_script' );
