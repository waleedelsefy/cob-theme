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
                echo '<svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M17.8011 23.1671H14.2011C10.9078 23.1671 9.50781 21.7605 9.50781 18.4738V15.4805C9.50781 15.2071 9.73448 14.9805 10.0078 14.9805C10.2811 14.9805 10.5078 15.2071 10.5078 15.4805V18.4738C10.5078 21.2005 11.4745 22.1671 14.2011 22.1671H17.7945C20.5211 22.1671 21.4878 21.2005 21.4878 18.4738V15.4805C21.4878 15.2071 21.7145 14.9805 21.9878 14.9805C22.2611 14.9805 22.4878 15.2071 22.4878 15.4805V18.4738C22.4945 21.7605 21.0878 23.1671 17.8011 23.1671Z" fill="black"/>
<path d="M15.9993 16.4999C15.266 16.4999 14.5994 16.2133 14.126 15.6866C13.6527 15.1599 13.4327 14.4733 13.506 13.7399L13.9527 9.28659C13.9794 9.03325 14.1927 8.83325 14.4527 8.83325H17.566C17.826 8.83325 18.0394 9.02659 18.066 9.28659L18.5127 13.7399C18.586 14.4733 18.366 15.1599 17.8927 15.6866C17.3994 16.2133 16.7327 16.4999 15.9993 16.4999ZM14.8994 9.83325L14.4993 13.8399C14.4527 14.2866 14.586 14.7066 14.866 15.0133C15.4327 15.6399 16.566 15.6399 17.1327 15.0133C17.4127 14.6999 17.546 14.2799 17.4994 13.8399L17.0994 9.83325H14.8994Z" fill="black"/>
<path d="M20.2041 16.4997C18.8507 16.4997 17.6441 15.4063 17.5041 14.0597L17.0374 9.38634C17.0241 9.24634 17.0707 9.10634 17.1641 8.99967C17.2574 8.89301 17.3907 8.83301 17.5374 8.83301H19.5707C21.5307 8.83301 22.4441 9.65301 22.7174 11.6663L22.9041 13.5197C22.9841 14.3063 22.7441 15.053 22.2307 15.6197C21.7174 16.1863 20.9974 16.4997 20.2041 16.4997ZM18.0907 9.83301L18.5041 13.9597C18.5907 14.793 19.3641 15.4997 20.2041 15.4997C20.7107 15.4997 21.1641 15.3063 21.4907 14.953C21.8107 14.5997 21.9574 14.1263 21.9107 13.6197L21.7241 11.7863C21.5174 10.2797 21.0307 9.83301 19.5707 9.83301H18.0907ZM11.7581 16.4997C10.9647 16.4997 10.2447 16.1863 9.73139 15.6197C9.21806 15.053 8.97806 14.3063 9.05806 13.5197L9.23806 11.6863C9.51806 9.65301 10.4314 8.83301 12.3914 8.83301H14.4247C14.5647 8.83301 14.6981 8.89301 14.7981 8.99967C14.8981 9.10634 14.9381 9.24634 14.9247 9.38634L14.4581 14.0597C14.3181 15.4063 13.1114 16.4997 11.7581 16.4997ZM12.3914 9.83301C10.9314 9.83301 10.4447 10.273 10.2314 11.7997L10.0514 13.6197C9.99806 14.1263 10.1514 14.5997 10.4714 14.953C10.7914 15.3063 11.2447 15.4997 11.7581 15.4997C12.5981 15.4997 13.3781 14.793 13.4581 13.9597L13.8714 9.83301H12.3914ZM17.6654 23.1663H14.3321C14.0587 23.1663 13.8321 22.9397 13.8321 22.6663V20.9997C13.8321 19.5997 14.5987 18.833 15.9987 18.833C17.3987 18.833 18.1654 19.5997 18.1654 20.9997V22.6663C18.1654 22.9397 17.9387 23.1663 17.6654 23.1663ZM14.8321 22.1663H17.1654V20.9997C17.1654 20.1597 16.8387 19.833 15.9987 19.833C15.1587 19.833 14.8321 20.1597 14.8321 20.9997V22.1663Z" fill="black"/>
</svg>
';
                break;
            case 'electronic_gates':
                echo '<svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M17.8011 23.1671H14.2011C10.9078 23.1671 9.50781 21.7605 9.50781 18.4738V15.4805C9.50781 15.2071 9.73448 14.9805 10.0078 14.9805C10.2811 14.9805 10.5078 15.2071 10.5078 15.4805V18.4738C10.5078 21.2005 11.4745 22.1671 14.2011 22.1671H17.7945C20.5211 22.1671 21.4878 21.2005 21.4878 18.4738V15.4805C21.4878 15.2071 21.7145 14.9805 21.9878 14.9805C22.2611 14.9805 22.4878 15.2071 22.4878 15.4805V18.4738C22.4945 21.7605 21.0878 23.1671 17.8011 23.1671Z" fill="black"/>
<path d="M15.9993 16.4999C15.266 16.4999 14.5994 16.2133 14.126 15.6866C13.6527 15.1599 13.4327 14.4733 13.506 13.7399L13.9527 9.28659C13.9794 9.03325 14.1927 8.83325 14.4527 8.83325H17.566C17.826 8.83325 18.0394 9.02659 18.066 9.28659L18.5127 13.7399C18.586 14.4733 18.366 15.1599 17.8927 15.6866C17.3994 16.2133 16.7327 16.4999 15.9993 16.4999ZM14.8994 9.83325L14.4993 13.8399C14.4527 14.2866 14.586 14.7066 14.866 15.0133C15.4327 15.6399 16.566 15.6399 17.1327 15.0133C17.4127 14.6999 17.546 14.2799 17.4994 13.8399L17.0994 9.83325H14.8994Z" fill="black"/>
<path d="M20.2041 16.4997C18.8507 16.4997 17.6441 15.4063 17.5041 14.0597L17.0374 9.38634C17.0241 9.24634 17.0707 9.10634 17.1641 8.99967C17.2574 8.89301 17.3907 8.83301 17.5374 8.83301H19.5707C21.5307 8.83301 22.4441 9.65301 22.7174 11.6663L22.9041 13.5197C22.9841 14.3063 22.7441 15.053 22.2307 15.6197C21.7174 16.1863 20.9974 16.4997 20.2041 16.4997ZM18.0907 9.83301L18.5041 13.9597C18.5907 14.793 19.3641 15.4997 20.2041 15.4997C20.7107 15.4997 21.1641 15.3063 21.4907 14.953C21.8107 14.5997 21.9574 14.1263 21.9107 13.6197L21.7241 11.7863C21.5174 10.2797 21.0307 9.83301 19.5707 9.83301H18.0907ZM11.7581 16.4997C10.9647 16.4997 10.2447 16.1863 9.73139 15.6197C9.21806 15.053 8.97806 14.3063 9.05806 13.5197L9.23806 11.6863C9.51806 9.65301 10.4314 8.83301 12.3914 8.83301H14.4247C14.5647 8.83301 14.6981 8.89301 14.7981 8.99967C14.8981 9.10634 14.9381 9.24634 14.9247 9.38634L14.4581 14.0597C14.3181 15.4063 13.1114 16.4997 11.7581 16.4997ZM12.3914 9.83301C10.9314 9.83301 10.4447 10.273 10.2314 11.7997L10.0514 13.6197C9.99806 14.1263 10.1514 14.5997 10.4714 14.953C10.7914 15.3063 11.2447 15.4997 11.7581 15.4997C12.5981 15.4997 13.3781 14.793 13.4581 13.9597L13.8714 9.83301H12.3914ZM17.6654 23.1663H14.3321C14.0587 23.1663 13.8321 22.9397 13.8321 22.6663V20.9997C13.8321 19.5997 14.5987 18.833 15.9987 18.833C17.3987 18.833 18.1654 19.5997 18.1654 20.9997V22.6663C18.1654 22.9397 17.9387 23.1663 17.6654 23.1663ZM14.8321 22.1663H17.1654V20.9997C17.1654 20.1597 16.8387 19.833 15.9987 19.833C15.1587 19.833 14.8321 20.1597 14.8321 20.9997V22.1663Z" fill="black"/>
</svg>
';
                break;
            case 'car_garages':
                echo '<i class="fa-solid fa-cars"></i>';
                break;
            case 'maintenance_cleaning':
                echo '<svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_5_8454)">
<path d="M9.8407 19.2369C10.0929 19.2143 10.2789 18.9913 10.2563 18.7389C10.2336 18.4864 10.0108 18.3001 9.75865 18.3228C9.50647 18.3454 9.32042 18.5684 9.34308 18.8208C9.36573 19.0733 9.58853 19.2595 9.8407 19.2369Z" fill="black"/>
<path d="M15.6324 22.399L18.4932 21.7429C18.8485 21.6615 19.1469 21.438 19.3334 21.1134C19.5132 20.8004 19.5667 20.4292 19.4841 20.0684C19.4397 19.8737 19.3561 19.6902 19.2382 19.529C19.7006 19.2157 19.9399 18.6303 19.8031 18.0328C19.7633 17.8585 19.6921 17.6929 19.5929 17.5441C19.8305 17.4311 20.0293 17.2468 20.1669 17.0073C20.3467 16.6943 20.4003 16.3231 20.3176 15.9622C20.2796 15.7952 20.2128 15.636 20.1205 15.4917L21.3727 15.2048L21.3794 15.2032C22.1126 15.0236 22.5503 14.2856 22.3758 13.523L22.3752 13.5205C22.2007 12.7638 21.4711 12.283 20.7486 12.4483L15.8319 13.5778C15.8029 13.3991 15.7668 13.238 15.736 13.1099C15.5952 12.5243 15.3653 11.9393 15.0529 11.3713C14.9311 11.1499 14.7762 10.8946 14.5508 10.6804C14.0438 10.1986 13.2523 10.0992 12.7099 10.4493C12.3073 10.709 12.1179 11.184 12.2273 11.6592L12.3544 12.2114C12.4779 12.7476 12.4214 13.3406 12.2106 13.7224C12.0867 13.9467 11.874 14.1559 11.5953 14.3274C11.2152 14.5613 10.6243 14.7781 9.93157 14.9379L8.97207 15.1591C8.7247 15.2162 8.57025 15.463 8.62696 15.7107L8.88643 16.844C8.94328 17.0924 9.19973 17.2492 9.44646 17.188C9.68645 17.1284 9.83856 16.8794 9.78336 16.6384L9.62653 15.9534L10.1382 15.8355C10.6953 15.7071 11.4839 15.4773 12.0773 15.1121C12.4968 14.854 12.8126 14.5364 13.0159 14.1682C13.3399 13.5813 13.4279 12.7726 13.2511 12.0047L13.124 11.4524C13.1109 11.3957 13.1045 11.2905 13.2085 11.2234C13.421 11.0864 13.7418 11.1815 13.9172 11.3482C14.0513 11.4757 14.1591 11.6559 14.2469 11.8154C14.5197 12.3115 14.7197 12.8195 14.8414 13.3253C14.892 13.5358 14.9599 13.8504 14.9648 14.1513C14.9692 14.438 15.248 14.6584 15.5278 14.5927L20.9543 13.3461C21.1833 13.2934 21.4182 13.465 21.4787 13.7277L21.479 13.7292C21.5394 13.9945 21.4009 14.248 21.1632 14.3079L17.9959 15.0335C17.8895 15.0581 17.7933 15.0918 17.7145 15.1716C17.6697 15.2173 17.6348 15.2717 17.612 15.3314C17.5892 15.3912 17.5791 15.455 17.5822 15.5189C17.5972 15.8006 17.8692 16.0075 18.1444 15.9445L18.9029 15.7708C19.123 15.7315 19.3622 15.9125 19.4207 16.168C19.4514 16.3019 19.4331 16.4369 19.3692 16.548C19.312 16.6476 19.2239 16.7155 19.1207 16.7391L17.771 17.0504C17.6066 17.0883 17.4289 17.1085 17.3085 17.2402C17.1194 17.447 17.162 17.7843 17.3969 17.9373C17.5624 18.0452 17.7304 18.0049 17.9077 17.9641L18.3878 17.8534C18.6132 17.802 18.8457 17.9747 18.9062 18.2387C18.9673 18.5055 18.8294 18.7623 18.5919 18.8256L17.2883 19.1251C17.1856 19.1487 17.0773 19.1642 16.9872 19.2221C16.8443 19.3138 16.762 19.4822 16.7775 19.6514C16.7933 19.8233 16.9065 19.9748 17.0668 20.0382C17.1961 20.0894 17.3189 20.0633 17.4485 20.0334L18.0772 19.8889C18.3001 19.8434 18.5276 20.0141 18.5871 20.2742C18.6178 20.4082 18.5995 20.5431 18.5357 20.6543C18.4784 20.7539 18.3904 20.8218 18.2876 20.8453C18.2876 20.8453 15.3973 21.5084 15.3888 21.5109C14.1709 21.865 12.5408 21.3956 12.308 21.3021C12.208 21.2457 12.0906 21.2287 11.9788 21.2545L10.8973 21.5038L10.7164 20.7137C10.6596 20.4657 10.4127 20.311 10.1652 20.3676C9.9175 20.4244 9.76273 20.6714 9.81949 20.9193L10.1033 22.1589C10.1168 22.2179 10.1417 22.2737 10.1768 22.323C10.2118 22.3723 10.2562 22.4142 10.3075 22.4464C10.3587 22.4785 10.4158 22.5002 10.4755 22.5103C10.5351 22.5203 10.5962 22.5185 10.6551 22.5049L12.0445 22.1845C12.4763 22.3433 13.199 22.4626 13.2083 22.464C13.6623 22.537 14.2647 22.5944 14.8751 22.5374C15.1296 22.5134 15.3854 22.4698 15.6324 22.399Z" fill="black"/>
<path d="M16.483 11.1295C16.6048 11.137 16.7247 11.0958 16.8161 11.015C16.9076 10.9342 16.9633 10.8204 16.9708 10.6985L17.0811 8.92878C17.0969 8.67492 16.9041 8.45627 16.6505 8.44036C16.3966 8.42454 16.1785 8.61743 16.1627 8.87129L16.0524 10.641C16.0366 10.8949 16.2294 11.1136 16.483 11.1295ZM18.0903 12.1908C18.1875 12.1817 18.2793 12.1419 18.3522 12.077L19.6781 10.9013C19.8683 10.7326 19.8858 10.4416 19.7173 10.2512C19.5487 10.0608 19.258 10.0431 19.0678 10.2118L17.742 11.3874C17.5518 11.5561 17.5342 11.8472 17.7027 12.0376C17.7507 12.0919 17.8108 12.134 17.8782 12.1607C17.9455 12.1873 18.0182 12.1976 18.0903 12.1908Z" fill="black"/>
</g>
<defs>
<clipPath id="clip0_5_8454">
<rect width="15" height="15" fill="white" transform="translate(8 8)"/>
</clipPath>
</defs>
</svg>
';
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
                echo '<svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M20.0621 12.9501V16.1688C20.0621 18.0938 18.9621 18.9188 17.3121 18.9188H11.8184C11.5371 18.9188 11.2684 18.8938 11.0184 18.8376C10.8621 18.8126 10.7121 18.7688 10.5746 18.7188C9.63711 18.3688 9.06836 17.5563 9.06836 16.1688V12.9501C9.06836 11.0251 10.1684 10.2001 11.8184 10.2001H17.3121C18.7121 10.2001 19.7184 10.7938 19.9871 12.1501C20.0309 12.4001 20.0621 12.6563 20.0621 12.9501Z" stroke="black" stroke-width="1.125" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M21.9383 14.8251V18.0439C21.9383 19.9689 20.8383 20.7939 19.1883 20.7939H13.6945C13.232 20.7939 12.8133 20.7314 12.4508 20.5939C11.707 20.3189 11.2008 19.7502 11.0195 18.8377C11.2695 18.8939 11.5383 18.9189 11.8195 18.9189H17.3133C18.9633 18.9189 20.0633 18.0939 20.0633 16.1689V12.9501C20.0633 12.6564 20.0383 12.3939 19.9883 12.1501C21.1758 12.4001 21.9383 13.2376 21.9383 14.8251Z" stroke="black" stroke-width="1.125" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M14.5602 16.2125C15.4714 16.2125 16.2102 15.4738 16.2102 14.5625C16.2102 13.6512 15.4714 12.9125 14.5602 12.9125C13.6489 12.9125 12.9102 13.6512 12.9102 14.5625C12.9102 15.4738 13.6489 16.2125 14.5602 16.2125Z" stroke="black" stroke-width="1.125" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M10.9883 13.1875V15.9375" stroke="black" stroke-width="1.125" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M18.1387 13.1877V15.9378" stroke="black" stroke-width="1.125" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
';
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
