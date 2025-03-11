<?php
/**
 * Register Property Metabox for All Post Types
 *
 * @package Capital_of_Business
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Add the property metabox to specified post types.
 */
function cob_add_property_metabox() {
    $post_types = array( 'properties', 'factory' );
    foreach ( $post_types as $post_type ) {
        add_meta_box(
            'cob_property_details',
            __( 'Property Details & Payment Plans', 'cob_theme' ),
            'cob_render_property_metabox',
            $post_type,
            'side',
            'high'
        );
    }
}
add_action( 'add_meta_boxes', 'cob_add_property_metabox' );

/**
 * Render the Property Details & Payment Plans metabox.
 *
 * @param WP_Post $post The post object.
 */
function cob_render_property_metabox( $post ) {
    $post_id = $post->ID;

    // Define property fields and their labels.
    $fields = array(
        'area'             => __( 'Area (sqm)', 'cob_theme' ),
        'price'            => __( 'Price (EGP)', 'cob_theme' ),
        'max_price'        => __( 'Max Price (EGP)', 'cob_theme' ),
        'min_price'        => __( 'Min Price (EGP)', 'cob_theme' ),
        'bedrooms'            => __( 'Rooms', 'cob_theme' ),
        'bathrooms'        => __( 'Bathrooms', 'cob_theme' ),
        'reference_number' => __( 'Reference Number', 'cob_theme' ),
        'delivery_year'    => __( 'Delivery Year', 'cob_theme' ),
    );

    // Retrieve payment plan values stored as normal post meta.
    $down_payments = get_post_meta( $post_id, 'cob_down_payment' );
    $years         = get_post_meta( $post_id, 'cob_years' );

    // Security nonce.
    wp_nonce_field( 'cob_save_property_details', 'cob_property_nonce' );
    ?>
    <div class="cob-property-metabox">
        <h3><?php _e( 'Property Details', 'cob_theme' ); ?></h3>
        <?php foreach ( $fields as $field => $label ) : ?>
            <p>
                <label for="<?php echo esc_attr( $field ); ?>"><?php echo esc_html( $label ); ?></label>
                <input type="text" id="<?php echo esc_attr( $field ); ?>" name="<?php echo esc_attr( $field ); ?>" value="<?php echo esc_attr( get_post_meta( $post_id,  $field, true ) ); ?>" class="widefat">
            </p>
        <?php endforeach; ?>

        <h3><?php _e( 'Payment Plans', 'cob_theme' ); ?></h3>
        <div id="cob-payment-plans">
            <?php
            $plans_count = max( count( $down_payments ), count( $years ) );
            if ( $plans_count > 0 ) :
                for ( $i = 0; $i < $plans_count; $i++ ) :
                    $down_payment_val = isset( $down_payments[ $i ] ) ? $down_payments[ $i ] : '';
                    $year_val         = isset( $years[ $i ] ) ? $years[ $i ] : '';
                    ?>
                    <div class="cob-payment-plan">
                        <input type="number" name="cob_down_payment[]" value="<?php echo esc_attr( $down_payment_val ); ?>" min="0" max="100" placeholder="<?php _e( 'Down Payment %', 'cob_theme' ); ?>" class="widefat">
                        <input type="number" name="cob_years[]" value="<?php echo esc_attr( $year_val ); ?>" min="1" placeholder="<?php _e( 'Years', 'cob_theme' ); ?>" class="widefat">
                        <button type="button" class="button remove-plan"><?php _e( 'Remove', 'cob_theme' ); ?></button>
                    </div>
                <?php
                endfor;
            endif;
            ?>
        </div>
        <button type="button" class="button" id="cob-add-plan"><?php _e( 'Add Payment Plan', 'cob_theme' ); ?></button>
    </div>

    <script>
        (function() {
            document.addEventListener('DOMContentLoaded', function() {
                var addPlanButton = document.getElementById('cob-add-plan');
                var plansContainer = document.getElementById('cob-payment-plans');

                addPlanButton.addEventListener('click', function() {
                    var planDiv = document.createElement('div');
                    planDiv.classList.add('cob-payment-plan');
                    planDiv.innerHTML = '<input type="number" name="cob_down_payment[]" min="0" max="100" placeholder="<?php echo esc_js( __( 'Down Payment %', 'cob_theme' ) ); ?>" class="widefat">' +
                        '<input type="number" name="cob_years[]" min="1" placeholder="<?php echo esc_js( __( 'Years', 'cob_theme' ) ); ?>" class="widefat">' +
                        '<button type="button" class="button remove-plan"><?php echo esc_js( __( 'Remove', 'cob_theme' ) ); ?></button>';
                    plansContainer.appendChild(planDiv);
                });

                document.addEventListener('click', function(e) {
                    if ( e.target && e.target.classList.contains('remove-plan') ) {
                        e.target.parentElement.remove();
                    }
                });
            });
        })();
    </script>
    <?php
}

/**
 * Save Property Details & Payment Plans as normal post meta.
 *
 * @param int $post_id The ID of the post being saved.
 */
function cob_save_property_details( $post_id ) {
    // Verify nonce.
    if ( ! isset( $_POST['cob_property_nonce'] ) || ! wp_verify_nonce( $_POST['cob_property_nonce'], 'cob_save_property_details' ) ) {
        return;
    }
    // Prevent autosave.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    // Check user permissions.
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Save property fields as individual post meta with the 'cob_' prefix.
    update_post_meta( $post_id, 'area', isset( $_POST['area'] ) ? floatval( $_POST['area'] ) : 0 );
    update_post_meta( $post_id, 'price', isset( $_POST['price'] ) ? floatval( $_POST['price'] ) : 0 );
    update_post_meta( $post_id, 'max_price', isset( $_POST['max_price'] ) ? floatval( $_POST['max_price'] ) : 0 );
    update_post_meta( $post_id, 'min_price', isset( $_POST['min_price'] ) ? floatval( $_POST['min_price'] ) : 0 );
    update_post_meta( $post_id, 'bedrooms', isset( $_POST['bedrooms'] ) ? intval( $_POST['bedrooms'] ) : 0 );
    update_post_meta( $post_id, 'bathrooms', isset( $_POST['bathrooms'] ) ? intval( $_POST['bathrooms'] ) : 0 );
    update_post_meta( $post_id, 'reference_number', isset( $_POST['reference_number'] ) ? sanitize_text_field( $_POST['reference_number'] ) : '' );
    update_post_meta( $post_id, 'delivery_year', isset( $_POST['delivery_year'] ) ? intval( $_POST['delivery_year'] ) : 0 );

    // Process Payment Plans.
    // أولاً، نحذف القيم السابقة.
    delete_post_meta( $post_id, 'cob_down_payment' );
    delete_post_meta( $post_id, 'cob_years' );

    if ( isset( $_POST['cob_down_payment'], $_POST['cob_years'] ) && is_array( $_POST['cob_down_payment'] ) && is_array( $_POST['cob_years'] ) ) {
        $down_payments = $_POST['cob_down_payment'];
        $years = $_POST['cob_years'];
        $count = count( $down_payments );
        for ( $i = 0; $i < $count; $i++ ) {
            $down_payment_value = min( max( floatval( $down_payments[ $i ] ), 0 ), 100 );
            $year_value = intval( $years[ $i ] );
            add_post_meta( $post_id, 'cob_down_payment', $down_payment_value );
            add_post_meta( $post_id, 'cob_years', $year_value );
        }
    }
}
add_action( 'save_post', 'cob_save_property_details' );
