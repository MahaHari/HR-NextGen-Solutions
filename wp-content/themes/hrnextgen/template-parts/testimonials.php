<?php
/**
 * Template Part: Testimonials Section
 */

$default_testimonials = [
    [
        'name'    => 'Dr. Sarah Mitchell',
        'title'   => 'Chief Medical Officer',
        'company' => 'HealthFirst Medical Group',
        'rating'  => 5,
        'quote'   => 'HR NextGen Solutions transformed how we handle patient intake. Their AI system didn\'t just solve our wait time problem — it gave us data insights we never had before. Absolutely exceptional engineering team.',
        'initials'=> 'SM',
    ],
    [
        'name'    => 'James Okonkwo',
        'title'   => 'VP of Operations',
        'company' => 'SwiftMove Logistics',
        'rating'  => 5,
        'quote'   => 'The route optimization platform they built pays for itself every month. We went from dreading fuel cost reports to actually looking forward to them. The AI recommendations get better every week.',
        'initials'=> 'JO',
    ],
    [
        'name'    => 'Priya Sharma',
        'title'   => 'CEO & Co-Founder',
        'company' => 'UrbanNest Properties',
        'rating'  => 5,
        'quote'   => 'Our AI sales assistant now handles 80% of initial inquiries with zero intervention from our team. Our conversion rate tripled within 90 days of launch. The ROI has been extraordinary.',
        'initials'=> 'PS',
    ],
    [
        'name'    => 'Marcus Chen',
        'title'   => 'Founder',
        'company' => 'RetailEdge Commerce',
        'rating'  => 5,
        'quote'   => 'What truly impressed me was their deep understanding of our business goals, not just the technical requirements. They built us a platform that actually thinks about our customers the same way we do.',
        'initials'=> 'MC',
    ],
];

$test_query = new WP_Query([
    'post_type'      => 'hngs_testimonial',
    'posts_per_page' => 10,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
]);

$testimonials = [];

if ($test_query->have_posts()) {
    while ($test_query->have_posts()): $test_query->the_post();
        $testimonials[] = [
            'name'    => get_the_title(),
            'title'   => get_post_meta(get_the_ID(), '_hngs_client_title', true),
            'company' => get_post_meta(get_the_ID(), '_hngs_company_name', true),
            'rating'  => (int)(get_post_meta(get_the_ID(), '_hngs_rating', true) ?: 5),
            'quote'   => strip_tags(get_the_content()),
            'avatar'  => get_the_post_thumbnail_url(get_the_ID(), 'hngs-avatar'),
            'initials'=> strtoupper(substr(get_the_title(),0,2)),
        ];
    endwhile;
    wp_reset_postdata();
} else {
    $testimonials = $default_testimonials;
}

function hngs_render_stars($rating) {
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        $filled = $i <= $rating ? 'fill="currentColor"' : 'fill="none"';
        $stars .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" width="18" height="18" style="color:var(--color-primary);" ' . $filled . '><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
    }
    return '<div class="star-rating" aria-label="' . $rating . ' out of 5 stars">' . $stars . '</div>';
}
?>

<section class="section testimonials" id="testimonials" aria-label="Client Testimonials">
    <div class="container">

        <div class="section-header">
            <span class="section-label">Testimonials</span>
            <h2>What Our <span class="text-gradient">Clients Say</span></h2>
            <p>Don't take our word for it — hear directly from the businesses we've transformed.</p>
        </div>

        <div class="testimonials-slider-wrapper">
            <div class="testimonials-track" id="testimonials-track" role="list">
                <?php foreach ($testimonials as $test): ?>
                <div class="testimonial-slide" role="listitem">
                    <div class="testimonial-card">
                        <span class="quote-mark" aria-hidden="true">&ldquo;</span>
                        <blockquote class="testimonial-quote">
                            <?php echo esc_html($test['quote']); ?>
                        </blockquote>
                        <div class="testimonial-author">
                            <div class="author-avatar" aria-hidden="true">
                                <?php if (!empty($test['avatar'])): ?>
                                <img src="<?php echo esc_url($test['avatar']); ?>"
                                     alt="<?php echo esc_attr($test['name']); ?>"
                                     loading="lazy">
                                <?php else: ?>
                                <div class="author-avatar-placeholder"><?php echo esc_html($test['initials']); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="author-info">
                                <?php echo hngs_render_stars($test['rating']); ?>
                                <div class="author-name"><?php echo esc_html($test['name']); ?></div>
                                <div class="author-title"><?php echo esc_html($test['title']); ?><?php if (!empty($test['company'])): ?> · <?php echo esc_html($test['company']); ?><?php endif; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Slider Controls -->
        <div class="slider-controls">
            <button class="slider-arrow" id="slider-prev" aria-label="Previous testimonial">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <div class="slider-dots" id="slider-dots" role="tablist" aria-label="Testimonial navigation">
                <?php foreach ($testimonials as $i => $test): ?>
                <button class="slider-dot <?php echo $i === 0 ? 'active' : ''; ?>"
                        data-index="<?php echo $i; ?>"
                        role="tab"
                        aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                        aria-label="Testimonial <?php echo $i + 1; ?>"></button>
                <?php endforeach; ?>
            </div>
            <button class="slider-arrow" id="slider-next" aria-label="Next testimonial">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>

    </div>
</section>
