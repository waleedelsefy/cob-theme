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
$transient_key = 'latest_properties';
$properties_query = get_transient( $transient_key );

if ( false === $properties_query ) {
	$args = [
		'post_type'      => 'properties',
		'posts_per_page' => 6,
		'paged'          => ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'tax_query'      => array(
			array(
				'taxonomy' => get_queried_object()->taxonomy,
				'field'    => 'slug',
				'terms'    => get_queried_object()->slug,
			),
		),
	];
	$properties_query = new WP_Query( $args );
	set_transient( $transient_key, $properties_query, HOUR_IN_SECONDS );
}

$unit_id = get_the_ID();
$project_id = (int) get_post_field( 'post_parent', $unit_id );
$project_title = get_the_title( $project_id ) ?: '--';
?>

<section class="pagination-section pagination-city ">
    <div class="container">
        <div class="top-compounds">
            <div class="right-compounds">
                <h3 class="head">
					<?php
					printf(
						esc_html__( 'The most searched compounds in %s', 'cob_theme' ),
						single_term_title( '', false )
					);
					?>
                </h3>
                <h5>
					<?php
					if ( get_queried_object() && ! is_wp_error( get_queried_object() ) ) {
						echo '<p>' . sprintf( esc_html__( '%d Results', 'cob_theme' ), $properties_query->found_posts ) . '</p>';
					}
					?>
                </h5>
            </div>
        </div>
        <!-- Cards Section -->
        <div class="properties-cards">
			<?php if ( $properties_query->have_posts() ) : ?>
			<?php while ( $properties_query->have_posts() ) : $properties_query->the_post(); ?>
			<?php
			$post_id = get_the_ID();

			// الحصول على بيانات التصنيف 'city'
			$city_name = esc_html__( 'Not known', 'cob_theme' );
			$city_link = '';
			$city_terms = get_the_terms( $post_id, 'city' );
			if ( $city_terms && ! is_wp_error( $city_terms ) ) {
				$city_name = esc_html( $city_terms[0]->name );
				$city_link = get_term_link( $city_terms[0] );
			}

			// جلب بيانات تفاصيل المنشور من post meta باستخدام المفاتيح المُحدثة
			$area          = ! empty( get_post_meta( $post_id, 'cob_area', true ) ) ? intval( get_post_meta( $post_id, 'cob_area', true ) ) : '-';
			$price         = ! empty( get_post_meta( $post_id, 'cob_price', true ) ) ? floatval( get_post_meta( $post_id, 'cob_price', true ) ) : '-';
			$max_price     = ! empty( get_post_meta( $post_id, 'cob_max_price', true ) ) ? floatval( get_post_meta( $post_id, 'cob_max_price', true ) ) : '-';
			$min_price     = ! empty( get_post_meta( $post_id, 'cob_min_price', true ) ) ? floatval( get_post_meta( $post_id, 'cob_min_price', true ) ) : '-';
			$rooms         = ! empty( get_post_meta( $post_id, 'cob_rooms', true ) ) ? intval( get_post_meta( $post_id, 'cob_rooms', true ) ) : '-';
			$bathrooms     = ! empty( get_post_meta( $post_id, 'cob_bathrooms', true ) ) ? intval( get_post_meta( $post_id, 'cob_bathrooms', true ) ) : '-';
			$reference_number = ! empty( get_post_meta( $post_id, 'cob_reference_number', true ) ) ? get_post_meta( $post_id, 'cob_reference_number', true ) : '-';
			$delivery_year    = ! empty( get_post_meta( $post_id, 'cob_delivery_year', true ) ) ? get_post_meta( $post_id, 'cob_delivery_year', true ) : '-';

			$installments      = get_post_meta( $post_id, 'cob_unit_installments', true );
			$unit_down_payment = get_post_meta( $post_id, 'cob_unit_down_payment', true );
			$unit_type         = get_post_meta( $post_id, 'cob_unit_type', true );
			$main_location     = get_post_meta( $post_id, 'cob_main_location', true );

			// جلب الصور من معرض المنشور
			$gallery_ids    = get_post_meta( $post_id, '_gallery_image_ids', true );
			$gallery_images = [];
			if ( ! empty( $gallery_ids ) && is_array( $gallery_ids ) ) {
				foreach ( $gallery_ids as $attachment_id ) {
					$image_url = wp_get_attachment_image_url( $attachment_id, 'large' );
					if ( $image_url ) {
						$gallery_images[] = $image_url;
					}
				}
			}

			// تحديد السعر النهائي
			if ( ! empty( $price ) && floatval( $price ) > 0 ) {
				$final_price = floatval( $price );
			} elseif ( ! empty( $min_price ) && floatval( $min_price ) > 0 ) {
				$final_price = floatval( $min_price );
			} elseif ( ! empty( $max_price ) && floatval( $max_price ) > 0 ) {
				$final_price = floatval( $max_price );
			} else {
				$final_price = '-';
			}

			// صورة المطور الافتراضية
			$developer_image_url = $theme_dir . '/assets/imgs/card-devloper-default.png';
			$developers = get_the_terms( $post_id, 'developer' );
			if ( $developers && ! is_wp_error( $developers ) ) {
				$developer = reset( $developers );
				$developer_thumbnail_id = absint( get_term_meta( $developer->term_id, 'thumbnail_id', true ) );
				if ( $developer_thumbnail_id ) {
					$developer_image_url = wp_get_attachment_url( $developer_thumbnail_id );
				}
			}
			?>
            <a href="<?php the_permalink(); ?>" class="properties-card">
                <ul class="big-ul">
                    <div class="top-card-properties">
                        <img data-src="<?php echo esc_url( $developer_image_url ); ?>" alt="<?php echo isset( $developer ) ? esc_attr( $developer->name ) : esc_attr__( 'Default Image', 'cob_theme' ); ?>" class="lazyload">
                    </div>
                    <li>
                        <div class="swiper swiper1-in swiper-in">
                            <div class="swiper-wrapper">
								<?php if ( ! empty( $gallery_images ) ) : ?>
									<?php foreach ( $gallery_images as $image_url ) : ?>
                                        <div class="swiper-slide">
                                            <img data-src="<?php echo esc_url( $image_url ); ?>" class="swiper-in-img lazyload" alt="<?php the_title(); ?>">
                                        </div>
									<?php endforeach; ?>
								<?php else : ?>
                                    <div class="swiper-slide">
                                        <img data-src="<?php echo esc_url( $theme_dir . '/assets/imgs/properties.jpg' ); ?>" class="swiper-in-img lazyload" alt="<?php esc_attr_e( 'Default Image', 'cob_theme' ); ?>">
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
                                                    <span style="font-weight:bold">
                                                        <?php echo esc_html( $final_price ); ?> <?php echo esc_html__( 'EGP', 'cob_theme' ); ?>
                                                    </span>
                                        </p>
                                        <span>
                                                    <?php echo esc_html__( 'Down Payment:', 'cob_theme' ); ?>
											<?php echo esc_html( $unit_down_payment ); ?> /
                                                    <?php echo esc_html( $installments ); ?> <?php echo esc_html__( 'Years', 'cob_theme' ); ?>
                                                </span>
                                    </div>
                                </li>
                                <li>
                                    <h6><?php echo esc_html( $unit_type ); ?></h6>
                                    <div class="info">
                                                <span>
                                                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <mask id="mask0_601_5318" style="mask-type:alpha" maskproperties="userSpaceOnUse" x="0" y="0" width="21" height="20">
                                                            <rect x="0.5" width="20" height="20" fill="#D9D9D9"></rect>
                                                        </mask>
                                                        <g mask="url(#mask0_601_5318)">
                                                            <path d="M1.5 17H3.3M3.3 17H10.5M3.3 17V5.00019C3.3 3.95008 3.3 3.42464 3.49619 3.02356C3.66876 2.67075 3.94392 2.38412 4.28262 2.20437C4.66766 2 5.17208 2 6.18018 2H7.62018C8.62827 2 9.13209 2 9.51711 2.20437C9.85578 2.38412 10.1314 2.67075 10.304 3.02356C10.5 3.42425 10.5 3.94905 10.5 4.9971V7.85572M10.5 17H17.7M10.5 17V7.85572M10.5 7.85572L10.8253 7.5513C11.5056 6.9147 11.8458 6.59631 12.2303 6.47556C12.5691 6.36917 12.9306 6.36917 13.2694 6.47556C13.654 6.59633 13.9944 6.91456 14.6748 7.5513L16.7448 9.48847C17.0965 9.81763 17.272 9.98244 17.3982 10.1799C17.51 10.3548 17.5931 10.5479 17.6433 10.7516C17.7 10.9812 17.7 11.2278 17.7 11.7202V17M17.7 17H19.5" stroke="#707070" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </g>
                                                    </svg>
                                                    <?php echo esc_html( $project_title ); ?>
                                                </span>
                                        <div class="left-icons">
                                            <div>
												<?php
												$title = get_the_title( $post_id );
												$permalink = get_permalink( $post_id );
												$encoded_title = urlencode( $title );
												$encoded_permalink = urlencode( $permalink );
												$encoded_whatsapp_number = '201000843339';
												$encoded_phone_number = '+201000843339';
												?>
                                                <svg width="25" height="26" viewBox="0 0 25 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12.5 24.3095C18.746 24.3095 23.8095 19.246 23.8095 13C23.8095 6.75387 18.746 1.69043 12.5 1.69043C6.25387 1.69043 1.19043 6.75387 1.19043 13C1.19043 14.5594 1.50604 16.0452 2.07689 17.3968C2.39238 18.1436 2.55013 18.5172 2.56966 18.7995C2.58919 19.0818 2.50611 19.3922 2.33995 20.0132L1.19043 24.3095L5.48666 23.16C6.10767 22.9938 6.41819 22.9107 6.70045 22.9303C6.98273 22.9497 7.35621 23.1075 8.10321 23.423C9.45481 23.9938 10.9405 24.3095 12.5 24.3095Z" fill="#00DE3E" stroke="white" stroke-width="1.69643" stroke-linejoin="round"></path>
                                                    <path d="M8.64182 13.4262L9.62682 12.2028C10.042 11.6872 10.5551 11.2073 10.5954 10.5207C10.6054 10.3473 10.4835 9.56882 10.2395 8.01183C10.1436 7.39993 9.57227 7.34473 9.07743 7.34473C8.43259 7.34473 8.11016 7.34473 7.78999 7.49097C7.38533 7.67581 6.96987 8.19555 6.87869 8.63099C6.80656 8.97551 6.86017 9.21291 6.96738 9.68771C7.42275 11.7043 8.49102 13.6959 10.1475 15.3524C11.804 17.0089 13.7956 18.0772 15.8122 18.5326C16.287 18.6398 16.5244 18.6934 16.869 18.6212C17.3044 18.5301 17.8241 18.1147 18.009 17.7099C18.1552 17.3897 18.1552 17.0674 18.1552 16.4225C18.1552 15.9276 18.1 15.3564 17.4881 15.2605C15.9311 15.0164 15.1527 14.8945 14.9792 14.9046C14.2927 14.9448 13.8127 15.458 13.2971 15.8731L12.0738 16.8581" stroke="white" stroke-width="1.69643"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8.28696 4.88869L7.83157 3.86407C7.53382 3.19413 7.38494 2.85914 7.16229 2.60279C6.88325 2.28152 6.51952 2.04515 6.11261 1.92064C5.78793 1.82129 5.42135 1.82129 4.68821 1.82129C3.61573 1.82129 3.07949 1.82129 2.62934 2.02745C2.09908 2.2703 1.6202 2.79762 1.4294 3.34875C1.26742 3.81662 1.31383 4.29743 1.40661 5.25904C2.3943 15.4947 8.00599 21.1064 18.2416 22.0941C19.2033 22.1869 19.6841 22.2333 20.1519 22.0713C20.7031 21.8805 21.2304 21.4016 21.4733 20.8714C21.6794 20.4212 21.6794 19.885 21.6794 18.8125C21.6794 18.0793 21.6794 17.7128 21.5801 17.3881C21.4555 16.9811 21.2192 16.6174 20.8979 16.3384C20.6416 16.1157 20.3066 15.9669 19.6366 15.6691L18.612 15.2137" stroke="#707070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </div>
                                        </div>
                            </ul>
                        </div>
                    </li>
                </ul>
            </a>
        </div>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
		<?php else : ?>
            <p><?php esc_html_e( 'There are no posts currently available', 'cob_theme' ); ?></p>
		<?php endif; ?>
    </div>

    <div class="pagination">
		<?php
		$big = 999999999;
		echo paginate_links( array(
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'    => '?paged=%#%',
			'current'   => ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1,
			'total'     => $properties_query->max_num_pages,
			'prev_text' => '<svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.10212 6.99773L0.997038 1.89666C0.619477 1.5191 0.619477 0.908582 0.997038 0.53504C1.3746 0.161498 1.98512 0.161497 2.36268 0.53504L8.14656 6.31491C8.51208 6.68042 8.52011 7.26684 8.17468 7.6444L2.36669 13.4644C2.17791 13.6532 1.92888 13.7456 1.68387 13.7456C1.43886 13.7456 1.18983 13.6532 1.00105 13.4644C0.623496 13.0869 0.623496 12.4764 1.00105 12.1028L6.10212 6.99773Z" fill="black" />
                                </svg> ' . esc_html__( 'Previous', 'cob_theme' ),
			'next_text' => esc_html__( 'Next', 'cob_theme' ) . ' <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.32561 7.00227L7.4307 12.1033C7.80826 12.4809 7.80826 13.0914 7.4307 13.465C7.05314 13.8385 6.44262 13.8385 6.06506 13.465L0.281172 7.68509C-0.084341 7.31958 -0.0923709 6.73316 0.253054 6.3556L6.06104 0.535562C6.24982 0.346784 6.49885 0.254402 6.74386 0.254402C6.98887 0.254402 7.2379 0.346784 7.42668 0.535562C7.80424 0.913122 7.80424 1.52364 7.42668 1.89719L2.32561 7.00227Z" fill="black" />
                                </svg>',
			'type'      => 'list',
			'end_size'  => 1,
			'mid_size'  => 2,
		) );
		?>
    </div>
    </div>
</section>
