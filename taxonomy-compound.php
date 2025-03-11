<?php
/**
 * Main taxonomy-compound.php
 *
 * @package Capital_of_Business
 */

get_header(); ?>

<?php
$current_term = get_queried_object();

$theme_dir = get_template_directory_uri();
get_template_part('template-parts/taxonomy-compound/head');
get_template_part('template-parts/taxonomy-compound/featured');
//get_template_part('template-parts/taxonomy-compound/top-trend');
get_template_part('template-parts/contact-section');


get_template_part('template-parts/taxonomy-compound/sup-taxonomy');

?>
<script src="<?php echo $theme_dir ?>/assets/js/city.js"></script>
<?php get_footer(); ?>
