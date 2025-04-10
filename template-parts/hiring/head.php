<?php
$theme_dir = get_template_directory_uri();
?>
<div class="head-we">
    <div class="container">
        <div class="breadcrumb">
            <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
        </div>
    </div>
    <div class="areas-landing w-full">
        <img data-src="<?php
        $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
        if (!empty($large_image_url)) {
            echo esc_url($large_image_url[0]);
        }
        else {
            echo $theme_dir .'/assets/imgs/hiring.png';
        }

        ?>"
        <img data-src="<?php  ?>" class="img1 lazyload" alt="img1">
        <img data-src="<?php echo $theme_dir ?>/assets/imgs/logo-white.png" class="img2 lazyload" alt="img2">
    </div>
</div>
