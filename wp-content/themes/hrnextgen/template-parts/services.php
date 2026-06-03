<?php
/**
 * Template Part: Services Section
 */

// Fallback service data for when CPTs are not populated yet
$default_services = [
    [
        'icon'     => 'code',
        'title'    => 'Software Development',
        'desc'     => 'Enterprise-grade custom software built to automate operations, integrate systems, and scale with your business.',
        'subs'     => ['Enterprise Applications', 'SaaS Platforms', 'Custom Business Solutions', 'API Development & Integration'],
        'category' => 'software',
    ],
    [
        'icon'     => 'mobile',
        'title'    => 'Mobile App Development',
        'desc'     => 'Native and cross-platform mobile experiences that engage users and drive measurable business outcomes.',
        'subs'     => ['iOS App Development', 'Android App Development', 'Cross-Platform (Flutter/RN)', 'Mobile Backend Services'],
        'category' => 'mobile',
    ],
    [
        'icon'     => 'ai',
        'title'    => 'AI Solutions',
        'desc'     => 'From intelligent chatbots to full AI transformation — we design and deploy AI systems that actually deliver ROI.',
        'subs'     => ['AI Agents & Assistants', 'AI Chatbots & Voice AI', 'Workflow Automation', 'Generative AI Applications'],
        'category' => 'ai',
    ],
    [
        'icon'     => 'cloud',
        'title'    => 'Cloud & DevOps',
        'desc'     => 'Scalable cloud infrastructure, CI/CD pipelines, and DevOps practices that keep your software fast and reliable.',
        'subs'     => ['AWS & Azure Architecture', 'CI/CD Pipeline Setup', 'Infrastructure as Code', 'Performance Monitoring'],
        'category' => 'cloud',
    ],
];

$services_query = new WP_Query([
    'post_type'      => 'hngs_service',
    'posts_per_page' => 8,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
]);

$use_fallback = ! $services_query->have_posts();
?>

<section class="section" id="services" aria-label="Services">
    <div class="container">

        <div class="section-header">
            <span class="section-label">What We Build</span>
            <h2>Everything You Need to Build, <span class="text-gradient">Scale, and Automate</span></h2>
            <p>From bespoke software to full-stack AI systems — we deliver end-to-end technology solutions that move your business forward.</p>
        </div>

        <div class="services-grid stagger-children">
            <?php if ($use_fallback): ?>
                <?php foreach ($default_services as $service): ?>
                <div class="card card--hover-glow reveal">
                    <div class="icon-wrap icon-wrap--lg">
                        <?php echo hngs_icon($service['icon']); ?>
                    </div>
                    <h3><?php echo esc_html($service['title']); ?></h3>
                    <p><?php echo esc_html($service['desc']); ?></p>
                    <ul class="service-sub-list">
                        <?php foreach ($service['subs'] as $sub): ?>
                        <li class="service-sub-item"><?php echo esc_html($sub); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <?php
                $icon_map = ['software'=>'code','mobile'=>'mobile','ai'=>'ai','cloud'=>'cloud'];
                while ($services_query->have_posts()): $services_query->the_post();
                    $category  = get_post_meta(get_the_ID(), '_hngs_service_category', true);
                    $sub_svcs  = get_post_meta(get_the_ID(), '_hngs_sub_services', true);
                    $icon_name = isset($icon_map[$category]) ? $icon_map[$category] : 'code';
                    $sub_svcs  = is_array($sub_svcs) ? array_filter($sub_svcs) : [];
                ?>
                <div class="card card--hover-glow reveal">
                    <div class="icon-wrap icon-wrap--lg">
                        <?php echo hngs_icon($icon_name); ?>
                    </div>
                    <h3><?php the_title(); ?></h3>
                    <p><?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 20, '…'); ?></p>
                    <?php if (!empty($sub_svcs)): ?>
                    <ul class="service-sub-list">
                        <?php foreach ($sub_svcs as $sub): ?>
                        <li class="service-sub-item"><?php echo esc_html($sub); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>

        <div style="text-align:center;margin-top:var(--space-10);">
            <a href="#contact" class="btn btn-primary btn-lg">
                Start Your Project
                <?php echo hngs_icon('arrow-right'); ?>
            </a>
        </div>

    </div>
</section>
