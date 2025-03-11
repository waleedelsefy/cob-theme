<?php
$stored_facilities = get_post_meta( get_the_ID(), '_project_facilities', true );
$stored_facilities = maybe_unserialize( $stored_facilities );

$facilities = [
    'water_games'         => __('Water Games', 'cob_theme'),
    'security'            => __('Security', 'cob_theme'),
    'sports_clubs'        => __('Sports Clubs', 'cob_theme'),
    'electronic_gates'    => __('Electronic Gates', 'cob_theme'),
    'car_garages'         => __('Car Garages', 'cob_theme'),
    'maintenance_cleaning'=> __('Maintenance and Cleaning', 'cob_theme'),
    'internet_networks'   => __('Internet Networks', 'cob_theme'),
    'cafes_restaurants'   => __('Cafes and Restaurants', 'cob_theme'),
    'kids_area'           => __('Kids Area', 'cob_theme'),
    'shopping_center'     => __('Shopping Center', 'cob_theme'),
    'green_spaces'        => __('Green Spaces', 'cob_theme'),
    'cycling_lanes'       => __('Cycling Lanes', 'cob_theme'),
    'power_generators'    => __('Power Generators', 'cob_theme'),
];


if ( is_array( $stored_facilities ) && ! empty( $stored_facilities ) ) {
    $facilities_to_show = $stored_facilities;
} else {
    $facilities_keys = array_keys( $facilities );
    shuffle( $facilities_keys );
    $facilities_to_show = array_slice( $facilities_keys, 0, 5 );
}

if ( $facilities_to_show && is_array( $facilities_to_show ) ) {
    foreach ( $facilities_to_show as $facility_key ) {
        echo '<div class="tag">';
        echo '<div class="facility-img">';
        switch ( $facility_key ) {
            case 'water_games':
                echo '<i class="fa-solid fa-water"></i>';
                break;
            case 'security':
                echo '<i class="fa-duotone fa-user-secret"></i>';
                break;
            case 'sports_clubs':
                echo '<i class="fa-solid fa-golf-club"></i>';
                break;
            case 'electronic_gates':
                echo '<i class="fa-solid fa-door-open"></i>';
                break;
            case 'car_garages':
                echo '<i class="fa-solid fa-cars"></i>';
                break;
            case 'maintenance_cleaning':
                echo '<i class="fa-solid fa-shower"></i>';
                break;
            case 'internet_networks':
                echo '<i class="fa-solid fa-globe"></i>';
                break;
            case 'cafes_restaurants':
                echo '<i class="fa-solid fa-fork-knife"></i>';
                break;
            case 'kids_area':
                echo '<i class="fa-solid fa-family-pants"></i>';
                break;
            case 'shopping_center':
                echo '<i class="fa-solid fa-cart-shopping"></i>';
                break;
            case 'green_spaces':
                echo '<i class="fa-solid fa-leafy-green"></i>';
                break;
            case 'cycling_lanes':
                echo '<i class="fa-solid fa-person-biking-mountain"></i>';
                break;
            case 'power_generators':
                echo '<i class="fa-solid fa-plug"></i>';
                break;
            default:
                echo '';
                break;
        }
        echo '</div>';
        echo '<div class="facility-txt">' . esc_html( $facilities[ $facility_key ] ?? '' ) . '</div>';
        echo '</div>';
    }
}
?>
