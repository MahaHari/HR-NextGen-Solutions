<?php
/**
 * Template Name: Industries
 */
get_header();

$contact_url = '';
$contact_page = get_page_by_path('contact');
if ($contact_page) $contact_url = get_permalink($contact_page->ID);
if (!$contact_url) $contact_url = home_url('/contact/');

$industries = [
    [
        'id'      => 'healthcare',
        'icon'    => 'heart',
        'title'   => 'Healthcare',
        'stat'    => '65% faster patient throughput',
        'desc'    => 'From patient management systems and telemedicine platforms to AI-powered diagnostic tools — we build technology that improves care outcomes and operational efficiency.',
        'items'   => ['Patient Management Systems','Telehealth Platforms','AI Diagnostics','Clinical Workflow Automation','Health Data Analytics'],
    ],
    [
        'id'      => 'logistics',
        'icon'    => 'truck',
        'title'   => 'Logistics &amp; Supply Chain',
        'stat'    => '$2.4M average cost savings',
        'desc'    => 'End-to-end supply chain visibility, route optimisation, and warehouse automation systems that reduce costs and eliminate bottlenecks at scale.',
        'items'   => ['Fleet Management','Route Optimisation AI','Warehouse Automation','Real-Time Tracking','Supply Chain Analytics'],
    ],
    [
        'id'      => 'real-estate',
        'icon'    => 'home',
        'title'   => 'Real Estate',
        'stat'    => '3x increase in qualified leads',
        'desc'    => 'Proptech platforms that transform how properties are discovered, bought, sold, and managed — powered by AI property intelligence.',
        'items'   => ['Property Listing Platforms','CRM & Lead Management','Virtual Tour Technology','AI Valuation Models','Investment Analytics'],
    ],
    [
        'id'      => 'retail',
        'icon'    => 'shopping',
        'title'   => 'Retail &amp; E-Commerce',
        'stat'    => '40% uplift in conversion rate',
        'desc'    => 'From personalised shopping experiences to intelligent inventory management — we help retailers compete in the age of AI-driven commerce.',
        'items'   => ['E-Commerce Platforms','Inventory AI','Personalisation Engines','Loyalty Programs','Omnichannel POS'],
    ],
    [
        'id'      => 'restaurants',
        'icon'    => 'globe',
        'title'   => 'Food &amp; Restaurants',
        'stat'    => '28% reduction in order errors',
        'desc'    => 'Digital-first restaurant operations: smart ordering, kitchen automation, delivery routing, and customer loyalty systems all in one ecosystem.',
        'items'   => ['Online Ordering Systems','Kitchen Display Systems','Delivery Route AI','Reservation Management','Menu Analytics'],
    ],
    [
        'id'      => 'salons',
        'icon'    => 'scissors',
        'title'   => 'Beauty &amp; Salons',
        'stat'    => '80% reduction in no-shows',
        'desc'    => 'Appointment platforms and client management tools designed for the beauty industry — smart scheduling, automated reminders, and loyalty rewards.',
        'items'   => ['Online Booking Systems','Staff Scheduling','Client Profiles & History','Automated Reminders','Revenue Analytics'],
    ],
    [
        'id'      => 'education',
        'icon'    => 'book',
        'title'   => 'Education &amp; EdTech',
        'stat'    => '55% improvement in engagement',
        'desc'    => 'Learning management systems, adaptive AI tutors, and engagement platforms that make education more accessible and measurably more effective.',
        'items'   => ['LMS Development','Adaptive Learning AI','Virtual Classrooms','Assessment Platforms','Student Analytics'],
    ],
    [
        'id'      => 'finance',
        'icon'    => 'dollar',
        'title'   => 'Finance &amp; FinTech',
        'stat'    => '99.9% uptime on transaction systems',
        'desc'    => 'Secure, scalable financial platforms with built-in compliance — from payments and lending to wealth management and fraud detection.',
        'items'   => ['Payment Processing','Fraud Detection AI','Lending Platforms','Wealth Management Tools','Regulatory Compliance'],
    ],
];
?>

<!-- Page Hero -->
<section class="page-hero text-center">
    <div class="container container--narrow">
        <nav class="breadcrumb" style="justify-content:center;" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
            <span class="breadcrumb-sep" aria-hidden="true">/</span>
            <span aria-current="page">Industries</span>
        </nav>
        <div class="section-label reveal">
            <span class="section-label-dot"></span>
            Sector Expertise
        </div>
        <h1 class="reveal">Deep Expertise Across <span class="text-gradient">20+ Industries</span></h1>
        <p class="reveal">We don't just build generic software — we understand the regulatory, operational, and competitive context of your industry so the solutions we build actually fit.</p>
    </div>
</section>

<!-- Industries Grid -->
<section class="section">
    <div class="container">
        <?php foreach ($industries as $ind): ?>
        <div class="industry-detail-row reveal" id="<?php echo esc_attr($ind['id']); ?>">
            <div class="industry-detail-icon">
                <div class="icon-wrap icon-wrap--lg icon-wrap--circle">
                    <?php echo hngs_icon($ind['icon']); ?>
                </div>
            </div>
            <div class="industry-detail-body">
                <div class="industry-detail-header">
                    <h2><?php echo $ind['title']; ?></h2>
                    <span class="badge badge-primary"><?php echo esc_html($ind['stat']); ?></span>
                </div>
                <p><?php echo esc_html($ind['desc']); ?></p>
                <ul class="industry-feature-list">
                    <?php foreach ($ind['items'] as $item): ?>
                    <li><?php echo hngs_icon('check'); ?> <?php echo esc_html($item); ?></li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?php echo esc_url($contact_url); ?>" class="btn btn-link">
                    Discuss Your Project <?php echo hngs_icon('arrow-right'); ?>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<?php get_template_part('template-parts/cta-strip'); ?>

<?php get_footer();
