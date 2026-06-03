<?php
/**
 * Template Part: Case Studies Section
 */

$default_case_studies = [
    [
        'industry'  => 'Healthcare',
        'title'     => 'AI-Powered Patient Intake System Reduces Wait Times by 65%',
        'problem'   => 'A regional hospital network was drowning in paper-based patient intake forms, causing 45-minute average wait times and frequent data entry errors.',
        'solution'  => 'We built an end-to-end AI intake platform with voice data collection, smart form completion, and real-time EHR integration — deployed across 12 clinic locations.',
        'techs'     => ['React Native', 'Node.js', 'OpenAI GPT-4', 'HL7 FHIR', 'AWS'],
        'results'   => [['65%','Wait Time Reduction'],['99.2%','Data Accuracy'],['12','Locations Deployed']],
    ],
    [
        'industry'  => 'Logistics',
        'title'     => 'Real-Time AI Route Optimizer Saves $2.4M Annually in Fuel Costs',
        'problem'   => 'A mid-sized logistics company was losing significant margin to inefficient routing, with drivers spending 20% of time on suboptimal routes.',
        'solution'  => 'We developed an ML-powered route optimization engine with live traffic integration, vehicle capacity AI, and driver performance analytics.',
        'techs'     => ['Python', 'TensorFlow', 'Google Maps API', 'PostgreSQL', 'Flutter'],
        'results'   => [['$2.4M','Annual Savings'],['34%','Fuel Efficiency'],['98%','On-Time Delivery']],
    ],
    [
        'industry'  => 'Real Estate',
        'title'     => 'Conversational AI Platform Triples Lead Conversion for Property Developer',
        'problem'   => 'A fast-growing property developer was losing leads overnight — no response capacity after business hours meant 60% of inquiries went cold.',
        'solution'  => 'We built an AI sales assistant that handles property inquiries 24/7, books viewings, qualifies buyers, and hands warm leads to human agents at the right moment.',
        'techs'     => ['GPT-4 Turbo', 'WhatsApp API', 'Twilio', 'Laravel', 'MySQL'],
        'results'   => [['3x','Lead Conversion'],['24/7','Availability'],['82%','Auto-Qualified Leads']],
    ],
];

$cs_query = new WP_Query([
    'post_type'      => 'hngs_case_study',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post_status'    => 'publish',
]);

$use_fallback = ! $cs_query->have_posts();
?>

<section class="section section--dark" id="case-studies" aria-label="Case Studies">
    <div class="container">

        <div class="section-header">
            <span class="section-label">Proven Results</span>
            <h2>Real Problems. <span class="text-gradient">Intelligent Solutions.</span> Measurable Results.</h2>
            <p>We don't just deliver code — we deliver outcomes. Here's what happens when AI-first thinking meets serious engineering.</p>
        </div>

        <div class="case-studies-grid stagger-children">
            <?php if ($use_fallback): ?>
                <?php foreach ($default_case_studies as $cs): ?>
                <div class="card case-study-card reveal">
                    <div class="card-body">
                        <div class="case-study-industry">
                            <span class="badge badge-primary"><?php echo esc_html($cs['industry']); ?></span>
                        </div>
                        <h3><?php echo esc_html($cs['title']); ?></h3>
                        <p><?php echo esc_html($cs['solution']); ?></p>
                        <div class="tech-tags">
                            <?php foreach ($cs['techs'] as $tech): ?>
                            <span class="tech-tag"><?php echo esc_html($tech); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="case-study-results">
                            <?php foreach ($cs['results'] as $result): ?>
                            <div class="result-metric">
                                <div class="result-metric__value"><?php echo esc_html($result[0]); ?></div>
                                <div class="result-metric__label"><?php echo esc_html($result[1]); ?></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <?php while ($cs_query->have_posts()): $cs_query->the_post();
                    $industry   = get_post_meta(get_the_ID(), '_hngs_client_industry', true);
                    $solution   = get_post_meta(get_the_ID(), '_hngs_solution', true);
                    $techs_raw  = get_post_meta(get_the_ID(), '_hngs_technologies', true);
                    $techs      = $techs_raw ? array_map('trim', explode(',', $techs_raw)) : [];
                    $results    = [];
                    for ($i = 1; $i <= 3; $i++) {
                        $val   = get_post_meta(get_the_ID(), "_hngs_result_{$i}_value", true);
                        $label = get_post_meta(get_the_ID(), "_hngs_result_{$i}_label", true);
                        if ($val && $label) $results[] = [$val, $label];
                    }
                ?>
                <div class="card case-study-card reveal">
                    <div class="card-body">
                        <?php if ($industry): ?>
                        <div class="case-study-industry">
                            <span class="badge badge-primary"><?php echo esc_html($industry); ?></span>
                        </div>
                        <?php endif; ?>
                        <h3><?php the_title(); ?></h3>
                        <?php if ($solution): ?>
                        <p><?php echo esc_html(wp_trim_words($solution, 30, '…')); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($techs)): ?>
                        <div class="tech-tags">
                            <?php foreach (array_slice($techs, 0, 5) as $tech): ?>
                            <span class="tech-tag"><?php echo esc_html($tech); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($results)): ?>
                        <div class="case-study-results">
                            <?php foreach ($results as $result): ?>
                            <div class="result-metric">
                                <div class="result-metric__value"><?php echo esc_html($result[0]); ?></div>
                                <div class="result-metric__label"><?php echo esc_html($result[1]); ?></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="case-study-footer">
                        <a href="<?php the_permalink(); ?>" class="case-study-link">
                            Read Full Case Study
                            <?php echo hngs_icon('arrow-right'); ?>
                        </a>
                    </div>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>

        <div style="text-align:center;margin-top:var(--space-10);">
            <?php
            $cs_archive = get_post_type_archive_link('hngs_case_study');
            if ($cs_archive): ?>
            <a href="<?php echo esc_url($cs_archive); ?>" class="btn btn-ghost-gradient btn-lg">
                View All Case Studies
                <?php echo hngs_icon('arrow-right'); ?>
            </a>
            <?php endif; ?>
        </div>

    </div>
</section>
