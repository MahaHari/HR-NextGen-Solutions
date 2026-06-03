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

<!-- =========================================
     SITE HEADER
     ========================================= -->
<header class="site-header" id="site-header" role="banner">
    <div class="header-inner">

        <!-- Logo -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="header-logo" aria-label="<?php bloginfo('name'); ?> - Home">
            <img src="<?php echo esc_url(hngs_get_logo_url()); ?>"
                 alt="<?php bloginfo('name'); ?>"
                 width="180" height="44"
                 loading="eager">
        </a>

        <!-- Desktop Navigation -->
        <nav class="header-nav" role="navigation" aria-label="Primary Navigation">

            <div class="nav-item">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link">Home</a>
            </div>

            <!-- Services Mega Dropdown -->
            <div class="nav-item">
                <a href="#services" class="nav-link" aria-haspopup="true" aria-expanded="false">
                    Services
                    <?php echo hngs_icon('chevron-down'); ?>
                </a>
                <div class="nav-dropdown nav-mega" role="menu">
                    <span class="mega-group-title">What We Build</span>
                    <a href="#services" class="dropdown-link" role="menuitem">
                        <?php echo hngs_icon('code'); ?>
                        Software Development
                    </a>
                    <a href="#services" class="dropdown-link" role="menuitem">
                        <?php echo hngs_icon('mobile'); ?>
                        Mobile App Development
                    </a>
                    <a href="#services" class="dropdown-link" role="menuitem">
                        <?php echo hngs_icon('ai'); ?>
                        AI Solutions
                    </a>
                    <a href="#services" class="dropdown-link" role="menuitem">
                        <?php echo hngs_icon('cloud'); ?>
                        Cloud &amp; DevOps
                    </a>
                    <span class="mega-group-title">AI Products</span>
                    <a href="#ai-focus" class="dropdown-link" role="menuitem">
                        <?php echo hngs_icon('robot'); ?>
                        AI Agents
                    </a>
                    <a href="#ai-focus" class="dropdown-link" role="menuitem">
                        <?php echo hngs_icon('cpu'); ?>
                        AI Automation
                    </a>
                    <a href="#ai-focus" class="dropdown-link" role="menuitem">
                        <?php echo hngs_icon('message'); ?>
                        AI Chatbots
                    </a>
                    <a href="#ai-focus" class="dropdown-link" role="menuitem">
                        <?php echo hngs_icon('trending-up'); ?>
                        AI Analytics
                    </a>
                </div>
            </div>

            <!-- Industries Dropdown -->
            <div class="nav-item">
                <a href="#industries" class="nav-link" aria-haspopup="true" aria-expanded="false">
                    Industries
                    <?php echo hngs_icon('chevron-down'); ?>
                </a>
                <div class="nav-dropdown" role="menu">
                    <a href="#industries" class="dropdown-link" role="menuitem"><?php echo hngs_icon('heart'); ?> Healthcare</a>
                    <a href="#industries" class="dropdown-link" role="menuitem"><?php echo hngs_icon('truck'); ?> Logistics</a>
                    <a href="#industries" class="dropdown-link" role="menuitem"><?php echo hngs_icon('home'); ?> Real Estate</a>
                    <a href="#industries" class="dropdown-link" role="menuitem"><?php echo hngs_icon('shopping'); ?> Retail</a>
                    <a href="#industries" class="dropdown-link" role="menuitem"><?php echo hngs_icon('globe'); ?> Restaurants</a>
                    <a href="#industries" class="dropdown-link" role="menuitem"><?php echo hngs_icon('scissors'); ?> Salons</a>
                    <a href="#industries" class="dropdown-link" role="menuitem"><?php echo hngs_icon('book'); ?> Education</a>
                    <a href="#industries" class="dropdown-link" role="menuitem"><?php echo hngs_icon('dollar'); ?> Finance</a>
                </div>
            </div>

            <div class="nav-item">
                <a href="#case-studies" class="nav-link">Case Studies</a>
            </div>

            <div class="nav-item">
                <a href="#vision" class="nav-link">About</a>
            </div>

        </nav>

        <!-- Header CTA -->
        <div class="header-cta">
            <a href="#contact" class="btn btn-primary btn-sm">
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
    <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-nav-link">Home</a>
    <a href="#services" class="mobile-nav-link">Services</a>
    <a href="#ai-focus" class="mobile-nav-link">AI Solutions</a>
    <a href="#industries" class="mobile-nav-link">Industries</a>
    <a href="#case-studies" class="mobile-nav-link">Case Studies</a>
    <a href="#vision" class="mobile-nav-link">About</a>
    <a href="#contact" class="btn btn-primary">Book a Consultation</a>
</nav>

<!-- Main Content -->
<main id="main-content">
