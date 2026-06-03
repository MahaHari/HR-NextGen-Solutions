<?php
/**
 * HR NextGen Solutions - Enqueue Scripts & Styles
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function hngs_enqueue_assets() {
    $ver = '1.0.0';
    $uri = get_template_directory_uri();

    // CSS - load in order
    wp_enqueue_style( 'hngs-variables',   $uri . '/assets/css/variables.css',   [],            $ver );
    wp_enqueue_style( 'hngs-base',        $uri . '/assets/css/base.css',        ['hngs-variables'], $ver );
    wp_enqueue_style( 'hngs-typography',  $uri . '/assets/css/typography.css',  ['hngs-base'],  $ver );
    wp_enqueue_style( 'hngs-animations',  $uri . '/assets/css/animations.css',  ['hngs-base'],  $ver );
    wp_enqueue_style( 'hngs-components',  $uri . '/assets/css/components.css',  ['hngs-base'],  $ver );
    wp_enqueue_style( 'hngs-sections',    $uri . '/assets/css/sections.css',    ['hngs-components'], $ver );
    wp_enqueue_style( 'hngs-responsive',  $uri . '/assets/css/responsive.css',  ['hngs-sections'],   $ver );

    // jQuery (WordPress built-in)
    wp_enqueue_script( 'jquery' );

    // JS - all in footer
    wp_enqueue_script( 'hngs-utils',       $uri . '/assets/js/utils.js',       ['jquery'],          $ver, true );
    wp_enqueue_script( 'hngs-hero-canvas', $uri . '/assets/js/hero-canvas.js', ['hngs-utils'],      $ver, true );
    wp_enqueue_script( 'hngs-animations',  $uri . '/assets/js/animations.js',  ['hngs-utils'],      $ver, true );
    wp_enqueue_script( 'hngs-navigation',  $uri . '/assets/js/navigation.js',  ['jquery','hngs-utils'], $ver, true );
    wp_enqueue_script( 'hngs-slider',      $uri . '/assets/js/slider.js',      ['hngs-utils'],      $ver, true );
    wp_enqueue_script( 'hngs-process',     $uri . '/assets/js/process.js',     ['hngs-utils'],      $ver, true );
    wp_enqueue_script( 'hngs-contact',     $uri . '/assets/js/contact.js',     ['jquery','hngs-utils'], $ver, true );
    wp_enqueue_script( 'hngs-main',        $uri . '/assets/js/main.js',        ['hngs-navigation','hngs-animations','hngs-slider','hngs-contact'], $ver, true );

    // Pass PHP data to JS
    wp_localize_script( 'hngs-contact', 'hngsData', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'hngs_contact_nonce' ),
    ] );
}
add_action( 'wp_enqueue_scripts', 'hngs_enqueue_assets' );


/**
 * Enqueue admin styles
 */
function hngs_enqueue_admin_assets( $hook ) {
    // Only on theme options and our submissions pages
    if ( strpos( $hook, 'hngs' ) !== false || strpos( $hook, 'appearance_page_hngs' ) !== false ) {
        wp_enqueue_style( 'hngs-admin', get_template_directory_uri() . '/assets/css/admin.css', [], '1.0.0' );
    }
    // Also load on post editing screens for CPTs
    $screen = get_current_screen();
    if ( $screen && in_array( $screen->post_type, ['hngs_service','hngs_case_study','hngs_testimonial','hngs_industry','hngs_partner'] ) ) {
        wp_enqueue_style( 'hngs-admin', get_template_directory_uri() . '/assets/css/admin.css', [], '1.0.0' );
    }
}
add_action( 'admin_enqueue_scripts', 'hngs_enqueue_admin_assets' );
