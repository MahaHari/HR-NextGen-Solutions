<?php
/**
 * Template Part: Industries Section
 */

$default_industries = [
    ['icon'=>'heart',    'title'=>'Healthcare',   'desc'=>'HIPAA-compliant patient management, clinical AI, and telehealth platforms.'],
    ['icon'=>'truck',    'title'=>'Logistics',    'desc'=>'Real-time tracking, route optimization, and supply chain automation.'],
    ['icon'=>'home',     'title'=>'Real Estate',  'desc'=>'Property management systems, virtual tours, and AI-driven lead scoring.'],
    ['icon'=>'shopping', 'title'=>'Retail',       'desc'=>'Omnichannel commerce, inventory AI, and personalized shopping experiences.'],
    ['icon'=>'globe',    'title'=>'Restaurants',  'desc'=>'Online ordering, kitchen automation, and customer loyalty AI systems.'],
    ['icon'=>'scissors', 'title'=>'Salons',       'desc'=>'Booking automation, client retention AI, and revenue management tools.'],
    ['icon'=>'book',     'title'=>'Education',    'desc'=>'Adaptive learning platforms, AI tutoring, and student engagement systems.'],
    ['icon'=>'dollar',   'title'=>'Finance',      'desc'=>'Fintech platforms, AI risk assessment, and automated compliance tools.'],
];

$industries_query = new WP_Query([
    'post_type'      => 'hngs_industry',
    'posts_per_page' => 12,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
]);

$use_fallback = ! $industries_query->have_posts();
$icon_map_industries = ['Healthcare'=>'heart','Logistics'=>'truck','Real Estate'=>'home','Retail'=>'shopping','Restaurants'=>'globe','Salons'=>'scissors','Education'=>'book','Finance'=>'dollar'];
?>

<section class="section section--alt" id="industries" aria-label="Industries We Serve">
    <div class="container">

        <div class="section-header">
            <span class="section-label">Industries</span>
            <h2>Built for <span class="text-gradient">Your Industry</span></h2>
            <p>We combine deep domain expertise with cutting-edge technology to build solutions that understand your specific challenges, regulations, and growth opportunities.</p>
        </div>

        <div class="industries-grid stagger-children">
            <?php if ($use_fallback): ?>
                <?php foreach ($default_industries as $ind): ?>
                <div class="industry-tile reveal">
                    <div class="industry-icon">
                        <?php echo hngs_icon($ind['icon']); ?>
                    </div>
                    <h3><?php echo esc_html($ind['title']); ?></h3>
                    <p><?php echo esc_html($ind['desc']); ?></p>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <?php while ($industries_query->have_posts()): $industries_query->the_post();
                    $title     = get_the_title();
                    $icon_name = isset($icon_map_industries[$title]) ? $icon_map_industries[$title] : 'globe';
                    $thumb     = get_the_post_thumbnail_url(get_the_ID(), 'hngs-thumbnail');
                ?>
                <div class="industry-tile reveal">
                    <div class="industry-icon">
                        <?php if ($thumb): ?>
                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy" style="width:28px;height:28px;object-fit:contain;">
                        <?php else: ?>
                        <?php echo hngs_icon($icon_name); ?>
                        <?php endif; ?>
                    </div>
                    <h3><?php the_title(); ?></h3>
                    <p><?php echo wp_trim_words(get_the_excerpt() ?: strip_tags(get_the_content()), 15, '…'); ?></p>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>

        <div style="text-align:center;margin-top:var(--space-10);">
            <a href="#contact" class="btn btn-ghost-gradient btn-lg">
                Talk to an Industry Expert
                <?php echo hngs_icon('arrow-right'); ?>
            </a>
        </div>

    </div>
</section>
