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

	// Define property fields and retrieve their values from post meta.
	$fields = array(
		'area'             => __( 'Area (sqm)', 'cob_theme' ),
		'price'            => __( 'Price (EGP)', 'cob_theme' ),
		'max_price'        => __( 'Max Price (EGP)', 'cob_theme' ),
		'min_price'        => __( 'Min Price (EGP)', 'cob_theme' ),
		'rooms'            => __( 'Rooms', 'cob_theme' ),
		'bathrooms'        => __( 'Bathrooms', 'cob_theme' ),
		'reference_number' => __( 'Reference Number', 'cob_theme' ),
		'delivery_year'    => __( 'Delivery Year', 'cob_theme' ),
	);

	// Retrieve payment plans stored as an array.
	$payment_plans = get_post_meta( $post_id, 'cob_payment_plans', true );
	if ( ! is_array( $payment_plans ) ) {
		$payment_plans = array();
	}

	// Security nonce.
	wp_nonce_field( 'cob_save_property_details', 'cob_property_nonce' );
	?>
    <div class="cob-property-metabox">
        <h3><?php _e( 'Property Details', 'cob_theme' ); ?></h3>
		<?php foreach ( $fields as $field => $label ) : ?>
            <p>
                <label for="cob_<?php echo esc_attr( $field ); ?>"><?php echo esc_html( $label ); ?></label>
                <input type="text" id="cob_<?php echo esc_attr( $field ); ?>" name="cob_<?php echo esc_attr( $field ); ?>" value="<?php echo esc_attr( get_post_meta( $post_id, 'cob_' . $field, true ) ); ?>" class="widefat">
            </p>
		<?php endforeach; ?>

        <h3><?php _e( 'Payment Plans', 'cob_theme' ); ?></h3>
        <div id="cob-payment-plans">
			<?php if ( ! empty( $payment_plans ) ) : ?>
				<?php foreach ( $payment_plans as $plan ) : ?>
                    <div class="cob-payment-plan">
                        <input type="number" name="cob_down_payment[]" value="<?php echo esc_attr( $plan['down_payment_percentage'] ); ?>" min="0" max="100" placeholder="<?php _e( 'Down Payment %', 'cob_theme' ); ?>" class="widefat">
                        <input type="number" name="cob_years[]" value="<?php echo esc_attr( $plan['years'] ); ?>" min="1" placeholder="<?php _e( 'Years', 'cob_theme' ); ?>" class="widefat">
                        <button type="button" class="button remove-plan"><?php _e( 'Remove', 'cob_theme' ); ?></button>
                    </div>
				<?php endforeach; ?>
			<?php endif; ?>
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
 * Save Property Details & Payment Plans.
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

	// List of property fields.
	$fields = array(
		'area'             => floatval( $_POST['cob_area'] ?? 0 ),
		'price'            => floatval( $_POST['cob_price'] ?? 0 ),
		'max_price'        => floatval( $_POST['cob_max_price'] ?? 0 ),
		'min_price'        => floatval( $_POST['cob_min_price'] ?? 0 ),
		'rooms'            => intval( $_POST['cob_rooms'] ?? 0 ),
		'bathrooms'        => intval( $_POST['cob_bathrooms'] ?? 0 ),
		'reference_number' => sanitize_text_field( $_POST['cob_reference_number'] ?? '' ),
		'delivery_year'    => intval( $_POST['cob_delivery_year'] ?? 0 ),
	);

	// Update each property detail as a separate meta field.
	foreach ( $fields as $key => $value ) {
		update_post_meta( $post_id, 'cob_' . $key, $value );
	}

	// Process payment plans.
	$payment_plans = array();
	if (
		isset( $_POST['cob_down_payment'], $_POST['cob_years'] ) &&
		is_array( $_POST['cob_down_payment'] ) &&
		is_array( $_POST['cob_years'] )
	) {
		foreach ( $_POST['cob_down_payment'] as $index => $down_payment ) {
			$down_payment_value = min( max( floatval( $down_payment ), 0 ), 100 );
			$years_value        = intval( $_POST['cob_years'][ $index ] );
			$payment_plans[] = array(
				'down_payment_percentage' => $down_payment_value,
				'years'                   => $years_value,
			);
		}
	}

	// Save payment plans as a serialized array in post meta.
	update_post_meta( $post_id, 'cob_payment_plans', $payment_plans );
}
add_action( 'save_post', 'cob_save_property_details' );
