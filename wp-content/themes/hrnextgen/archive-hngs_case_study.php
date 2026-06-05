<?php
/**
 * Case Studies Archive
 */
get_header();

$contact_url = '';
$contact_page = get_page_by_path('contact');
if ($contact_page) $contact_url = get_permalink($contact_page->ID);
if (!$contact_url) $contact_url = home_url('/contact/');

$fallback_cases = [
    [
        'industry'   => 'Healthcare',
        'badge_icon' => 'heart',
        'title'      => 'AI Triage Platform for Regional Hospital Network',
        'solution'   => 'Built a machine-learning triage system that analyses patient vitals, history, and symptoms in real time to prioritise care — reducing average wait times by 65%.',
        'tech'       => ['Python','TensorFlow','FastAPI','React Native','AWS'],
        'results'    => [['65%','Faster Patient Throughput'],['$1.8M','Annual Cost Reduction'],['92%','Triage Accuracy Rate']],
    ],
    [
        'industry'   => 'Logistics',
        'badge_icon' => 'truck',
        'title'      => 'Smart Fleet & Route Optimisation for Nationwide 3PL',
        'solution'   => 'Developed a real-time fleet management platform with AI-driven route optimisation, dynamic load balancing, and predictive maintenance alerts that saved $2.4M in the first year.',
        'tech'       => ['Node.js','PostgreSQL','Mapbox API','React','GCP'],
        'results'    => [['$2.4M','First-Year Savings'],['31%','Fuel Cost Reduction'],['4.9/5','Driver App Rating']],
    ],
    [
        'industry'   => 'Real Estate',
        'badge_icon' => 'home',
        'title'      => 'AI-Powered Proptech Portal with Smart Valuation Engine',
        'solution'   => 'Created a full-stack property marketplace with an ML valuation model trained on 10 years of transaction data, cutting manual appraisal time by 80% and tripling qualified lead conversion.',
        'tech'       => ['Next.js','Python','scikit-learn','PostgreSQL','Stripe'],
        'results'    => [['3x','Lead Conversion Rate'],['80%','Faster Valuations'],['50K+','Active Monthly Users']],
    ],
    [
        'industry'   => 'Retail',
        'badge_icon' => 'shopping',
        'title'      => 'Personalised E-Commerce Engine for Fashion Brand',
        'solution'   => 'Replaced a legacy e-commerce stack with a headless architecture featuring an AI recommendation engine, resulting in a 40% uplift in conversion and 28% higher average order value.',
        'tech'       => ['React','Shopify API','Node.js','Elasticsearch','Redis'],
        'results'    => [['40%','Conversion Uplift'],['28%','Higher AOV'],['60%','Reduced Page Load Time']],
    ],
    [
        'industry'   => 'Education',
        'badge_icon' => 'book',
        'title'      => 'Adaptive Learning Platform for K-12 EdTech Startup',
        'solution'   => 'Designed and built a personalised learning management system with AI-driven content sequencing that adapts to each student\'s pace, improving completion rates by 55%.',
        'tech'       => ['Vue.js','Django','PostgreSQL','WebRTC','AWS'],
        'results'    => [['55%','Engagement Improvement'],['2.1M','Lessons Delivered'],['4.8/5','Student Satisfaction']],
    ],
    [
        'industry'   => 'Finance',
        'badge_icon' => 'dollar',
        'title'      => 'Real-Time Fraud Detection for Digital Lending Platform',
        'solution'   => 'Built a real-time fraud detection microservice using ensemble ML models that reduced fraudulent loan applications by 94% while maintaining a sub-200ms decision latency.',
        'tech'       => ['Python','XGBoost','Kafka','FastAPI','Kubernetes'],
        'results'    => [['94%','Fraud Reduction'],['<200ms','Decision Latency'],['$4.2M','Losses Prevented']],
    ],
];
?>

<!-- Page Hero -->
<section class="page-hero text-center">
    <div class="container container--narrow">
        <nav class="breadcrumb" style="justify-content:center;" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
            <span class="breadcrumb-sep" aria-hidden="true">/</span>
            <span aria-current="page">Case Studies</span>
        </nav>
        <div class="section-label reveal">
            <span class="section-label-dot"></span>
            Proven Results
        </div>
        <h1 class="reveal">Work That <span class="text-gradient">Speaks for Itself</span></h1>
        <p class="reveal">Real projects, real numbers, real impact. Explore how we've helped businesses across industries unlock new levels of performance with AI and intelligent software.</p>
    </div>
</section>

<!-- Case Studies -->
<section class="section">
    <div class="container">

        <?php
        $cs_query = new WP_Query([
            'post_type'      => 'hngs_case_study',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'post_status'    => 'publish',
        ]);

        if ($cs_query->have_posts()):
            while ($cs_query->have_posts()): $cs_query->the_post();
                $industry   = get_post_meta(get_the_ID(), '_hngs_client_industry', true);
                $solution   = get_post_meta(get_the_ID(), '_hngs_solution', true);
                $tech_raw   = get_post_meta(get_the_ID(), '_hngs_technologies', true);
                $tech_tags  = $tech_raw ? array_map('trim', explode(',', $tech_raw)) : [];
                $results = [];
                for ($r = 1; $r <= 3; $r++) {
                    $rv = get_post_meta(get_the_ID(), "_hngs_result_{$r}_value", true);
                    $rl = get_post_meta(get_the_ID(), "_hngs_result_{$r}_label", true);
                    if ($rv && $rl) $results[] = [$rv, $rl];
                }
        ?>
        <article class="case-study-full-row reveal" aria-label="<?php the_title_attribute(); ?>">
            <div class="case-study-full-header">
                <?php if ($industry): ?>
                <span class="badge badge-primary"><?php echo esc_html($industry); ?></span>
                <?php endif; ?>
                <h2><?php the_title(); ?></h2>
            </div>
            <div class="case-study-full-body">
                <div class="case-study-full-solution">
                    <h4>The Solution</h4>
                    <p><?php echo esc_html($solution ?: wp_trim_words(get_the_content(), 50)); ?></p>
                    <?php if (!empty($tech_tags)): ?>
                    <div class="tech-tags" style="margin-top:var(--space-4);">
                        <?php foreach ($tech_tags as $tag): ?>
                        <span class="tech-tag"><?php echo esc_html($tag); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($results)): ?>
                <div class="case-study-results">
                    <?php foreach ($results as $res): ?>
                    <div class="result-metric">
                        <span class="result-metric__value"><?php echo esc_html($res[0]); ?></span>
                        <span class="result-metric__label"><?php echo esc_html($res[1]); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <a href="<?php echo esc_url($contact_url); ?>" class="btn btn-link case-study-cta">
                Start a Similar Project <?php echo hngs_icon('arrow-right'); ?>
            </a>
        </article>
        <?php endwhile; wp_reset_postdata();

        else:
            foreach ($fallback_cases as $case): ?>
        <article class="case-study-full-row reveal" aria-label="<?php echo esc_attr($case['title']); ?>">
            <div class="case-study-full-header">
                <span class="badge badge-primary"><?php echo esc_html($case['industry']); ?></span>
                <h2><?php echo esc_html($case['title']); ?></h2>
            </div>
            <div class="case-study-full-body">
                <div class="case-study-full-solution">
                    <h4>The Solution</h4>
                    <p><?php echo esc_html($case['solution']); ?></p>
                    <div class="tech-tags" style="margin-top:var(--space-4);">
                        <?php foreach ($case['tech'] as $tag): ?>
                        <span class="tech-tag"><?php echo esc_html($tag); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="case-study-results">
                    <?php foreach ($case['results'] as $res): ?>
                    <div class="result-metric">
                        <span class="result-metric__value"><?php echo esc_html($res[0]); ?></span>
                        <span class="result-metric__label"><?php echo esc_html($res[1]); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <a href="<?php echo esc_url($contact_url); ?>" class="btn btn-link case-study-cta">
                Start a Similar Project <?php echo hngs_icon('arrow-right'); ?>
            </a>
        </article>
        <?php endforeach; endif; ?>

    </div>
</section>

<?php get_template_part('template-parts/cta-strip'); ?>

<?php get_footer();
