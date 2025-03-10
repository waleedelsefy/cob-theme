<?php
/**
 * Factory Listings Template for 'Capital of Business' Theme
 *
 * @package Capital_of_Business
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$theme_dir = get_template_directory_uri();

// Use transient caching to improve performance
$transient_key = 'latest_properties';
$properties_query = get_transient( $transient_key );

if ( false === $properties_query ) {
    $args = [
        'post_type'      => 'properties',
        'posts_per_page' => 6,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'no_found_rows'  => true,
    ];

    $properties_query = new WP_Query( $args );
    set_transient( $transient_key, $properties_query, HOUR_IN_SECONDS );
}
?>

<div class="properties">
    <div class="container">
        <div class="top-properties">
            <div class="right-properties">
                <h3 class="head"><?php echo esc_html__( 'Featured Properties', 'cob_theme' ); ?></h3>
                <h5><?php echo esc_html__( 'Explore the latest real estate projects available', 'cob_theme' ); ?></h5>
            </div>
            <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'flats' ) ) ); ?>" class="properties-button">
                <?php echo esc_html__( 'View All', 'cob_theme' ); ?>
                <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.32561 7.00227L7.4307 12.1033C7.80826 12.4809 7.80826 13.0914 7.4307 13.465C7.05314 13.8385 6.44262 13.8385 6.06506 13.465L0.281171 7.68509C-0.0843415 7.31958 -0.0923715 6.73316 0.253053 6.3556L6.06104 0.535563C6.24982 0.346785 6.49885 0.254402 6.74386 0.254402C6.98887 0.254402 7.2379 0.346785 7.42668 0.535563C7.80424 0.913122 7.80424 1.52364 7.42668 1.89719L2.32561 7.00227Z" fill="black"/>
                </svg>
            </a>
        </div>
        <div class="swiper swiper3">
            <div class="swiper-wrapper">
                <?php if ( $properties_query->have_posts() ) : ?>
                    <?php while ( $properties_query->have_posts() ) : $properties_query->the_post(); ?>
                        <?php
                        // Make sure to use global $wpdb inside the loop.
                        global $wpdb;

                        // Set the post ID before using it in queries.
                        $post_id = get_the_ID();
                        $city_name = esc_html__( 'Not known', 'cob_theme' );
                        $city_link = '';
                        $city_terms = get_the_terms($post_id, 'city');

                        if ($city_terms && !is_wp_error($city_terms)) {
                            $city_name = esc_html($city_terms[0]->name);
                            $city_link = get_term_link($city_terms[0]);
                        }
                        // Define table names.
                        $table_property_details = $wpdb->prefix . 'property_details';
                        $table_payment_plans    = $wpdb->prefix . 'payment_plans';

                        // Fetch property details.


                        $area  = !empty(get_post_meta($post_id, 'area', true)) ? intval(get_post_meta($post_id, 'area', true)) : ' - ';
                        $price = !empty(get_post_meta($post_id, 'price', true)) ? floatval(get_post_meta($post_id, 'price', true)) : ' - ';
                        $max_price = !empty(get_post_meta($post_id, 'max_price', true)) ? floatval(get_post_meta($post_id, 'max_price', true)) : ' - ';
                        $min_price = !empty(get_post_meta($post_id, 'min_price', true)) ? floatval(get_post_meta($post_id, 'min_price', true)) : ' - ';
                        $rooms = !empty(get_post_meta($post_id, 'bedrooms', true)) ? intval(get_post_meta($post_id, 'bedrooms', true)) : ' - ';
                        $bathrooms = !empty(get_post_meta($post_id, 'bathrooms', true)) ? intval(get_post_meta($post_id, 'bathrooms', true)) : ' - ';
                        $delivery_year = !empty(get_post_meta($post_id, 'delivery', true)) ? get_post_meta($post_id, 'delivery', true) : ' - ';

                        if (!empty($price) && floatval($price) > 0) {
                            $final_price = floatval($price);
                        } elseif (!empty($min_price) && floatval($min_price) > 0) {
                            $final_price = floatval($min_price);
                        } elseif (!empty($max_price) && floatval($max_price) > 0) {
                            $final_price = floatval($max_price);
                        } else {
                            $final_price = ' - ';
                        }
                        // Fetch payment plans.
                        $payment_plans = $wpdb->get_results(
                            $wpdb->prepare( "SELECT * FROM $table_payment_plans WHERE post_id = %d", $post_id ),
                            ARRAY_A
                        ) ?: [];

                        // Retrieve additional meta data.
                        $installments = get_post_meta( $post_id, 'propertie_installments', true );
                        $location     = get_post_meta( $post_id, 'propertie_location', true );
                        $propertie_type    = get_post_meta( $post_id, 'propertie_type', true );



                        ?>
                        <div class="swiper-slide">
                            <a href="<?php the_permalink(); ?>" class="properties-card">
                                <ul class="big-ul">
                                    <?php
                                    // Set a default image URL.
                                    $developer_image_url = get_template_directory_uri() . '/assets/imgs/card-devloper-default.png';

                                    // Retrieve the developer term for the current post.
                                    $developers = get_the_terms( $post_id, 'developer' );
                                    if ( $developers && ! is_wp_error( $developers ) ) {
                                        // Use the first developer term if multiple are returned.
                                        $developer = reset( $developers );
                                        // Retrieve the thumbnail ID from term meta.
                                        $developer_thumbnail_id = absint( get_term_meta( $developer->term_id, 'thumbnail_id', true ) );
                                        // If a valid thumbnail ID exists, get its URL.
                                        if ( $developer_thumbnail_id ) {
                                            $developer_image_url = wp_get_attachment_url( $developer_thumbnail_id );
                                        }
                                    }
                                    ?>
                                    <div class="top-card-properties">
                                        <img data-src="<?php echo esc_url( $developer_image_url ); ?>" alt="<?php echo isset( $developer ) ? esc_attr( $developer->name ) : 'Default Image'; ?>" class="lazyload">
                                    </div>


                                    <li>
                                        <div class="swiper swiper1-in swiper-in">
                                            <div class="swiper-wrapper">
                                                <?php
                                                $attachments = get_attached_media('image', $post_id);
                                                $gallery_images = [];

                                                if (!empty($attachments)) {
                                                    foreach ($attachments as $attachment) {
                                                        $gallery_images[] = wp_get_attachment_url($attachment->ID);
                                                    }
                                                }
                                                if ( ! empty( $gallery_images ) ) : ?>
                                                    <?php foreach ( $gallery_images as $image_url ) : ?>
                                                        <div class="swiper-slide">
                                                            <img data-src="<?php echo esc_url( $image_url ); ?>" class="swiper-in-img lazyload" alt="<?php the_title(); ?>">
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <div class="swiper-slide">
                                                        <img data-src="<?php echo esc_url( $theme_dir ); ?>/assets/imgs/properties.jpg" class="swiper-in-img lazyload" alt="<?php esc_attr_e( 'Default Image', 'cob_theme' ); ?>">
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="swiper-pagination"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="bottom-properties-swiper">
                                            <ul>
                                                <li>
                                                    <div class="prices">
                                                        <p>
                                                            <span style="font-weight:bold"><?php echo esc_html( $final_price ); ?> <?php echo esc_html__( 'EGP', 'cob_theme' ); ?></span>
                                                        </p>
                                                        <span>
															<?php echo esc_html__( 'Down Payment:', 'cob_theme' ); ?>
                                                            <?php echo esc_html( get_post_meta( $post_id, 'propertie_down_payment', true ) ); ?> /
															<?php echo esc_html( $installments ); ?> <?php echo esc_html__( 'Years', 'cob_theme' ); ?>
														</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <h6><?php echo esc_html( $propertie_type ); ?></h6>
                                                    <div class="info">
                                                <span><svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <mask id="mask0_601_5318" style="mask-type:alpha" maskProperties="userSpaceOnUse" x="0" y="0" width="21" height="20">
                                                            <rect x="0.5" width="20" height="20" fill="#D9D9D9"></rect>
                                                        </mask>
                                                        <g mask="url(#mask0_601_5318)">
                                                            <path d="M1.5 17H3.3M3.3 17H10.5M3.3 17V5.00019C3.3 3.95008 3.3 3.42464 3.49619 3.02356C3.66876 2.67075 3.94392 2.38412 4.28262 2.20437C4.66766 2 5.17208 2 6.18018 2H7.62018C8.62827 2 9.13209 2 9.51711 2.20437C9.85578 2.38412 10.1314 2.67075 10.304 3.02356C10.5 3.42425 10.5 3.94905 10.5 4.9971V7.85572M10.5 17H17.7M10.5 17V7.85572M10.5 7.85572L10.8253 7.5513C11.5056 6.9147 11.8458 6.59631 12.2303 6.47556C12.5691 6.36917 12.9306 6.36917 13.2694 6.47556C13.654 6.59633 13.9944 6.91456 14.6748 7.5513L16.7448 9.48847C17.0965 9.81763 17.272 9.98244 17.3982 10.1799C17.51 10.3548 17.5931 10.5479 17.6433 10.7516C17.7 10.9812 17.7 11.2278 17.7 11.7202V17M17.7 17H19.5" stroke="#707070" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </g>
                                                    </svg>
                                                    اسم الكمبوند</span>
                                                        <div class="left-icons">
                                                            <?php

                                                            $title = get_the_title($post_id);
                                                            $permalink = get_permalink($post_id);
                                                            $encoded_title = urlencode($title);
                                                            $encoded_permalink = urlencode($permalink);
                                                            $encoded_whatsapp_number = '201000843339';
                                                            $encoded_phone_number = '+201000843339';
                                                            ?>
                                                            <div>
                                                                <svg width="25" height="26" viewBox="0 0 25 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M12.5 24.3095C18.746 24.3095 23.8095 19.246 23.8095 13C23.8095 6.75387 18.746 1.69043 12.5 1.69043C6.25387 1.69043 1.19043 6.75387 1.19043 13C1.19043 14.5594 1.50604 16.0452 2.07689 17.3968C2.39238 18.1436 2.55013 18.5172 2.56966 18.7995C2.58919 19.0818 2.50611 19.3922 2.33995 20.0132L1.19043 24.3095L5.48666 23.16C6.10767 22.9938 6.41819 22.9107 6.70045 22.9303C6.98273 22.9497 7.35621 23.1075 8.10321 23.423C9.45481 23.9938 10.9405 24.3095 12.5 24.3095Z" fill="#00DE3E" stroke="white" stroke-width="1.69643" stroke-linejoin="round"></path>
                                                                    <path d="M8.64182 13.4262L9.62682 12.2028C10.042 11.6872 10.5551 11.2073 10.5954 10.5207C10.6054 10.3473 10.4835 9.56882 10.2395 8.01183C10.1436 7.39993 9.57227 7.34473 9.07743 7.34473C8.43259 7.34473 8.11016 7.34473 7.78999 7.49097C7.38533 7.67581 6.96987 8.19555 6.87869 8.63099C6.80656 8.97551 6.86017 9.21291 6.96738 9.68771C7.42275 11.7043 8.49102 13.6959 10.1475 15.3524C11.804 17.0089 13.7956 18.0772 15.8122 18.5326C16.287 18.6398 16.5244 18.6934 16.869 18.6212C17.3044 18.5301 17.8241 18.1147 18.009 17.7099C18.1552 17.3897 18.1552 17.0674 18.1552 16.4225C18.1552 15.9276 18.1 15.3564 17.4881 15.2605C15.9311 15.0164 15.1527 14.8945 14.9792 14.9046C14.2927 14.9448 13.8127 15.458 13.2971 15.8731L12.0738 16.8581" stroke="white" stroke-width="1.69643"></path>
                                                                </svg>

                                                            </div>
                                                            <div><svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M8.28696 4.88869L7.83157 3.86407C7.53382 3.19413 7.38494 2.85914 7.16229 2.60279C6.88325 2.28152 6.51952 2.04515 6.11261 1.92064C5.78793 1.82129 5.42135 1.82129 4.68821 1.82129C3.61573 1.82129 3.07949 1.82129 2.62934 2.02745C2.09908 2.2703 1.6202 2.79762 1.4294 3.34875C1.26742 3.81662 1.31383 4.29743 1.40661 5.25904C2.3943 15.4947 8.00599 21.1064 18.2416 22.0941C19.2033 22.1869 19.6841 22.2333 20.1519 22.0713C20.7031 21.8805 21.2304 21.4016 21.4733 20.8714C21.6794 20.4212 21.6794 19.885 21.6794 18.8125C21.6794 18.0793 21.6794 17.7128 21.5801 17.3881C21.4555 16.9811 21.2192 16.6174 20.8979 16.3384C20.6416 16.1157 20.3066 15.9669 19.6366 15.6691L18.612 15.2137C17.8865 14.8913 17.5237 14.7301 17.1551 14.695C16.8022 14.6614 16.4466 14.711 16.1163 14.8396C15.7713 14.9739 15.4664 15.2281 14.8563 15.7363C14.2492 16.2423 13.9457 16.4953 13.5747 16.6308C13.2458 16.7509 12.8111 16.7954 12.4648 16.7443C12.0741 16.6868 11.7749 16.5269 11.1765 16.2071C9.315 15.2123 8.2884 14.1858 7.29354 12.3241C6.97379 11.7258 6.81392 11.4266 6.75634 11.0359C6.7053 10.6895 6.74979 10.2548 6.86992 9.92603C7.00543 9.55506 7.25842 9.25149 7.76438 8.64432C8.27267 8.03438 8.52681 7.72941 8.66118 7.38434C8.78977 7.05414 8.83927 6.69841 8.80572 6.34564C8.77065 5.977 8.60942 5.61423 8.28696 4.88869Z" stroke="#EC3C43" stroke-width="1.69643" stroke-linecap="round"></path>
                                                                </svg>

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <span><svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12.5837 7.50033C12.5837 8.65091 11.6509 9.58366 10.5003 9.58366C9.34974 9.58366 8.41699 8.65091 8.41699 7.50033C8.41699 6.34973 9.34974 5.41699 10.5003 5.41699C11.6509 5.41699 12.5837 6.34973 12.5837 7.50033Z" stroke="#EC3C43" stroke-width="1.25"></path>
                                                    <path d="M11.5482 14.5783C11.2671 14.849 10.8914 15.0003 10.5005 15.0003C10.1095 15.0003 9.73383 14.849 9.45274 14.5783C6.87891 12.0843 3.42965 9.29824 5.11175 5.25343C6.02124 3.06643 8.20444 1.66699 10.5005 1.66699C12.7965 1.66699 14.9797 3.06643 15.8892 5.25343C17.5692 9.29316 14.1283 12.0929 11.5482 14.5783Z" stroke="#EC3C43" stroke-width="1.25"></path>
                                                    <path d="M15.5 16.667C15.5 17.5875 13.2614 18.3337 10.5 18.3337C7.73857 18.3337 5.5 17.5875 5.5 16.667" stroke="#EC3C43" stroke-width="1.25" stroke-linecap="round"></path>
                                                </svg>
                                                <?php echo esc_html( $city_name ); ?></span>
                                                </li>
                                                <li>
                                                    <?php get_template_part('template-parts/single/bottom-icons'); ?>
                                                </li>

                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </a>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <p><?php echo esc_html__( 'No properties available at the moment.', 'cob_theme' ); ?></p>
                <?php endif; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
