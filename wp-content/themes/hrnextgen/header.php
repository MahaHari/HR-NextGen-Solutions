<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Skip to content -->
<a href="#main-content" class="skip-to-content"><?php _e('Skip to main content', 'hrnextgen'); ?></a>

<?php
// Use transparent header on front page (hero is dark); opaque on inner pages
$header_class = is_front_page() ? 'site-header header-transparent' : 'site-header';

// Helper: get page URL by slug
function hngs_page_url( $slug ) {
    $page = get_page_by_path( $slug );
    return $page ? get_permalink( $page->ID ) : home_url( '/' . $slug . '/' );
}

$services_url    = hngs_page_url( 'services' );
$industries_url  = hngs_page_url( 'industries' );
$case_studies_url = get_post_type_archive_link( 'hngs_case_study' ) ?: hngs_page_url( 'case-studies' );
$about_url       = hngs_page_url( 'about' );
$contact_url     = hngs_page_url( 'contact' );
?>

<!-- =========================================
     SITE HEADER
     ========================================= -->
<header class="<?php echo esc_attr( $header_class ); ?>" id="site-header" role="banner">
    <div class="header-inner">

        <!-- Logo -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header-logo" aria-label="<?php bloginfo('name'); ?> - Home">
            <img src="<?php echo esc_url( hngs_get_logo_url() ); ?>"
                 alt="<?php bloginfo('name'); ?>"
                 width="180" height="44"
                 loading="eager">
        </a>

        <!-- Desktop Navigation -->
        <nav class="header-nav" role="navigation" aria-label="Primary Navigation">

            <div class="nav-item<?php echo is_front_page() ? ' active' : ''; ?>">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-link">Home</a>
            </div>

            <!-- Services Mega Dropdown -->
            <div class="nav-item<?php echo ( is_page('services') || ( is_singular('hngs_service') ) ) ? ' active' : ''; ?>">
                <a href="<?php echo esc_url( $services_url ); ?>" class="nav-link" aria-haspopup="true" aria-expanded="false">
                    Services
                    <?php echo hngs_icon('chevron-down'); ?>
                </a>
                <div class="nav-dropdown nav-mega" role="menu">
                    <span class="mega-group-title">What We Build</span>
                    <a href="<?php echo esc_url( $services_url ); ?>#software" class="dropdown-link" role="menuitem">
                        <?php echo hngs_icon('code'); ?>
                        Software Development
                    </a>
                    <a href="<?php echo esc_url( $services_url ); ?>#mobile" class="dropdown-link" role="menuitem">
                        <?php echo hngs_icon('mobile'); ?>
                        Mobile App Development
                    </a>
                    <a href="<?php echo esc_url( $services_url ); ?>#ai" class="dropdown-link" role="menuitem">
                        <?php echo hngs_icon('ai'); ?>
                        AI Solutions
                    </a>
                    <a href="<?php echo esc_url( $services_url ); ?>#cloud" class="dropdown-link" role="menuitem">
                        <?php echo hngs_icon('cloud'); ?>
                        Cloud &amp; DevOps
                    </a>
                    <span class="mega-group-title">AI Products</span>
                    <a href="<?php echo esc_url( $services_url ); ?>#ai-agents" class="dropdown-link" role="menuitem">
                        <?php echo hngs_icon('robot'); ?>
                        AI Agents
                    </a>
                    <a href="<?php echo esc_url( $services_url ); ?>#ai-automation" class="dropdown-link" role="menuitem">
                        <?php echo hngs_icon('cpu'); ?>
                        AI Automation
                    </a>
                    <a href="<?php echo esc_url( $services_url ); ?>#ai-chatbots" class="dropdown-link" role="menuitem">
                        <?php echo hngs_icon('message'); ?>
                        AI Chatbots
                    </a>
                    <a href="<?php echo esc_url( $services_url ); ?>#ai-analytics" class="dropdown-link" role="menuitem">
                        <?php echo hngs_icon('trending-up'); ?>
                        AI Analytics
                    </a>
                </div>
            </div>

            <!-- Industries Dropdown -->
            <div class="nav-item<?php echo is_page('industries') ? ' active' : ''; ?>">
                <a href="<?php echo esc_url( $industries_url ); ?>" class="nav-link" aria-haspopup="true" aria-expanded="false">
                    Industries
                    <?php echo hngs_icon('chevron-down'); ?>
                </a>
                <div class="nav-dropdown" role="menu">
                    <a href="<?php echo esc_url( $industries_url ); ?>#healthcare" class="dropdown-link" role="menuitem"><?php echo hngs_icon('heart'); ?> Healthcare</a>
                    <a href="<?php echo esc_url( $industries_url ); ?>#logistics" class="dropdown-link" role="menuitem"><?php echo hngs_icon('truck'); ?> Logistics</a>
                    <a href="<?php echo esc_url( $industries_url ); ?>#real-estate" class="dropdown-link" role="menuitem"><?php echo hngs_icon('home'); ?> Real Estate</a>
                    <a href="<?php echo esc_url( $industries_url ); ?>#retail" class="dropdown-link" role="menuitem"><?php echo hngs_icon('shopping'); ?> Retail</a>
                    <a href="<?php echo esc_url( $industries_url ); ?>#restaurants" class="dropdown-link" role="menuitem"><?php echo hngs_icon('globe'); ?> Restaurants</a>
                    <a href="<?php echo esc_url( $industries_url ); ?>#salons" class="dropdown-link" role="menuitem"><?php echo hngs_icon('scissors'); ?> Salons</a>
                    <a href="<?php echo esc_url( $industries_url ); ?>#education" class="dropdown-link" role="menuitem"><?php echo hngs_icon('book'); ?> Education</a>
                    <a href="<?php echo esc_url( $industries_url ); ?>#finance" class="dropdown-link" role="menuitem"><?php echo hngs_icon('dollar'); ?> Finance</a>
                </div>
            </div>

            <div class="nav-item<?php echo ( is_post_type_archive('hngs_case_study') || is_singular('hngs_case_study') ) ? ' active' : ''; ?>">
                <a href="<?php echo esc_url( $case_studies_url ); ?>" class="nav-link">Case Studies</a>
            </div>

            <div class="nav-item<?php echo is_page('about') ? ' active' : ''; ?>">
                <a href="<?php echo esc_url( $about_url ); ?>" class="nav-link">About Us</a>
            </div>

        </nav>

        <!-- Header CTA -->
        <div class="header-cta">
            <a href="<?php echo esc_url( $contact_url ); ?>" class="btn btn-primary btn-sm">
                Book a Consultation
                <?php echo hngs_icon('arrow-right'); ?>
            </a>
        </div>

        <!-- Mobile Hamburger -->
        <button class="hamburger" id="hamburger-btn" aria-label="Open navigation menu" aria-expanded="false" aria-controls="mobile-menu">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>

    </div>
</header>

<!-- Mobile Menu Overlay -->
<nav class="mobile-menu" id="mobile-menu" role="navigation" aria-label="Mobile Navigation" aria-hidden="true">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-nav-link">Home</a>
    <a href="<?php echo esc_url( $services_url ); ?>" class="mobile-nav-link">Services</a>
    <a href="<?php echo esc_url( $industries_url ); ?>" class="mobile-nav-link">Industries</a>
    <a href="<?php echo esc_url( $case_studies_url ); ?>" class="mobile-nav-link">Case Studies</a>
    <a href="<?php echo esc_url( $about_url ); ?>" class="mobile-nav-link">About Us</a>
    <a href="<?php echo esc_url( $contact_url ); ?>" class="mobile-nav-link">Contact</a>
    <a href="<?php echo esc_url( $contact_url ); ?>" class="btn btn-primary">Book a Consultation</a>
</nav>

<!-- Main Content -->
<main id="main-content">
