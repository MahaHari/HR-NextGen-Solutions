<?php
/**
 * Template Part: Hero Section
 */
$headline     = hngs_get_option('hngs_hero_headline', 'Building [gradient]Intelligent[/gradient] Software for the AI Era');
$subheadline  = hngs_get_option('hngs_hero_subheadline', 'We help businesses transform through AI-powered applications, automation systems, custom software development, and intelligent digital experiences.');
$cta1_label   = hngs_get_option('hngs_hero_cta_primary_label', 'Book a Consultation');
$cta1_url     = hngs_get_option('hngs_hero_cta_primary_url', '');
$cta2_label   = hngs_get_option('hngs_hero_cta_secondary_label', 'View Our Work');
$cta2_url     = hngs_get_option('hngs_hero_cta_secondary_url', '');

// Fall back to contact/case-studies pages
if ( ! $cta1_url ) {
    $contact_page = get_page_by_path('contact');
    $cta1_url = $contact_page ? get_permalink($contact_page->ID) : home_url('/contact/');
}
if ( ! $cta2_url ) {
    $cs_url = get_post_type_archive_link('hngs_case_study');
    $cta2_url = $cs_url ?: home_url('/case-studies/');
}

$stats = [];
for ($i = 1; $i <= 4; $i++) {
    $defaults = [1=>['50+','Projects Delivered'],2=>['5+','Years of Excellence'],3=>['98%','Client Satisfaction'],4=>['20+','Industries Served']];
    $stats[] = [
        'value' => hngs_get_option("hngs_stat_{$i}_value", $defaults[$i][0]),
        'label' => hngs_get_option("hngs_stat_{$i}_label", $defaults[$i][1]),
    ];
}
?>

<section class="hero" id="hero" aria-label="Hero">

    <!-- Particle Canvas Background -->
    <canvas id="hero-canvas" aria-hidden="true"></canvas>

    <!-- Gradient Overlay -->
    <div class="hero-gradient-overlay" aria-hidden="true"></div>

    <!-- Ambient Glow Orbs -->
    <div class="hero-orb hero-orb--1" aria-hidden="true"></div>
    <div class="hero-orb hero-orb--2" aria-hidden="true"></div>
    <div class="hero-orb hero-orb--3" aria-hidden="true"></div>

    <div class="hero-inner container">

        <!-- Eyebrow Label -->
        <div class="hero-label reveal" aria-hidden="true">
            <span class="hero-label-dot"></span>
            AI-First Software Company
        </div>

        <!-- Headline -->
        <h1 class="reveal"><?php echo hngs_parse_headline($headline); ?></h1>

        <!-- Subheadline -->
        <p class="reveal"><?php echo esc_html($subheadline); ?></p>

        <!-- CTA Buttons -->
        <div class="btn-group reveal">
            <a href="<?php echo esc_url($cta1_url); ?>" class="btn btn-primary btn-xl">
                <?php echo esc_html($cta1_label); ?>
                <?php echo hngs_icon('arrow-right'); ?>
            </a>
            <a href="<?php echo esc_url($cta2_url); ?>" class="btn btn-ghost-white btn-xl">
                <?php echo esc_html($cta2_label); ?>
            </a>
        </div>

        <!-- Stats Bar -->
        <div class="hero-stats stagger-children" role="list" aria-label="Company statistics">
            <?php foreach ($stats as $stat): ?>
            <div class="hero-stat" role="listitem">
                <span class="hero-stat-value" data-target="<?php echo esc_attr($stat['value']); ?>">
                    <?php echo esc_html($stat['value']); ?>
                </span>
                <span class="hero-stat-label"><?php echo esc_html($stat['label']); ?></span>
            </div>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- Scroll Indicator -->
    <div class="scroll-indicator" aria-hidden="true">
        <span>Scroll</span>
        <?php echo hngs_icon('arrow-down'); ?>
    </div>

</section>
