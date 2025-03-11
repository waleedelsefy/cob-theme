<?php
/**
 * Template Name: Landing & Search Template
 *
 * @package cob_theme
 */


$theme_dir = get_template_directory_uri();

$args = array(
    'post_type'      => 'slider',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC'
);
$slider_query = new WP_Query( $args );
?>

<div class="landing">
    <div class="container">
        <div class="img-holder">
            <div class="swiper landing-swiper">
                <div class="swiper-wrapper">
                    <?php if ( $slider_query->have_posts() ) : ?>
                        <?php while ( $slider_query->have_posts() ) : $slider_query->the_post(); ?>
                            <?php
                            $slider_img = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                            ?>
                            <div class="swiper-slide">
                                <img data-src="<?php echo esc_url( $slider_img ? $slider_img : $theme_dir . '/assets/imgs/landing.jpg' ); ?>" alt="<?php the_title_attribute(); ?>" class="lazyload">
                            </div>
                        <?php endwhile; wp_reset_postdata(); ?>
                    <?php else : ?>
                        <div class="swiper-slide">
                            <img data-src="<?php echo esc_url( $theme_dir . '/assets/imgs/landing.jpg' ); ?>" alt="<?php esc_attr_e( 'Default Slide', 'cob_theme' ); ?>" class="lazyload">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="swiper-button-prev">
                    <svg width="20" height="12" viewBox="0 0 20 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.66602 6.00033H18.3327M1.66602 6.00033C1.66602 4.54158 5.82081 1.81601 6.87435 0.791992M1.66602 6.00033C1.66602 7.45908 5.82081 10.1847 6.87435 11.2087" stroke="white" stroke-width="1.5625" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="swiper-button-next">
                    <svg width="20" height="12" viewBox="0 0 20 12" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.334 5.99967L1.66732 5.99967M18.334 5.99967C18.334 7.45842 14.1792 10.184 13.1257 11.208M18.334 5.99967C18.334 4.54092 14.1792 1.8153 13.1257 0.791341" stroke="#fff" stroke-width="1.5625" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="swiper-pagination"></div>
            </div>

            <div class="search-bar">
                <h3 id="SearchTitle2" class="head"><?php esc_html_e( 'Find your property', 'cob_theme' ); ?></h3>

                <!-- Basic Search Form -->
                <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <div class="search-bar-content">
                        <div class="search-form">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M7.66634 2.08301C4.58275 2.08301 2.08301 4.58275 2.08301 7.66634C2.08301 10.7499 4.58275 13.2497 7.66634 13.2497C10.7499 13.2497 13.2497 10.7499 13.2497 7.66634C13.2497 4.58275 10.7499 2.08301 7.66634 2.08301ZM0.583008 7.66634C0.583008 3.75432 3.75432 0.583008 7.66634 0.583008C11.5784 0.583008 14.7497 3.75432 14.7497 7.66634C14.7497 11.5784 11.5784 14.7497 7.66634 14.7497C3.75432 14.7497 0.583008 11.5784 0.583008 7.66634Z"
                                      fill="#081945" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M12.8027 12.8027C13.0956 12.5098 13.5704 12.5098 13.8633 12.8027L15.1967 14.136C15.4896 14.4289 15.4896 14.9038 15.1967 15.1967C14.9038 15.4896 14.4289 15.4896 14.136 15.1967L12.8027 13.8633C12.5098 13.5704 12.5098 13.0956 12.8027 12.8027Z"
                                      fill="#081945" />
                            </svg>
                            <input type="text" id="basicSearchInput" name="s" placeholder="<?php esc_attr_e( 'Search by compound, location, real estate', 'cob_theme' ); ?>" value="<?php echo isset($_GET['s']) ? esc_attr($_GET['s']) : get_search_query(); ?>" />
                        </div>
                        <ul class="nav-menu2">
                            <li>
                                <?php
                                $propertie_types = get_terms( array(
                                    'taxonomy'   => 'type',
                                    'hide_empty' => false,
                                ) );
                                ?>
                                <select name="basic_propertie_type">
                                    <option value=""><?php esc_html_e( 'Select Property Type', 'cob_theme' ); ?></option>
                                    <?php if ( ! empty( $propertie_types ) && ! is_wp_error( $propertie_types ) ) : ?>
                                        <?php foreach ( $propertie_types as $term ) : ?>
                                            <option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( isset($_GET['basic_propertie_type']) ? $_GET['basic_propertie_type'] : '', $term->slug ); ?>>
                                                <?php echo esc_html( $term->name ); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </li>
                            <li>
                                <select name="bedrooms">
                                    <option value=""><?php esc_html_e( 'Bedrooms', 'cob_theme' ); ?></option>
                                    <option value="1" <?php selected( isset($_GET['bedrooms']) ? $_GET['bedrooms'] : '', '1' ); ?>>1</option>
                                    <option value="2" <?php selected( isset($_GET['bedrooms']) ? $_GET['bedrooms'] : '', '2' ); ?>>2</option>
                                </select>
                            </li>
                            <li>
                                <select name="price">
                                    <option value=""><?php esc_html_e( 'Price', 'cob_theme' ); ?></option>
                                    <option value="1000000" <?php selected( isset($_GET['price']) ? $_GET['price'] : '', '1000000' ); ?>>1,000,000</option>
                                    <option value="1500000" <?php selected( isset($_GET['price']) ? $_GET['price'] : '', '1500000' ); ?>>1,500,000</option>
                                    <option value="2000000" <?php selected( isset($_GET['price']) ? $_GET['price'] : '', '2000000' ); ?>>2,000,000</option>
                                    <option value="2500000" <?php selected( isset($_GET['price']) ? $_GET['price'] : '', '2500000' ); ?>>2,500,000</option>
                                    <option value="3000000" <?php selected( isset($_GET['price']) ? $_GET['price'] : '', '3000000' ); ?>>3,000,000</option>
                                </select>
                            </li>
                            <li>
                                <button type="submit"><?php esc_html_e( 'Search', 'cob_theme' ); ?></button>
                            </li>
                        </ul>
                    </div>
                </form>

                <!-- Detailed Search Form -->
                <div class="search-container">
                    <h2 style="display: none;" id="searchTitle"><?php esc_html_e( 'Detailed search', 'cob_theme' ); ?></h2>
                    <svg class="search-icon" id="searchIcon" width="16" height="16" viewBox="0 0 16 16" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M7.66634 2.08301C4.58275 2.08301 2.08301 4.58275 2.08301 7.66634C2.08301 10.7499 4.58275 13.2497 7.66634 13.2497C10.7499 13.2497 13.2497 10.7499 13.2497 7.66634C13.2497 4.58275 10.7499 2.08301 7.66634 2.08301ZM0.583008 7.66634C0.583008 3.75432 3.75432 0.583008 7.66634 0.583008C11.5784 0.583008 14.7497 3.75432 14.7497 7.66634C14.7497 11.5784 11.5784 14.7497 7.66634 14.7497C3.75432 14.7497 0.583008 11.5784 0.583008 7.66634Z"
                              fill="#081945" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M12.8027 12.8027C13.0956 12.5098 13.5704 12.5098 13.8633 12.8027L15.1967 14.136C15.4896 14.4289 15.4896 14.9038 15.1967 15.1967C14.9038 15.4896 14.4289 15.4896 14.136 15.1967L12.8027 13.8633C12.5098 13.5704 12.5098 13.0956 12.8027 12.8027Z"
                              fill="#081945" />
                    </svg>
                    <!-- حقل البحث المفصل مع ميزة الاقتراح وتعبئة القيم السابقة -->
                    <input type="text" id="searchAutocomplete" name="s" placeholder="<?php esc_attr_e( 'Search by keywords, location, real estate photos', 'cob_theme' ); ?>" value="<?php echo isset($_GET['s']) ? esc_attr($_GET['s']) : ''; ?>">
                    <button id="toggleButton" type="button">
                        <svg id="sliderIcon" width="16" height="16" viewBox="0 0 16 16" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 4.66699H4" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M2 11.333H6" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 11.333H14" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M10 4.66699H14" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                    d="M4 4.66699C4 4.04574 4 3.73511 4.10149 3.49008C4.23682 3.16338 4.49639 2.90381 4.82309 2.76849C5.06812 2.66699 5.37875 2.66699 6 2.66699C6.62125 2.66699 6.93187 2.66699 7.17693 2.76849C7.5036 2.90381 7.7632 3.16338 7.89853 3.49008C8 3.73511 8 4.04574 8 4.66699C8 5.28825 8 5.59887 7.89853 5.84391C7.7632 6.17061 7.5036 6.43017 7.17693 6.5655C6.93187 6.66699 6.62125 6.66699 6 6.66699C5.37875 6.66699 5.06812 6.66699 4.82309 6.5655C4.49639 6.43017 4.23682 6.17061 4.10149 5.84391C4 5.59887 4 5.28825 4 4.66699Z"
                                    stroke="white" />
                            <path
                                    d="M8 11.333C8 10.7117 8 10.4011 8.10147 10.1561C8.2368 9.82941 8.4964 9.56981 8.82307 9.43447C9.06813 9.33301 9.37873 9.33301 10 9.33301C10.6213 9.33301 10.9319 9.33301 11.1769 9.43447C11.5036 9.56981 11.7632 9.82941 11.8985 10.1561C12 10.4011 12 10.7117 12 11.333C12 11.9543 12 12.2649 11.8985 12.5099C11.7632 12.8366 11.5036 13.0962 11.1769 13.2315C10.9319 13.333 10.6213 13.333 10 13.333C9.37873 13.333 9.06813 13.333 8.82307 13.2315C8.4964 13.0962 8.2368 12.8366 8.10147 12.5099C8 12.2649 8 11.9543 8 11.333Z"
                                    stroke="white" />
                        </svg>
                        <svg id="closeIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="display: none;">
                            <path d="M18.3 5.7L12 12l6.3 6.3-1.4 1.4L12 13.4 5.7 19.7 4.3 18.3 10.6 12 4.3 5.7 5.7 4.3 12 10.6l6.3-6.3 1.4 1.4z" />
                        </svg>
                    </button>
                </div>

                <!-- Detailed Search Form (Hidden Content) -->
                <div class="hidden-content" id="hiddenContent" style="display: none;">
                    <form method="get" action="<?php echo esc_url( home_url( '/search-results/' ) ); ?>">
                        <?php wp_nonce_field( 'save_search', 'search_nonce' ); ?>
                        <input type="hidden" name="search_type" value="detailed">
                        <label>
                            <svg class="search-icon" width="16" height="16" viewBox="0 0 16 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M7.66634 2.08301C4.58275 2.08301 2.08301 4.58275 2.08301 7.66634C2.08301 10.7499 4.58275 13.2497 7.66634 13.2497C10.7499 13.2497 13.2497 10.7499 13.2497 7.66634C13.2497 4.58275 10.7499 2.08301 7.66634 2.08301ZM0.583008 7.66634C0.583008 3.75432 3.75432 0.583008 7.66634 0.583008C11.5784 0.583008 14.7497 3.75432 14.7497 7.66634C14.7497 11.5784 11.5784 14.7497 7.66634 14.7497C3.75432 14.7497 0.583008 11.5784 0.583008 7.66634Z"
                                      fill="#081945" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M12.8027 12.8027C13.0956 12.5098 13.5704 12.5098 13.8633 12.8027L15.1967 14.136C15.4896 14.4289 15.4896 14.9038 15.1967 15.1967C14.9038 15.4896 14.4289 15.4896 14.136 15.1967L12.8027 13.8633C12.5098 13.5704 12.5098 13.0956 12.8027 12.8027Z"
                                      fill="#081945" />
                            </svg> <?php esc_html_e( 'Search words', 'cob_theme' ); ?>
                        </label>
                        <input type="text" id="searchAutocomplete" name="s" placeholder="<?php esc_attr_e( 'Search by keywords, location, real estate photos', 'cob_theme' ); ?>" value="<?php echo isset($_GET['s']) ? esc_attr($_GET['s']) : ''; ?>">
                        <label>
                            <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M1.83301 6.66699H5.91973C6.07887 6.66699 6.23275 6.60334 6.35359 6.48752L8.06581 4.84646C8.31547 4.60717 8.68387 4.60717 8.93354 4.84646L10.6457 6.48752C10.7666 6.60334 10.9205 6.66699 11.0796 6.66699H15.1663"
                                        stroke="#081945" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                        d="M2.5 6.66667L3.80733 3.61621C4.38173 2.27598 4.80025 2 6.25839 2H10.7416C12.1997 2 12.6183 2.27598 13.1927 3.61621L14.5 6.66667"
                                        stroke="#081945" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M2.5 6.66699V14.0003" stroke="#081945" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M14.5 6.66699V14.0003" stroke="#081945" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M1.83301 14H15.1663" stroke="#081945" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M8.50502 7.33301H8.49902" stroke="#081945" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                        d="M6.83301 14V11C6.83301 10.4477 7.28074 10 7.83301 10H9.16634C9.71861 10 10.1663 10.4477 10.1663 11V14"
                                        stroke="#081945" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M4.5 9.33301H5.16667" stroke="#081945" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M11.833 9.33301H12.4997" stroke="#081945" stroke-linecap="round" stroke-linejoin="round" />
                            </svg> <?php esc_html_e('properties', 'cob_theme' ); ?>
                        </label>
                        <?php
                        $propertie_types = get_terms( array(
                            'taxonomy'   => 'type',
                            'hide_empty' => false,
                        ) );
                        ?>
                        <select name="detailed_propertie_type">
                            <option value=""><?php esc_html_e( 'Select Property Type', 'cob_theme' ); ?></option>
                            <?php if ( ! empty( $propertie_types ) && ! is_wp_error( $propertie_types ) ) : ?>
                                <?php foreach ( $propertie_types as $term ) : ?>
                                    <option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( isset($_GET['detailed_propertie_type']) ? $_GET['detailed_propertie_type'] : '', $term->slug ); ?>>
                                        <?php echo esc_html( $term->name ); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <label>
                            <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M15.1663 11.667H1.83301" stroke="#081945" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                        d="M15.1663 14V10.6667C15.1663 9.4096 15.1663 8.78107 14.7758 8.39053C14.3853 8 13.7567 8 12.4997 8H4.49967C3.24259 8 2.61405 8 2.22353 8.39053C1.83301 8.78107 1.83301 9.4096 1.83301 10.6667V14"
                                        stroke="#081945" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                        d="M7.83333 8V6.80893C7.83333 6.55515 7.7952 6.47027 7.5998 6.37025C7.193 6.16195 6.6991 6 6.16667 6C6.62125 6 6.93187 6 7.17693 6.37025C7.5036 6.55515 7.7632 6.55515 7.89853 6.80893C8 7.062 8 7.247 8 7.33301Z"
                                        stroke="#081945" stroke-linecap="round" />
                                <path
                                        d="M12.5003 8V6.80893C12.5003 6.55515 12.4622 6.47027 12.2668 6.37025C11.86 6.16195 11.3661 6 10.8337 6C10.3012 6 9.80733 6.16195 9.40053 6.37025C9.20513 6.47027 9.16699 6.55515 9.16699 6.80893V8"
                                        stroke="#081945" stroke-linecap="round" />
                                <path
                                        d="M14.5 8V4.90705C14.5 4.44595 14.5 4.21541 14.3719 3.99769C14.2438 3.77997 14.0613 3.66727 13.6963 3.44189C12.2246 2.53319 10.4329 2 8.5 2C6.56711 2 4.77543 2.53319 3.30372 3.44189C2.93869 3.66727 2.75618 3.77997 2.62809 3.99769C2.5 4.21541 2.5 4.44595 2.5 4.90705V8"
                                        stroke="#081945" stroke-linecap="round" />
                            </svg>
                            <?php esc_html_e( 'Bedrooms', 'cob_theme' ); ?>
                        </label>
                        <select name="detailed_bedrooms">
                            <option value=""><?php esc_html_e( 'Bedrooms', 'cob_theme' ); ?></option>
                            <option value="1" <?php selected( isset($_GET['detailed_bedrooms']) ? $_GET['detailed_bedrooms'] : '', '1' ); ?>>1</option>
                            <option value="2" <?php selected( isset($_GET['detailed_bedrooms']) ? $_GET['detailed_bedrooms'] : '', '2' ); ?>>2</option>
                            <option value="3" <?php selected( isset($_GET['detailed_bedrooms']) ? $_GET['detailed_bedrooms'] : '', '3' ); ?>>3</option>
                            <option value="4" <?php selected( isset($_GET['detailed_bedrooms']) ? $_GET['detailed_bedrooms'] : '', '4' ); ?>>4</option>
                            <option value="5" <?php selected( isset($_GET['detailed_bedrooms']) ? $_GET['detailed_bedrooms'] : '', '5' ); ?>>5</option>
                            <option value="6" <?php selected( isset($_GET['detailed_bedrooms']) ? $_GET['detailed_bedrooms'] : '', '6' ); ?>>6</option>
                        </select>
                        <label>
                            <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M5.15723 2.46679C7.02191 4.52983 10.0971 0.0772571 11.9167 1.69315C12.9637 2.62291 12.6327 4.67581 11.2735 6.01331"
                                        stroke="#081945" stroke-linecap="round" />
                                <path
                                        d="M12.6821 4.42231C13.2991 4.54081 13.4375 4.93044 13.6217 6.01163C13.7876 6.98534 13.8341 8.15387 13.8341 8.65127C13.8172 8.83461 13.742 9.00567 13.6217 9.14521C12.3316 10.4973 9.77126 13.0505 8.47906 14.3188C7.97192 14.7715 7.20679 14.7813 6.6686 14.3657C5.56651 13.3744 4.50762 12.2538 3.47033 11.2419C3.05361 10.7052 3.06338 9.94221 3.51744 9.43654C4.88446 8.01841 7.35812 5.59095 8.75452 4.24994C8.89452 4.12997 9.06606 4.05493 9.24986 4.03809C9.56319 4.03801 10.1007 4.08012 10.6243 4.11047"
                                        stroke="#081945" stroke-linecap="round" />
                            </svg>
                            <?php esc_html_e( 'Price (EGP)', 'cob_theme' ); ?>
                        </label>
                        <div class="prices">
                            <input type="number" name="price_from" placeholder="<?php esc_attr_e( 'From', 'cob_theme' ); ?>" value="<?php echo isset($_GET['price_from']) ? esc_attr($_GET['price_from']) : ''; ?>">
                            <input type="number" name="price_to" placeholder="<?php esc_attr_e( 'To', 'cob_theme' ); ?>" value="<?php echo isset($_GET['price_to']) ? esc_attr($_GET['price_to']) : ''; ?>">
                        </div>
                        <div class="buttons">
                            <button type="submit" class="firstbtn">
                                <?php
                                $count_posts   = wp_count_posts( 'post' );
                                $published     = isset( $count_posts->publish ) ? $count_posts->publish : 0;
                                printf( esc_html__( 'Search (%s results)', 'cob_theme' ), $published );
                                ?>
                            </button>
                            <button type="reset" class="secbtn"><?php esc_html_e( 'Clear all', 'cob_theme' ); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        $("#searchAutocomplete").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    dataType: "json",
                    data: {
                        action: "ase_search_suggestions_from_views",
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 2
        });
    });


</script>

