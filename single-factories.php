<?php
/*
Template Name: Single Project
Template Post Type: projects
*/

$post_id = get_the_ID();
get_header();


get_the_title();
$theme_dir = get_template_directory_uri();

?>
<div class="head-services head-flat">
    <div class="container">
        <div class="breadcrumb">
            <?php if ( function_exists( 'rank_math_the_breadcrumbs' ) ) : rank_math_the_breadcrumbs(); endif; ?>
        </div>
    </div>
</div>
<?php
get_template_part( 'template-parts/factories-post/main-flat.php' );
get_template_part( 'template-parts/factories-post/landing-flat.php' );

get_template_part( 'template-parts/factories-post/factories-related.php' );
get_template_part( 'template-parts/contact-section.php' );
?>
<script src="<?php echo $theme_dir ?>/assets/js/single-properties.js"></script>

<?php
get_footer();
?>
