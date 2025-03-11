<?php
/**
 * Template Name: Latest Projects
 * Description: A custom page template to display the latest projects with pagination.
 */

$theme_dir = get_template_directory_uri();
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$projects_query = new WP_Query( array(
    'post_type'      => 'factory',
    'posts_per_page' => 3,
    'paged'          => $paged,
) );
?>
<section class="pagination-section">
    <div class="container">
        <div class=" factorys-cards">
            <?php if ( $projects_query->have_posts() ) : ?>
                <?php while ( $projects_query->have_posts() ) : $projects_query->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="factorys-card">
                        <ul class="big-ul">
                            <li>
                                <div class="swiper swiper7-in swiper-in">
                                    <div class="swiper-wrapper">
                                        <?php
                                        $post_id = get_the_ID();
                                        // استرجاع البيانات الخاصة بالعقار
                                        $price        = get_post_meta( 'price', $post_id );
                                        $down_payment = get_post_meta( 'down_payment', $post_id );
                                        $location     = get_post_city( $post_id );
                                        $area         = get_post_meta( 'area', $post_id )?: '---';

                                        // جلب معرّفات الصور من المعرض
                                        $gallery_ids = get_post_meta( $post_id, '_gallery_image_ids', true );
                                        $gallery_images = array();

                                        if ( ! empty( $gallery_ids ) && is_array( $gallery_ids ) ) {
                                            foreach ( $gallery_ids as $attachment_id ) {
                                                $image_url = wp_get_attachment_image_url( $attachment_id, 'large' );
                                                if ( $image_url ) {
                                                    $gallery_images[] = $image_url;
                                                }
                                            }
                                        }
                                        ?>
                                        <?php if ( ! empty( $gallery_images ) ) : ?>
                                            <?php foreach ( $gallery_images as $image_url ) : ?>
                                                <div class="swiper-slide">
                                                    <img data-src="<?php echo esc_url( $image_url ); ?>" class="swiper-in-img lazyload" alt="<?php echo esc_attr( get_the_title() ); ?>">
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <div class="swiper-slide">
                                                <?php $thumbnail = get_the_post_thumbnail_url( $post_id, 'large' ); ?>
                                                <?php if ( $thumbnail ) : ?>
                                                    <img data-src="<?php echo esc_url( $thumbnail ); ?>" class="swiper-in-img lazyload" alt="<?php echo esc_attr( get_the_title() ); ?>">
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </li>
                            <li>
                                <div class="bottom-factorys-swiper">
                                    <ul>
                                        <li>
                                            <div class="prices">
                                                <p>
                                                    <span style="font-weight:bold"><?php echo esc_html( $price ); ?> EGP</span> <?php esc_html_e( 'Price', 'cob_theme' ); ?>
                                                </p>
                                                <span><?php esc_html_e( 'Down Payment', 'cob_theme' ); ?>: <?php echo esc_html( $down_payment ); ?></span>
                                            </div>
                                        </li>
                                        <li>
                                            <h6><?php the_title(); ?></h6>
                                            <span>
                                                <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12.5837 7.50033C12.5837 8.65091 11.6509 9.58366 10.5003 9.58366C9.34974 9.58366 8.41699 8.65091 8.41699 7.50033C8.41699 6.34973 9.34974 5.41699 10.5003 5.41699C11.6509 5.41699 12.5837 6.34973 12.5837 7.50033Z" stroke="#707070" stroke-width="1.25"/>
                                                    <path d="M11.5482 14.5783C6.87891 12.0843 3.42965 9.29824 5.11175 5.25343C6.02124 3.06643 8.20444 1.66699 10.5005 1.66699C12.7965 1.66699 14.9797 3.06643 15.8892 5.25343C17.5692 9.29316 14.1283 12.0929 11.5482 14.5783Z" stroke="#707070" stroke-width="1.25"/>
                                                </svg>
                                                <?php echo esc_html( $location ); ?>
                                            </span>
                                        </li>
                                        <li>
                                            <?php get_template_part('template-parts/single/bottom-icons'); ?>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
                <p><?php esc_html_e( 'No projects found.', 'cob_theme' ); ?></p>
            <?php endif; ?>
        </div>

        <!-- Pagination Buttons -->
        <div class="pagination">
            <?php
            $big = 999999999; // an unlikely integer
            $pagination_links = paginate_links( array(
                'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'    => '?paged=%#%',
                'current'   => $paged,
                'total'     => $projects_query->max_num_pages,
                'prev_text' => '<svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.10212 6.99773L0.997038 1.89666C0.619477 1.5191 0.619477 0.908582 0.997038 0.53504C1.3746 0.161498 1.98512 0.161497 2.36268 0.53504L8.14656 6.31491C8.51208 6.68042 8.52011 7.26684 8.17468 7.6444L2.36669 13.4644C2.17791 13.6532 1.92888 13.7456 1.68387 13.7456C1.43886 13.7456 1.18983 13.6532 1.00105 13.4644C0.623496 13.0869 0.623496 12.4764 1.00105 12.1028L6.10212 6.99773Z" fill="black" />
                                </svg> ' . esc_html__( 'Previous', 'cob_theme' ),
                'next_text' => esc_html__( 'Next', 'cob_theme' ) . ' <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.32561 7.00227L7.4307 12.1033C7.80826 12.4809 7.80826 13.0914 7.4307 13.465C7.05314 13.8385 6.44262 13.8385 6.06506 13.465L0.281172 7.68509C-0.084341 7.31958 -0.0923709 6.73316 0.253054 6.3556L6.06104 0.535562C6.24982 0.346784 6.49885 0.254402 6.74386 0.254402C6.98887 0.254402 7.2379 0.346785 7.42668 0.535562C7.80424 0.913122 7.80424 1.52364 7.42668 1.89719L2.32561 7.00227Z" fill="black" />
                                </svg>',
                'type'      => 'list',
                'end_size'  => 1,
                'mid_size'  => 2,
            ) );
            if ( $pagination_links ) {
                echo $pagination_links;
            }
            ?>
        </div>
    </div>
</section>

