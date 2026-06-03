<?php
/**
 * HR NextGen Solutions - SEO & Schema Markup
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Output SEO meta tags in wp_head
 */
function hngs_output_seo_meta() {
    $title       = wp_title( '|', false, 'right' ) . get_bloginfo('name');
    $description = hngs_get_option( 'hngs_meta_description', 'HR NextGen Solutions — AI-first software development company building intelligent applications, automation systems, and next-generation digital experiences for businesses worldwide.' );
    $site_url    = home_url('/');
    $logo_url    = get_template_directory_uri() . '/assets/images/logo.png';
    $og_image    = $logo_url;

    if ( is_singular() ) {
        global $post;
        if ( has_post_thumbnail( $post ) ) {
            $og_image = get_the_post_thumbnail_url( $post, 'large' );
        }
        if ( $post->post_excerpt ) {
            $description = wp_strip_all_tags( $post->post_excerpt );
        }
    }
    ?>
    <!-- SEO Meta -->
    <meta name="description" content="<?php echo esc_attr( $description ); ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="<?php echo esc_url( get_permalink() ?: $site_url ); ?>">

    <!-- Open Graph -->
    <meta property="og:type"        content="<?php echo is_singular() ? 'article' : 'website'; ?>">
    <meta property="og:title"       content="<?php echo esc_attr( $title ); ?>">
    <meta property="og:description" content="<?php echo esc_attr( $description ); ?>">
    <meta property="og:url"         content="<?php echo esc_url( get_permalink() ?: $site_url ); ?>">
    <meta property="og:image"       content="<?php echo esc_url( $og_image ); ?>">
    <meta property="og:site_name"   content="HR NextGen Solutions">

    <!-- Twitter Card -->
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="<?php echo esc_attr( $title ); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr( $description ); ?>">
    <meta name="twitter:image"       content="<?php echo esc_url( $og_image ); ?>">

    <!-- Preconnect for Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Theme Color -->
    <meta name="theme-color" content="#E91E7A">
    <?php
}
add_action( 'wp_head', 'hngs_output_seo_meta', 5 );

/**
 * Output JSON-LD Organization schema in footer
 */
function hngs_output_schema() {
    $contact_email  = hngs_get_option( 'hngs_contact_email', '' );
    $contact_phone  = hngs_get_option( 'hngs_contact_phone', '' );
    $social_linkedin = hngs_get_option( 'hngs_social_linkedin', '' );
    $social_twitter  = hngs_get_option( 'hngs_social_twitter', '' );
    $logo_url        = get_template_directory_uri() . '/assets/images/logo.png';

    $same_as = array_values( array_filter( [ $social_linkedin, $social_twitter ] ) );

    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Organization',
        'name'        => 'HR NextGen Solutions',
        'url'         => home_url('/'),
        'logo'        => $logo_url,
        'description' => 'AI-first software development company building intelligent applications, automation systems, and next-generation digital experiences.',
    ];

    if ( $contact_email ) $schema['email'] = $contact_email;
    if ( $contact_phone ) $schema['telephone'] = $contact_phone;
    if ( ! empty( $same_as ) ) $schema['sameAs'] = $same_as;

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_footer', 'hngs_output_schema', 99 );
