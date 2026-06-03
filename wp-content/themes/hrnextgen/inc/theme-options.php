<?php
/**
 * HR NextGen Solutions - Theme Options Page
 * WordPress Settings API - Appearance > Theme Options
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register the admin menu page
 */
function hngs_add_theme_options_page() {
    add_theme_page(
        __( 'HR NextGen - Theme Options', 'hrnextgen' ),
        __( 'Theme Options', 'hrnextgen' ),
        'manage_options',
        'hngs-theme-options',
        'hngs_render_theme_options_page'
    );
}
add_action( 'admin_menu', 'hngs_add_theme_options_page' );

/**
 * Register settings
 */
function hngs_register_settings() {
    $options = [
        // General
        'hngs_site_tagline', 'hngs_admin_email', 'hngs_auto_reply',
        // Hero
        'hngs_hero_headline', 'hngs_hero_subheadline', 'hngs_hero_cta_primary_label',
        'hngs_hero_cta_primary_url', 'hngs_hero_cta_secondary_label', 'hngs_hero_cta_secondary_url',
        // Contact
        'hngs_contact_email', 'hngs_contact_phone', 'hngs_contact_whatsapp', 'hngs_contact_address',
        // Stats
        'hngs_stat_1_value', 'hngs_stat_1_label',
        'hngs_stat_2_value', 'hngs_stat_2_label',
        'hngs_stat_3_value', 'hngs_stat_3_label',
        'hngs_stat_4_value', 'hngs_stat_4_label',
        // Social
        'hngs_social_linkedin', 'hngs_social_twitter', 'hngs_social_github', 'hngs_social_whatsapp',
        // SEO
        'hngs_meta_description',
        // Vision
        'hngs_vision_cta_primary_url', 'hngs_vision_cta_secondary_url',
    ];
    foreach ( $options as $option ) {
        register_setting( 'hngs_theme_options', $option, [ 'sanitize_callback' => 'sanitize_text_field' ] );
    }
    // Textarea fields need different sanitization
    register_setting( 'hngs_theme_options', 'hngs_hero_subheadline', [ 'sanitize_callback' => 'sanitize_textarea_field' ] );
    register_setting( 'hngs_theme_options', 'hngs_meta_description', [ 'sanitize_callback' => 'sanitize_textarea_field' ] );
    register_setting( 'hngs_theme_options', 'hngs_contact_address', [ 'sanitize_callback' => 'sanitize_textarea_field' ] );
}
add_action( 'admin_init', 'hngs_register_settings' );

/**
 * Helper: get option with default
 */
function hngs_get_option( $key, $default = '' ) {
    return get_option( $key, $default );
}

/**
 * Render the theme options page
 */
function hngs_render_theme_options_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    $active_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'general';
    $tabs = [
        'general'  => 'General',
        'hero'     => 'Hero',
        'contact'  => 'Contact Info',
        'stats'    => 'Statistics',
        'social'   => 'Social Links',
        'seo'      => 'SEO',
    ];
    ?>
    <div class="wrap hngs-admin-wrap">
        <div class="hngs-options-header">
            <h2>HR NextGen Solutions — Theme Options</h2>
            <p>Manage your website content, statistics, and contact information.</p>
        </div>
        <form method="post" action="options.php">
            <?php settings_fields( 'hngs_theme_options' ); ?>
            <div class="hngs-options-tabs">
                <?php foreach ( $tabs as $slug => $label ) : ?>
                <button type="button" class="hngs-tab-btn <?php echo $active_tab === $slug ? 'active' : ''; ?>"
                    data-tab="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $label ); ?></button>
                <?php endforeach; ?>
            </div>

            <!-- General Tab -->
            <div class="hngs-tab-panel <?php echo $active_tab === 'general' ? 'active' : ''; ?>" data-panel="general">
                <div class="hngs-form-group">
                    <label for="hngs_site_tagline">Site Tagline</label>
                    <input type="text" id="hngs_site_tagline" name="hngs_site_tagline" value="<?php echo esc_attr( hngs_get_option( 'hngs_site_tagline', 'Building Intelligent Software for the AI Era' ) ); ?>" class="large-text">
                </div>
                <div class="hngs-form-group">
                    <label for="hngs_admin_email">Admin Notification Email</label>
                    <input type="text" id="hngs_admin_email" name="hngs_admin_email" value="<?php echo esc_attr( hngs_get_option( 'hngs_admin_email', get_option( 'admin_email' ) ) ); ?>" class="regular-text">
                    <p class="description">Contact form submissions will be sent to this email address.</p>
                </div>
                <div class="hngs-form-group">
                    <label for="hngs_auto_reply">Auto-Reply Confirmation</label>
                    <select id="hngs_auto_reply" name="hngs_auto_reply">
                        <option value="yes" <?php selected( hngs_get_option( 'hngs_auto_reply', 'yes' ), 'yes' ); ?>>Send auto-reply to submitters</option>
                        <option value="no" <?php selected( hngs_get_option( 'hngs_auto_reply', 'yes' ), 'no' ); ?>>Disable auto-reply</option>
                    </select>
                </div>
            </div>

            <!-- Hero Tab -->
            <div class="hngs-tab-panel <?php echo $active_tab === 'hero' ? 'active' : ''; ?>" data-panel="hero">
                <div class="hngs-form-group">
                    <label for="hngs_hero_headline">Hero Headline</label>
                    <input type="text" id="hngs_hero_headline" name="hngs_hero_headline" value="<?php echo esc_attr( hngs_get_option( 'hngs_hero_headline', 'Building Intelligent Software for the AI Era' ) ); ?>" class="large-text">
                    <p class="description">Wrap a word in [gradient]word[/gradient] to apply the brand gradient.</p>
                </div>
                <div class="hngs-form-group">
                    <label for="hngs_hero_subheadline">Hero Subheadline</label>
                    <textarea id="hngs_hero_subheadline" name="hngs_hero_subheadline" class="large-text" rows="3"><?php echo esc_textarea( hngs_get_option( 'hngs_hero_subheadline', 'We help businesses transform through AI-powered applications, automation systems, custom software development, and intelligent digital experiences.' ) ); ?></textarea>
                </div>
                <div class="hngs-form-row">
                    <div class="hngs-form-group">
                        <label for="hngs_hero_cta_primary_label">Primary CTA Label</label>
                        <input type="text" id="hngs_hero_cta_primary_label" name="hngs_hero_cta_primary_label" value="<?php echo esc_attr( hngs_get_option( 'hngs_hero_cta_primary_label', 'Book a Consultation' ) ); ?>" class="regular-text">
                    </div>
                    <div class="hngs-form-group">
                        <label for="hngs_hero_cta_primary_url">Primary CTA URL</label>
                        <input type="text" id="hngs_hero_cta_primary_url" name="hngs_hero_cta_primary_url" value="<?php echo esc_attr( hngs_get_option( 'hngs_hero_cta_primary_url', '#contact' ) ); ?>" class="regular-text">
                    </div>
                </div>
                <div class="hngs-form-row">
                    <div class="hngs-form-group">
                        <label for="hngs_hero_cta_secondary_label">Secondary CTA Label</label>
                        <input type="text" id="hngs_hero_cta_secondary_label" name="hngs_hero_cta_secondary_label" value="<?php echo esc_attr( hngs_get_option( 'hngs_hero_cta_secondary_label', 'View Our Work' ) ); ?>" class="regular-text">
                    </div>
                    <div class="hngs-form-group">
                        <label for="hngs_hero_cta_secondary_url">Secondary CTA URL</label>
                        <input type="text" id="hngs_hero_cta_secondary_url" name="hngs_hero_cta_secondary_url" value="<?php echo esc_attr( hngs_get_option( 'hngs_hero_cta_secondary_url', '#case-studies' ) ); ?>" class="regular-text">
                    </div>
                </div>
            </div>

            <!-- Contact Info Tab -->
            <div class="hngs-tab-panel <?php echo $active_tab === 'contact' ? 'active' : ''; ?>" data-panel="contact">
                <div class="hngs-form-row">
                    <div class="hngs-form-group">
                        <label for="hngs_contact_email">Email Address</label>
                        <input type="text" id="hngs_contact_email" name="hngs_contact_email" value="<?php echo esc_attr( hngs_get_option( 'hngs_contact_email', 'hello@hrnextgensolutions.com' ) ); ?>" class="regular-text">
                    </div>
                    <div class="hngs-form-group">
                        <label for="hngs_contact_phone">Phone Number</label>
                        <input type="text" id="hngs_contact_phone" name="hngs_contact_phone" value="<?php echo esc_attr( hngs_get_option( 'hngs_contact_phone', '' ) ); ?>" class="regular-text" placeholder="+1 (555) 000-0000">
                    </div>
                </div>
                <div class="hngs-form-row">
                    <div class="hngs-form-group">
                        <label for="hngs_contact_whatsapp">WhatsApp Number</label>
                        <input type="text" id="hngs_contact_whatsapp" name="hngs_contact_whatsapp" value="<?php echo esc_attr( hngs_get_option( 'hngs_contact_whatsapp', '' ) ); ?>" class="regular-text" placeholder="15550000000 (digits only, no +)">
                        <p class="description">Digits only, no spaces or + sign. Used to build wa.me/ link.</p>
                    </div>
                    <div class="hngs-form-group">
                        <label for="hngs_contact_address">Office Address</label>
                        <textarea id="hngs_contact_address" name="hngs_contact_address" rows="3" class="regular-text"><?php echo esc_textarea( hngs_get_option( 'hngs_contact_address', '' ) ); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Statistics Tab -->
            <div class="hngs-tab-panel <?php echo $active_tab === 'stats' ? 'active' : ''; ?>" data-panel="stats">
                <p style="margin-bottom:16px;color:#646970;">These statistics appear in the hero section counter bar. Use numbers with optional suffix (e.g. <code>50+</code>, <code>98%</code>).</p>
                <div class="hngs-stats-grid">
                    <?php for ( $i = 1; $i <= 4; $i++ ) :
                        $defaults = [ 1 => ['50+','Projects Delivered'], 2 => ['5+','Years of Excellence'], 3 => ['98%','Client Satisfaction'], 4 => ['20+','Industries Served'] ];
                    ?>
                    <div class="hngs-stat-group">
                        <h4>Stat <?php echo $i; ?></h4>
                        <div class="hngs-form-group">
                            <label>Value</label>
                            <input type="text" name="hngs_stat_<?php echo $i; ?>_value" value="<?php echo esc_attr( hngs_get_option( "hngs_stat_{$i}_value", $defaults[$i][0] ) ); ?>" class="small-text">
                        </div>
                        <div class="hngs-form-group">
                            <label>Label</label>
                            <input type="text" name="hngs_stat_<?php echo $i; ?>_label" value="<?php echo esc_attr( hngs_get_option( "hngs_stat_{$i}_label", $defaults[$i][1] ) ); ?>" class="regular-text">
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Social Links Tab -->
            <div class="hngs-tab-panel <?php echo $active_tab === 'social' ? 'active' : ''; ?>" data-panel="social">
                <?php
                $social_fields = [
                    'linkedin'  => [ 'LinkedIn URL', 'https://linkedin.com/company/hrnextgensolutions' ],
                    'twitter'   => [ 'Twitter / X URL', 'https://twitter.com/hrnextgen' ],
                    'github'    => [ 'GitHub URL', '' ],
                    'whatsapp'  => [ 'WhatsApp Chat URL', '' ],
                ];
                foreach ( $social_fields as $key => $data ) : ?>
                <div class="hngs-form-group">
                    <label for="hngs_social_<?php echo $key; ?>"><?php echo esc_html( $data[0] ); ?></label>
                    <input type="text" id="hngs_social_<?php echo $key; ?>" name="hngs_social_<?php echo $key; ?>" value="<?php echo esc_attr( hngs_get_option( "hngs_social_{$key}", $data[1] ) ); ?>" class="large-text">
                </div>
                <?php endforeach; ?>
            </div>

            <!-- SEO Tab -->
            <div class="hngs-tab-panel <?php echo $active_tab === 'seo' ? 'active' : ''; ?>" data-panel="seo">
                <div class="hngs-form-group">
                    <label for="hngs_meta_description">Homepage Meta Description</label>
                    <textarea id="hngs_meta_description" name="hngs_meta_description" class="large-text" rows="4" maxlength="160"><?php echo esc_textarea( hngs_get_option( 'hngs_meta_description', 'HR NextGen Solutions — AI-first software development company building intelligent applications, automation systems, and next-generation digital experiences for businesses worldwide.' ) ); ?></textarea>
                    <p class="description">Keep under 160 characters for best SEO results.</p>
                </div>
            </div>

            <div class="hngs-save-row">
                <?php submit_button( 'Save All Settings', 'primary large', 'submit', false ); ?>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var buttons = document.querySelectorAll('.hngs-tab-btn');
        var panels  = document.querySelectorAll('.hngs-tab-panel');
        buttons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                buttons.forEach(function(b) { b.classList.remove('active'); });
                panels.forEach(function(p) { p.classList.remove('active'); });
                btn.classList.add('active');
                var panel = document.querySelector('.hngs-tab-panel[data-panel="' + btn.dataset.tab + '"]');
                if (panel) panel.classList.add('active');
                // Update URL without reload
                var url = new URL(window.location.href);
                url.searchParams.set('tab', btn.dataset.tab);
                history.replaceState(null, '', url.toString());
            });
        });
    });
    </script>
    <?php
}
