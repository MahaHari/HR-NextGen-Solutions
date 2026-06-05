<?php
/**
 * Template Name: Services
 */
get_header();

$contact_url = '';
$contact_page = get_page_by_path('contact');
if ($contact_page) $contact_url = get_permalink($contact_page->ID);
if (!$contact_url) $contact_url = home_url('/contact/');

// Fetch CPT services
$services_query = new WP_Query([
    'post_type'      => 'hngs_service',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
]);

$fallback_services = [
    [
        'icon'     => 'code',
        'category' => 'software',
        'title'    => 'Custom Software Development',
        'excerpt'  => 'End-to-end bespoke applications built for enterprise scale — from architecture planning to deployment and ongoing maintenance.',
        'subs'     => ['Web Applications','Enterprise Platforms','API Development','System Integration','Legacy Modernisation'],
    ],
    [
        'icon'     => 'mobile',
        'category' => 'mobile',
        'title'    => 'Mobile App Development',
        'excerpt'  => 'Native and cross-platform mobile experiences that users love — iOS, Android, and React Native delivered at speed.',
        'subs'     => ['iOS Development','Android Development','Cross-Platform (React Native)','App Store Optimisation','Mobile UX Design'],
    ],
    [
        'icon'     => 'ai',
        'category' => 'ai',
        'title'    => 'AI Solutions',
        'excerpt'  => 'Intelligent systems that learn, adapt, and automate — from predictive analytics to fully autonomous AI agents.',
        'subs'     => ['Machine Learning Models','Natural Language Processing','Computer Vision','Predictive Analytics','AI Strategy Consulting'],
    ],
    [
        'icon'     => 'cloud',
        'category' => 'cloud',
        'title'    => 'Cloud &amp; DevOps',
        'excerpt'  => 'Scalable cloud infrastructure and automated CI/CD pipelines that keep your products fast, reliable, and cost-efficient.',
        'subs'     => ['AWS / GCP / Azure','Kubernetes & Docker','CI/CD Automation','Cloud Cost Optimisation','Security & Compliance'],
    ],
];
?>

<!-- Page Hero -->
<section class="page-hero text-center">
    <div class="container container--narrow">
        <nav class="breadcrumb" style="justify-content:center;" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
            <span class="breadcrumb-sep" aria-hidden="true">/</span>
            <span aria-current="page">Services</span>
        </nav>
        <div class="section-label reveal">
            <span class="section-label-dot"></span>
            What We Offer
        </div>
        <h1 class="reveal">End-to-End <span class="text-gradient">Software Services</span></h1>
        <p class="reveal">From ideation to deployment and beyond — we deliver the full spectrum of software engineering and AI capabilities your business needs to compete and grow.</p>
    </div>
</section>

<!-- Core Services -->
<section class="section" id="services-overview">
    <div class="container">
        <div class="services-full-grid stagger-children">

            <?php if ($services_query->have_posts()):
                while ($services_query->have_posts()): $services_query->the_post();
                    $cat  = get_post_meta(get_the_ID(), '_hngs_service_category', true);
                    $subs = get_post_meta(get_the_ID(), '_hngs_sub_services', true);
                    if (!is_array($subs)) $subs = [];
                    $icon = $cat ?: 'code';
            ?>
            <div class="service-full-card card reveal" id="<?php echo esc_attr($cat ?: 'service'); ?>">
                <div class="service-full-card__icon">
                    <div class="icon-wrap icon-wrap--lg"><?php echo hngs_icon($icon); ?></div>
                </div>
                <div class="service-full-card__body">
                    <h2><?php the_title(); ?></h2>
                    <p><?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 35); ?></p>
                    <?php if (!empty($subs)): ?>
                    <ul class="service-sub-list">
                        <?php foreach ($subs as $sub): ?>
                        <li><?php echo hngs_icon('check'); ?> <?php echo esc_html($sub); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                    <a href="<?php echo esc_url($contact_url); ?>" class="btn btn-link">
                        Get a Quote <?php echo hngs_icon('arrow-right'); ?>
                    </a>
                </div>
            </div>
            <?php endwhile; wp_reset_postdata();

            else:
                foreach ($fallback_services as $svc): ?>
            <div class="service-full-card card reveal" id="<?php echo esc_attr($svc['category']); ?>">
                <div class="service-full-card__icon">
                    <div class="icon-wrap icon-wrap--lg"><?php echo hngs_icon($svc['icon']); ?></div>
                </div>
                <div class="service-full-card__body">
                    <h2><?php echo $svc['title']; ?></h2>
                    <p><?php echo esc_html($svc['excerpt']); ?></p>
                    <ul class="service-sub-list">
                        <?php foreach ($svc['subs'] as $sub): ?>
                        <li><?php echo hngs_icon('check'); ?> <?php echo esc_html($sub); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="<?php echo esc_url($contact_url); ?>" class="btn btn-link">
                        Get a Quote <?php echo hngs_icon('arrow-right'); ?>
                    </a>
                </div>
            </div>
            <?php endforeach; endif; ?>

        </div>
    </div>
</section>

<!-- AI Products -->
<section class="section section--alt" id="ai-products">
    <div class="container">
        <div class="section-header">
            <div class="section-label reveal">
                <span class="section-label-dot"></span>
                AI Product Suite
            </div>
            <h2 class="reveal">Intelligent Products <span class="text-gradient">Ready to Deploy</span></h2>
            <p class="reveal">Pre-built AI capabilities we can configure and integrate into your existing systems in weeks, not months.</p>
        </div>
        <div class="ai-products-grid stagger-children">

            <div class="card reveal" id="ai-agents">
                <div class="icon-wrap"><?php echo hngs_icon('robot'); ?></div>
                <h3>AI Agents</h3>
                <p>Autonomous agents that reason, plan, and execute multi-step tasks — from customer service to back-office operations.</p>
            </div>

            <div class="card reveal" id="ai-automation">
                <div class="icon-wrap"><?php echo hngs_icon('cpu'); ?></div>
                <h3>AI Automation</h3>
                <p>Intelligent workflow automation that eliminates manual processes, reduces errors, and frees your team to focus on high-value work.</p>
            </div>

            <div class="card reveal" id="ai-chatbots">
                <div class="icon-wrap"><?php echo hngs_icon('message'); ?></div>
                <h3>AI Chatbots</h3>
                <p>Conversational AI trained on your business data — supports customers 24/7 across WhatsApp, web, and in-app channels.</p>
            </div>

            <div class="card reveal" id="ai-analytics">
                <div class="icon-wrap"><?php echo hngs_icon('trending-up'); ?></div>
                <h3>AI Analytics</h3>
                <p>Turn raw data into foresight. Predictive models and real-time dashboards that surface the insights that drive decisions.</p>
            </div>

        </div>
    </div>
</section>

<?php get_template_part('template-parts/process'); ?>

<?php get_template_part('template-parts/cta-strip'); ?>

<?php get_footer();
