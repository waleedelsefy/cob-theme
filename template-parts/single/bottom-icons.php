<?php
$post_id = get_the_ID();
$area         = get_property_details( 'area', $post_id );
$rooms         = get_property_details( 'rooms ', $post_id );
$bathrooms         = get_property_details( 'bathrooms', $post_id );

?>  <div class="bottom-icons">
    <div>
        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20.5 6V18M18.5 4H6.5M18.5 20H6.5M4.5 18V6" stroke="#707070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M22.5 4C22.5 5.10457 21.6046 6 20.5 6C19.3954 6 18.5 5.10457 18.5 4C18.5 2.89543 19.3954 2 20.5 2C21.6046 2 22.5 2.89543 22.5 4Z" stroke="#707070" stroke-width="1.5"></path>
            <path d="M6.5 4C6.5 5.10457 5.60457 6 4.5 6C3.39543 6 2.5 5.10457 2.5 4C2.5 2.89543 3.39543 2 4.5 2C5.60457 2 6.5 2.89543 6.5 4Z" stroke="#707070" stroke-width="1.5"></path>
            <path d="M22.5 20C22.5 21.1046 21.6046 22 20.5 22C19.3954 22 18.5 21.1046 18.5 20C18.5 18.8954 19.3954 18 20.5 18C21.6046 18 22.5 18.8954 22.5 20Z" stroke="#707070" stroke-width="1.5"></path>
            <path d="M6.5 20C6.5 21.1046 5.60457 22 4.5 22C3.39543 22 2.5 21.1046 2.5 20C2.5 18.8954 3.39543 18 4.5 18C5.60457 18 6.5 18.8954 6.5 20Z" stroke="#707070" stroke-width="1.5"></path>
        </svg>
        <span><?php echo esc_html( $area ); ?></span>
    </div>
    <div>
        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22.5 17.5H2.5" stroke="#707070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M22.5 21V16C22.5 14.1144 22.5 13.1716 21.9142 12.5858C21.3284 12 20.3856 12 18.5 12H6.5C4.61438 12 3.67157 12 3.08579 12.5858C2.5 13.1716 2.5 14.1144 2.5 16V21" stroke="#707070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M11.5 12V10.2134C11.5 9.83272 11.4428 9.70541 11.1497 9.55538C10.5395 9.24292 9.79865 9 9 9C8.20135 9 7.46055 9.24292 6.85025 9.55538C6.55721 9.70541 6.5 9.83272 6.5 10.2134V12" stroke="#707070" stroke-width="1.5" stroke-linecap="round"></path>
            <path d="M18.5 12V10.2134C18.5 9.83272 18.4428 9.70541 18.1497 9.55538C17.5395 9.24292 16.7987 9 16 9C15.2013 9 14.4605 9.24292 13.8503 9.55538C13.5572 9.70541 13.5 9.83272 13.5 10.2134V12" stroke="#707070" stroke-width="1.5" stroke-linecap="round"></path>
        </svg>
        <span><?php echo esc_html( $rooms ); ?></span>
    </div>
    <div>
        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.5 20L5.5 21M18.5 20L19.5 21" stroke="#707070" stroke-width="1.5" stroke-linecap="round"></path>
            <path d="M3.5 12V13C3.5 16.2998 3.5 17.9497 4.52513 18.9749C5.55025 20 7.20017 20 10.5 20H14.5C17.7998 20 19.4497 20 20.4749 18.9749C21.5 17.9497 21.5 16.2998 21.5 13V12" stroke="#707070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M2.5 12H22.5" stroke="#707070" stroke-width="1.5" stroke-linecap="round"></path>
            <path d="M4.5 12V5.5234C4.5 4.12977 5.62977 3 7.0234 3C8.14166 3 9.12654 3.73598 9.44339 4.80841L9.5 5" stroke="#707070" stroke-width="1.5" stroke-linecap="round"></path>
            <path d="M8.5 6L11 4" stroke="#707070" stroke-width="1.5" stroke-linecap="round"></path>
        </svg>
        <span><?php echo esc_html( $bathrooms ); ?></span>
    </div>
</div>