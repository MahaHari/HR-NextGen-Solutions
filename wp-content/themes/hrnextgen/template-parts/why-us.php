<?php
/**
 * Template Part: Why Choose Us Section
 */

$features = [
    [
        'num'   => '01',
        'icon'  => 'ai',
        'title' => 'AI-First Approach',
        'desc'  => 'Every solution we build considers how AI can reduce manual effort, improve accuracy, and create competitive advantages — from day one.',
    ],
    [
        'num'   => '02',
        'icon'  => 'server',
        'title' => 'Enterprise Architecture',
        'desc'  => 'Our systems are designed to handle enterprise workloads — secure, scalable infrastructure built to last years, not months.',
    ],
    [
        'num'   => '03',
        'icon'  => 'zap',
        'title' => 'Rapid Development',
        'desc'  => 'Agile sprints, rapid prototyping, and continuous delivery mean you see working software faster without sacrificing quality.',
    ],
    [
        'num'   => '04',
        'icon'  => 'layers',
        'title' => 'Scalable Solutions',
        'desc'  => 'From startup MVP to enterprise platform — our architectures scale horizontally and vertically to match your growth trajectory.',
    ],
    [
        'num'   => '05',
        'icon'  => 'users',
        'title' => 'Dedicated Support',
        'desc'  => 'You get a dedicated team, not a ticket queue. Direct access to engineers who understand your business and your code.',
    ],
    [
        'num'   => '06',
        'icon'  => 'shield',
        'title' => 'Security & Compliance',
        'desc'  => 'GDPR, HIPAA, SOC 2 — we build security into the architecture, not as an afterthought, with compliance-ready codebases.',
    ],
];
?>

<section class="section why-us" id="why-us" aria-label="Why Choose Us">

    <!-- Grid background pattern -->
    <div class="why-us-bg" aria-hidden="true"></div>

    <div class="container why-us-content">

        <div class="section-header">
            <span class="section-label">Our Difference</span>
            <h2>Why Leading Companies <span class="text-gradient">Choose Us</span></h2>
            <p>We combine the agility of a startup with the discipline of an enterprise software firm — delivering technology that actually works in the real world.</p>
        </div>

        <div class="features-grid stagger-children">
            <?php foreach ($features as $feat): ?>
            <div class="feature-block reveal">
                <span class="feature-number"><?php echo esc_html($feat['num']); ?></span>
                <h3><?php echo esc_html($feat['title']); ?></h3>
                <p><?php echo esc_html($feat['desc']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
