<?php

function create_jobs_post_type() {
    $labels = array(
        'name'                  => _x( 'Jobs', 'Post Type General Name', 'cob_theme' ),
        'singular_name'         => _x( 'Job', 'Post Type Singular Name', 'cob_theme' ),
        'menu_name'             => __( 'Jobs', 'cob_theme' ),
        'name_admin_bar'        => __( 'Job', 'cob_theme' ),
        'archives'              => __( 'Job Archives', 'cob_theme' ),
        'attributes'            => __( 'Job Attributes', 'cob_theme' ),
        'parent_item_colon'     => __( 'Parent Job:', 'cob_theme' ),
        'all_items'             => __( 'All Jobs', 'cob_theme' ),
        'add_new_item'          => __( 'Add New Job', 'cob_theme' ),
        'add_new'               => __( 'Add New', 'cob_theme' ),
        'new_item'              => __( 'New Job', 'cob_theme' ),
        'edit_item'             => __( 'Edit Job', 'cob_theme' ),
        'update_item'           => __( 'Update Job', 'cob_theme' ),
        'view_item'             => __( 'View Job', 'cob_theme' ),
        'view_items'            => __( 'View Jobs', 'cob_theme' ),
        'search_items'          => __( 'Search Job', 'cob_theme' ),
        'not_found'             => __( 'Not found', 'cob_theme' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'cob_theme' ),
        'featured_image'        => __( 'Featured Image', 'cob_theme' ),
        'set_featured_image'    => __( 'Set featured image', 'cob_theme' ),
        'remove_featured_image' => __( 'Remove featured image', 'cob_theme' ),
        'use_featured_image'    => __( 'Use as featured image', 'cob_theme' ),
        'insert_into_item'      => __( 'Insert into job', 'cob_theme' ),
        'uploaded_to_this_item' => __( 'Uploaded to this job', 'cob_theme' ),
        'items_list'            => __( 'Jobs list', 'cob_theme' ),
        'items_list_navigation' => __( 'Jobs list navigation', 'cob_theme' ),
        'filter_items_list'     => __( 'Filter jobs list', 'cob_theme' ),
    );
    $args = array(
        'label'                 => __( 'Job', 'cob_theme' ),
        'description'           => __( 'Job listings for the site', 'cob_theme' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-businessman',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => false,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'rewrite'               => array( 'slug' => 'jobs' ),
        'capability_type'       => 'post',
    );
    register_post_type( 'jobs', $args );
}
add_action( 'init', 'create_jobs_post_type', 0 );
