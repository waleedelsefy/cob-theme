<?php
/**
 * Capital of Business Theme Functions
 *
 * @package Capital_of_Business
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue Styles and Scripts
 */
function cob_enqueue_assets() {
    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();

    // Normalize CSS
    wp_enqueue_style('normalize', $theme_uri . '/assets/css/normalize.css', [], '8.0.1');
    wp_enqueue_style('footer', $theme_uri . '/assets/css/footer.css', [], '8.0.1');
    wp_enqueue_style('header', $theme_uri . '/assets/css/header.css', [], '8.0.1');
    wp_enqueue_style('ltr', $theme_uri . '/assets/css/ltr.css', [], '8.0.1');

    // Bootstrap (From Theme)
    wp_enqueue_style('bootstrap', $theme_uri . '/assets/bootstrap4/css/bootstrap.min.css', [], '4.6.0');

    // Swiper Slider (CDN)
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11.0.0');

    // FontAwesome (From Theme)
    wp_enqueue_style('font-awesome', $theme_uri . '/assets/css/fonts/fontawesome/css/all.css', [], '6.4.2');

    // Enqueue Custom Theme Styles
    $css_files = [
        'animate'       => 'assets/css/animate.css',
        'contact'       => 'assets/css/contact.css',
        'areas'         => 'assets/css/areas.css',
        'developers'    => 'assets/css/motawren-det.css',
        'article-name'  => 'assets/css/article-name.css',
        'articles'      => 'assets/css/articels.css',
        'factorys'      => 'assets/css/factorys.css',
        'developer'     => 'assets/css/motawren.css',
        'projects'      => 'assets/css/projects.css',
        'services'      => 'assets/css/services.css',
        'factory-det'   => 'assets/css/factory-det.css',
        'flat-det'      => 'assets/css/flat-det.css',
        'hiring'        => 'assets/css/hiring.css',
        'we'            => 'assets/css/we.css',
        'city'          => 'assets/css/city.css',
        'home'          => 'assets/css/home.css',
    ];

    foreach ($css_files as $key => $path) {
        $file_path = $theme_dir . '/' . $path;
        if (file_exists($file_path)) {
            wp_enqueue_style("cob-{$key}", $theme_uri . '/' . $path, [], filemtime($file_path));
        }
    }

    // Main WordPress Stylesheet
    $style_path = $theme_dir . '/style.css';
    if (file_exists($style_path)) {
        wp_enqueue_style('cob-style', get_stylesheet_uri(), [], filemtime($style_path));
    }

    // Enqueue Scripts
    wp_enqueue_script('jquery');

    // Bootstrap Bundle (Includes Popper.js)
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', ['jquery'], '5.3.2', true);

    // Swiper JS (CDN)
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '11.0.0', true);

    // Lazy Load
    wp_enqueue_script('lazyload', 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js', [], '5.3.2', true);

    // Floating UI (If exists)
    $floating_ui_path = $theme_dir . '/assets/js/floating-ui.dom.umd.js';
    if (file_exists($floating_ui_path)) {
        wp_enqueue_script('floating-ui', $theme_uri . '/assets/js/floating-ui.dom.umd.js', ['jquery'], '1.0.0', true);
    }

    // Main Theme JS (If exists)
    $main_js_path = $theme_dir . '/assets/js/main.js';
    if (file_exists($main_js_path)) {
        wp_enqueue_script('main-js', $theme_uri . '/assets/js/main.js', ['jquery', 'bootstrap-js'], filemtime($main_js_path), true);
    }

    // FontAwesome (Theme)
    wp_enqueue_script('fontawesome', $theme_uri . '/assets/css/fonts/fontawesome/js/all.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'cob_enqueue_assets');

/**
 * Remove Unwanted WordPress Default Styles
 */

/**
 * Remove Redux Framework Styles
 */
function cob_remove_redux_styles() {
    wp_dequeue_style('redux-admin-css'); // Main Redux styles
    wp_dequeue_style('redux-extension-css'); // Extension styles
}
add_action('wp_enqueue_scripts', 'cob_remove_redux_styles', 100);

function cob_enqueue_google_fonts() {
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&family=Cairo:wght@200..1000&display=swap',
        [],
        null
    );
}
add_action('wp_enqueue_scripts', 'cob_enqueue_google_fonts');

function enqueue_job_application_script() {
    if ( is_page_template( 'page-templates/hiring-page.php' ) ) {
        wp_enqueue_script( 'job-application', get_template_directory_uri() . '/assets/js/job-application.js', array('jquery'), '1.0', true );
        wp_localize_script( 'job-application', 'myAjax', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        ) );
        wp_enqueue_script( 'projects', get_template_directory_uri() . '/assets/js/projects.js', array('jquery'), '1.0', true );

    }
}
add_action( 'wp_enqueue_scripts', 'enqueue_job_application_script' );
