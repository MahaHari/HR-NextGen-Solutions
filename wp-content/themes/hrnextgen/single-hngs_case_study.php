<?php
/**
 * Single Case Study Template
 */
get_header();
?>

<?php while ( have_posts() ): the_post();
    $industry   = get_post_meta(get_the_ID(), '_hngs_client_industry', true);
    $problem    = get_post_meta(get_the_ID(), '_hngs_problem', true);
    $solution   = get_post_meta(get_the_ID(), '_hngs_solution', true);
    $techs_raw  = get_post_meta(get_the_ID(), '_hngs_technologies', true);
    $techs      = $techs_raw ? array_map('trim', explode(',', $techs_raw)) : [];
    $results    = [];
    for ($i = 1; $i <= 3; $i++) {
        $val   = get_post_meta(get_the_ID(), "_hngs_result_{$i}_value", true);
        $label = get_post_meta(get_the_ID(), "_hngs_result_{$i}_label", true);
        if ($val && $label) $results[] = ['value' => $val, 'label' => $label];
    }
?>

<!-- Case Study Hero -->
<section class="section" style="padding-top:calc(var(--header-height) + var(--space-16));padding-bottom:var(--space-16);background:var(--bg-section-alt);">
    <div class="container" style="max-width:900px;">
        <?php if ($industry): ?>
        <span class="badge badge-primary" style="margin-bottom:var(--space-5);display:inline-block;"><?php echo esc_html($industry); ?></span>
        <?php endif; ?>
        <h1 style="font-size:clamp(1.75rem,4vw,2.75rem);margin-bottom:var(--space-6);"><?php the_title(); ?></h1>

        <?php if (!empty($results)): ?>
        <div style="display:grid;grid-template-columns:repeat(<?php echo count($results); ?>,1fr);gap:var(--space-4);margin-top:var(--space-8);">
            <?php foreach ($results as $result): ?>
            <div class="card" style="text-align:center;padding:var(--space-6);">
                <div class="result-metric__value" style="font-size:var(--text-4xl);"><?php echo esc_html($result['value']); ?></div>
                <div class="result-metric__label"><?php echo esc_html($result['label']); ?></div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Case Study Body -->
<section class="section">
    <div class="container" style="max-width:900px;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-10);margin-bottom:var(--space-12);">
            <?php if ($problem): ?>
            <div>
                <h2 style="font-size:var(--text-2xl);margin-bottom:var(--space-4);">The Challenge</h2>
                <p style="color:var(--text-muted);line-height:var(--leading-relaxed);"><?php echo esc_html($problem); ?></p>
            </div>
            <?php endif; ?>
            <?php if ($solution): ?>
            <div>
                <h2 style="font-size:var(--text-2xl);margin-bottom:var(--space-4);">Our Solution</h2>
                <p style="color:var(--text-muted);line-height:var(--leading-relaxed);"><?php echo esc_html($solution); ?></p>
            </div>
            <?php endif; ?>
        </div>

        <?php if (get_the_content()): ?>
        <div class="entry-content" style="color:var(--text-secondary);line-height:var(--leading-relaxed);max-width:700px;">
            <?php the_content(); ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($techs)): ?>
        <div style="margin-top:var(--space-10);">
            <h3 style="margin-bottom:var(--space-4);">Technologies Used</h3>
            <div class="tech-tags">
                <?php foreach ($techs as $tech): ?>
                <span class="tech-tag"><?php echo esc_html($tech); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div style="margin-top:var(--space-12);padding-top:var(--space-8);border-top:1px solid var(--border-subtle);display:flex;gap:var(--space-4);flex-wrap:wrap;">
            <a href="#contact" class="btn btn-primary btn-lg">
                Start a Similar Project
                <?php echo hngs_icon('arrow-right'); ?>
            </a>
            <a href="<?php echo esc_url(get_post_type_archive_link('hngs_case_study')); ?>" class="btn btn-ghost-gradient">
                ← All Case Studies
            </a>
        </div>
    </div>
</section>

<?php endwhile; ?>

<?php get_footer(); ?>
