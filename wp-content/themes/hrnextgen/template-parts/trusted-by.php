<?php
/**
 * Template Part: Trusted By / Partners Marquee
 */
$partners_query = new WP_Query([
    'post_type'      => 'hngs_partner',
    'posts_per_page' => 20,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
]);

// Fallback text-based clients if no CPT entries yet
$fallback_names = [
    'TechVentures Co.', 'MediCore Health', 'LogiFlow Systems', 'RetailPro',
    'BuildSmart Realty', 'SwiftEats Group', 'FintechEdge', 'CloudScale Inc.',
    'DataDriven Labs', 'NovaMed Group', 'PrimeLogistics', 'UrbanNest Properties',
];
?>

<section class="trusted-by" aria-label="Trusted By">
    <div class="trusted-by-label">Trusted by Growing Companies Worldwide</div>
    <div class="marquee-wrapper" aria-hidden="true">
        <div class="marquee-track" id="marquee-track">
            <?php if ($partners_query->have_posts()): ?>
                <!-- First set -->
                <?php while ($partners_query->have_posts()): $partners_query->the_post();
                    $logo_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                ?>
                <div class="marquee-item">
                    <?php if ($logo_url): ?>
                    <img src="<?php echo esc_url($logo_url); ?>"
                         alt="<?php the_title_attribute(); ?>"
                         loading="lazy">
                    <?php else: ?>
                    <span class="marquee-item-text"><?php the_title(); ?></span>
                    <?php endif; ?>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
                <!-- Duplicate for seamless loop -->
                <?php
                $partners_query->rewind_posts();
                while ($partners_query->have_posts()): $partners_query->the_post();
                    $logo_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                ?>
                <div class="marquee-item">
                    <?php if ($logo_url): ?>
                    <img src="<?php echo esc_url($logo_url); ?>"
                         alt="<?php the_title_attribute(); ?>"
                         loading="lazy">
                    <?php else: ?>
                    <span class="marquee-item-text"><?php the_title(); ?></span>
                    <?php endif; ?>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else: ?>
                <!-- Fallback: text-based logos -->
                <?php foreach (array_merge($fallback_names, $fallback_names) as $name): ?>
                <div class="marquee-item">
                    <span class="marquee-item-text"><?php echo esc_html($name); ?></span>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
