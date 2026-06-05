<?php
/**
 * Template Name: About Us
 */
get_header();

$stats = [];
for ($i = 1; $i <= 4; $i++) {
    $defaults = [1=>['50+','Projects Delivered'],2=>['5+','Years of Excellence'],3=>['98%','Client Satisfaction'],4=>['20+','Industries Served']];
    $stats[] = [
        'value' => hngs_get_option("hngs_stat_{$i}_value", $defaults[$i][0]),
        'label' => hngs_get_option("hngs_stat_{$i}_label", $defaults[$i][1]),
    ];
}

$contact_url = '';
$contact_page = get_page_by_path('contact');
if ($contact_page) $contact_url = get_permalink($contact_page->ID);
if (!$contact_url) $contact_url = home_url('/contact/');
?>

<!-- Page Hero -->
<section class="page-hero text-center">
    <div class="container container--narrow">
        <nav class="breadcrumb" style="justify-content:center;" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
            <span class="breadcrumb-sep" aria-hidden="true">/</span>
            <span aria-current="page">About Us</span>
        </nav>
        <div class="section-label reveal">
            <span class="section-label-dot"></span>
            Our Story
        </div>
        <h1 class="reveal">We Build the Future <span class="text-gradient">One Line at a Time</span></h1>
        <p class="reveal">A passionate team of engineers, designers, and AI researchers on a mission to bring intelligent software to every business.</p>
    </div>
</section>

<!-- Intro / Mission -->
<section class="section">
    <div class="container">
        <div class="about-intro-grid">
            <div class="about-intro-content">
                <div class="section-label reveal">
                    <span class="section-label-dot"></span>
                    Who We Are
                </div>
                <h2 class="reveal">Turning Complex Challenges into <span class="text-gradient">Simple Solutions</span></h2>
                <p class="reveal">Founded with a single belief — that every business, regardless of size, deserves access to powerful, intelligent technology — HR NextGen Solutions has grown into a full-service AI and software engineering firm trusted by companies across 20+ industries.</p>
                <p class="reveal">Our multidisciplinary team combines deep expertise in AI, mobile development, cloud architecture, and UX design to deliver end-to-end digital products that actually move the needle.</p>
                <div class="btn-group reveal" style="margin-top:var(--space-8);">
                    <a href="<?php echo esc_url($contact_url); ?>" class="btn btn-primary btn-lg">
                        Work With Us <?php echo hngs_icon('arrow-right'); ?>
                    </a>
                </div>
            </div>
            <div class="about-intro-visual reveal--right">
                <div class="about-visual-card">
                    <div class="about-visual-inner">
                        <div class="about-visual-accent" aria-hidden="true"></div>
                        <div class="about-badges">
                            <div class="about-badge">
                                <?php echo hngs_icon('shield'); ?>
                                <span>ISO 27001 Aligned</span>
                            </div>
                            <div class="about-badge">
                                <?php echo hngs_icon('zap'); ?>
                                <span>Agile Certified</span>
                            </div>
                            <div class="about-badge">
                                <?php echo hngs_icon('globe'); ?>
                                <span>Global Delivery</span>
                            </div>
                            <div class="about-badge">
                                <?php echo hngs_icon('ai'); ?>
                                <span>AI-Native Team</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="section section--alt">
    <div class="container">
        <div class="about-stats-grid stagger-children">
            <?php foreach ($stats as $stat): ?>
            <div class="stat-block reveal">
                <span class="stat-value" data-target="<?php echo esc_attr($stat['value']); ?>">
                    <?php echo esc_html($stat['value']); ?>
                </span>
                <span class="stat-label"><?php echo esc_html($stat['label']); ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Values -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-label reveal">
                <span class="section-label-dot"></span>
                What Drives Us
            </div>
            <h2 class="reveal">Our Core <span class="text-gradient">Values</span></h2>
            <p class="reveal">Everything we build is guided by principles that put our clients and their users first.</p>
        </div>
        <div class="features-grid stagger-children">
            <div class="card card--feature reveal">
                <div class="icon-wrap"><?php echo hngs_icon('zap'); ?></div>
                <h3>Innovation First</h3>
                <p>We constantly explore emerging technologies so you don't have to — then apply them pragmatically to solve real problems.</p>
            </div>
            <div class="card card--feature reveal">
                <div class="icon-wrap"><?php echo hngs_icon('shield'); ?></div>
                <h3>Quality Without Compromise</h3>
                <p>Rigorous code reviews, automated testing, and performance benchmarking are baked into every project, not bolted on at the end.</p>
            </div>
            <div class="card card--feature reveal">
                <div class="icon-wrap"><?php echo hngs_icon('globe'); ?></div>
                <h3>Radical Transparency</h3>
                <p>No black boxes. You have full visibility into progress, timelines, and technical decisions at every stage of the build.</p>
            </div>
            <div class="card card--feature reveal">
                <div class="icon-wrap"><?php echo hngs_icon('heart'); ?></div>
                <h3>Client Partnership</h3>
                <p>We treat every engagement as a long-term partnership. Your success is our success — and we measure ourselves accordingly.</p>
            </div>
            <div class="card card--feature reveal">
                <div class="icon-wrap"><?php echo hngs_icon('cpu'); ?></div>
                <h3>AI-Native Thinking</h3>
                <p>AI isn't a feature we layer on — it's the lens through which we design every product architecture and user experience.</p>
            </div>
            <div class="card card--feature reveal">
                <div class="icon-wrap"><?php echo hngs_icon('trending-up'); ?></div>
                <h3>Results Obsessed</h3>
                <p>Elegant code means nothing without measurable outcomes. We define success metrics at the start and hold ourselves accountable.</p>
            </div>
        </div>
    </div>
</section>

<!-- Team -->
<section class="section section--alt">
    <div class="container">
        <div class="section-header">
            <div class="section-label reveal">
                <span class="section-label-dot"></span>
                The People Behind the Work
            </div>
            <h2 class="reveal">Meet Our <span class="text-gradient">Leadership Team</span></h2>
            <p class="reveal">Experienced engineers and strategists who've built products used by millions.</p>
        </div>
        <div class="team-grid stagger-children">

            <div class="team-card reveal">
                <div class="team-avatar">
                    <span>AK</span>
                </div>
                <h4>Arjun Kapoor</h4>
                <p class="team-role">CEO &amp; Co-Founder</p>
                <p class="team-bio">15 years in enterprise software. Previously VP Engineering at a Fortune 500 fintech. Passionate about AI-driven product strategy.</p>
                <div class="team-social">
                    <a href="#" aria-label="LinkedIn"><?php echo hngs_icon('linkedin'); ?></a>
                    <a href="#" aria-label="Twitter"><?php echo hngs_icon('twitter'); ?></a>
                </div>
            </div>

            <div class="team-card reveal">
                <div class="team-avatar">
                    <span>PS</span>
                </div>
                <h4>Priya Sharma</h4>
                <p class="team-role">CTO &amp; Co-Founder</p>
                <p class="team-bio">AI/ML researcher turned engineering leader. Led machine learning infrastructure at two unicorn startups before co-founding HRNS.</p>
                <div class="team-social">
                    <a href="#" aria-label="LinkedIn"><?php echo hngs_icon('linkedin'); ?></a>
                    <a href="#" aria-label="GitHub"><?php echo hngs_icon('github'); ?></a>
                </div>
            </div>

            <div class="team-card reveal">
                <div class="team-avatar">
                    <span>MR</span>
                </div>
                <h4>Mohammed Rafi</h4>
                <p class="team-role">Head of Product</p>
                <p class="team-bio">Product visionary with deep expertise in UX research and systems design. Obsessed with building products that feel inevitable.</p>
                <div class="team-social">
                    <a href="#" aria-label="LinkedIn"><?php echo hngs_icon('linkedin'); ?></a>
                </div>
            </div>

            <div class="team-card reveal">
                <div class="team-avatar">
                    <span>SC</span>
                </div>
                <h4>Sofia Chen</h4>
                <p class="team-role">Head of AI Engineering</p>
                <p class="team-bio">PhD in Computational Linguistics. Leads our NLP and conversational AI practice. Published author on large language model applications.</p>
                <div class="team-social">
                    <a href="#" aria-label="LinkedIn"><?php echo hngs_icon('linkedin'); ?></a>
                    <a href="#" aria-label="GitHub"><?php echo hngs_icon('github'); ?></a>
                </div>
            </div>

        </div>
    </div>
</section>

<?php get_template_part('template-parts/cta-strip'); ?>

<?php get_footer();
