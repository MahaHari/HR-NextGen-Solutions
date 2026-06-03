<?php
/**
 * Template Part: Process Section
 */

$steps = [
    ['num'=>'01','title'=>'Discover',  'desc'=>'We dive deep into your business — understanding your goals, users, pain points, and existing systems before a single line is written.'],
    ['num'=>'02','title'=>'Plan',      'desc'=>'We architect the full solution: technical stack, project milestones, resource allocation, and a clear roadmap with measurable checkpoints.'],
    ['num'=>'03','title'=>'Design',    'desc'=>'UI/UX prototyping, design system creation, and user-tested wireframes — building the experience before building the software.'],
    ['num'=>'04','title'=>'Develop',   'desc'=>'Agile sprints with weekly deliverables. Clean code, code reviews, unit tests, and continuous integration from day one.'],
    ['num'=>'05','title'=>'Deploy',    'desc'=>'CI/CD pipelines, automated testing, staged rollouts, and zero-downtime deployments — shipping with confidence.'],
    ['num'=>'06','title'=>'Scale',     'desc'=>'Post-launch monitoring, performance optimization, feature iterations, and continuous improvement as your business grows.'],
];
?>

<section class="section process" id="process" aria-label="Our Process">
    <div class="container">

        <div class="section-header">
            <span class="section-label">How We Work</span>
            <h2>How We <span class="text-gradient">Deliver Excellence</span></h2>
            <p>A proven six-phase methodology that delivers on time, on budget, and beyond expectations — every time.</p>
        </div>

        <!-- Desktop Process Timeline -->
        <div class="process-desktop" aria-hidden="false">
            <div class="process-steps" id="process-steps">
                <!-- Animated connecting line -->
                <div class="process-line-fill" id="process-line-fill"></div>

                <?php foreach ($steps as $i => $step): ?>
                <div class="process-step" data-step="<?php echo $i; ?>">
                    <div class="process-step-badge"><?php echo esc_html($step['num']); ?></div>
                    <h4><?php echo esc_html($step['title']); ?></h4>
                    <p><?php echo esc_html($step['desc']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Mobile Process Accordion -->
        <div class="process-mobile" aria-label="Process steps">
            <?php foreach ($steps as $i => $step): ?>
            <div class="process-accordion-item" id="process-step-<?php echo $i; ?>">
                <div class="process-accordion-header" role="button" aria-expanded="false" tabindex="0">
                    <div class="process-step-badge" style="width:40px;height:40px;font-size:var(--text-base);">
                        <?php echo esc_html($step['num']); ?>
                    </div>
                    <h4 style="margin:0;"><?php echo esc_html($step['title']); ?></h4>
                    <span class="process-accordion-chevron">
                        <?php echo hngs_icon('arrow-down'); ?>
                    </span>
                </div>
                <div class="process-accordion-body">
                    <p><?php echo esc_html($step['desc']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align:center;margin-top:var(--space-12);">
            <a href="#contact" class="btn btn-primary btn-lg">
                Start Your Project
                <?php echo hngs_icon('arrow-right'); ?>
            </a>
        </div>

    </div>
</section>
