<?php
/**
 * HR NextGen Solutions - Custom Post Types
 * Registers all theme CPTs: Service, Case Study, Testimonial, Industry, Partner
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function hngs_register_post_types() {

    // ---- Services ----
    register_post_type( 'hngs_service', [
        'labels' => [
            'name'               => __( 'Services', 'hrnextgen' ),
            'singular_name'      => __( 'Service', 'hrnextgen' ),
            'add_new'            => __( 'Add New Service', 'hrnextgen' ),
            'add_new_item'       => __( 'Add New Service', 'hrnextgen' ),
            'edit_item'          => __( 'Edit Service', 'hrnextgen' ),
            'view_item'          => __( 'View Service', 'hrnextgen' ),
            'search_items'       => __( 'Search Services', 'hrnextgen' ),
            'not_found'          => __( 'No services found.', 'hrnextgen' ),
            'menu_name'          => __( 'Services', 'hrnextgen' ),
        ],
        'public'              => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-star-filled',
        'supports'            => [ 'title', 'editor', 'thumbnail' ],
        'has_archive'         => false,
        'rewrite'             => [ 'slug' => 'services' ],
        'show_in_rest'        => true,
    ] );

    // ---- Case Studies ----
    register_post_type( 'hngs_case_study', [
        'labels' => [
            'name'               => __( 'Case Studies', 'hrnextgen' ),
            'singular_name'      => __( 'Case Study', 'hrnextgen' ),
            'add_new'            => __( 'Add New Case Study', 'hrnextgen' ),
            'add_new_item'       => __( 'Add New Case Study', 'hrnextgen' ),
            'edit_item'          => __( 'Edit Case Study', 'hrnextgen' ),
            'view_item'          => __( 'View Case Study', 'hrnextgen' ),
            'search_items'       => __( 'Search Case Studies', 'hrnextgen' ),
            'not_found'          => __( 'No case studies found.', 'hrnextgen' ),
            'menu_name'          => __( 'Case Studies', 'hrnextgen' ),
        ],
        'public'              => true,
        'show_in_menu'        => true,
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-analytics',
        'supports'            => [ 'title', 'editor', 'thumbnail' ],
        'has_archive'         => true,
        'rewrite'             => [ 'slug' => 'case-studies' ],
        'show_in_rest'        => true,
    ] );

    // ---- Testimonials ----
    register_post_type( 'hngs_testimonial', [
        'labels' => [
            'name'               => __( 'Testimonials', 'hrnextgen' ),
            'singular_name'      => __( 'Testimonial', 'hrnextgen' ),
            'add_new'            => __( 'Add New Testimonial', 'hrnextgen' ),
            'add_new_item'       => __( 'Add New Testimonial', 'hrnextgen' ),
            'edit_item'          => __( 'Edit Testimonial', 'hrnextgen' ),
            'not_found'          => __( 'No testimonials found.', 'hrnextgen' ),
            'menu_name'          => __( 'Testimonials', 'hrnextgen' ),
        ],
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 7,
        'menu_icon'           => 'dashicons-format-quote',
        'supports'            => [ 'title', 'editor', 'thumbnail' ],
        'show_in_rest'        => true,
    ] );

    // ---- Industries ----
    register_post_type( 'hngs_industry', [
        'labels' => [
            'name'               => __( 'Industries', 'hrnextgen' ),
            'singular_name'      => __( 'Industry', 'hrnextgen' ),
            'add_new'            => __( 'Add New Industry', 'hrnextgen' ),
            'add_new_item'       => __( 'Add New Industry', 'hrnextgen' ),
            'edit_item'          => __( 'Edit Industry', 'hrnextgen' ),
            'not_found'          => __( 'No industries found.', 'hrnextgen' ),
            'menu_name'          => __( 'Industries', 'hrnextgen' ),
        ],
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 8,
        'menu_icon'           => 'dashicons-building',
        'supports'            => [ 'title', 'editor', 'thumbnail' ],
        'show_in_rest'        => true,
    ] );

    // ---- Partners (Trusted By) ----
    register_post_type( 'hngs_partner', [
        'labels' => [
            'name'               => __( 'Partners', 'hrnextgen' ),
            'singular_name'      => __( 'Partner', 'hrnextgen' ),
            'add_new'            => __( 'Add New Partner', 'hrnextgen' ),
            'add_new_item'       => __( 'Add Partner Logo', 'hrnextgen' ),
            'edit_item'          => __( 'Edit Partner', 'hrnextgen' ),
            'not_found'          => __( 'No partners found.', 'hrnextgen' ),
            'menu_name'          => __( 'Partners', 'hrnextgen' ),
        ],
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 9,
        'menu_icon'           => 'dashicons-groups',
        'supports'            => [ 'title', 'thumbnail' ],
        'show_in_rest'        => true,
    ] );
}
add_action( 'init', 'hngs_register_post_types' );
