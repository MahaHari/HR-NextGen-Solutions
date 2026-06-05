<?php
/**
 * Template Part: CTA Strip
 */
$contact_url = '';
$contact_page = get_page_by_path('contact');
if ($contact_page) $contact_url = get_permalink($contact_page->ID);
if (!$contact_url) $contact_url = home_url('/contact/');
?>

<section class="cta-strip section--sm" aria-label="Call to Action">
    <div class="container">
        <h2 class="reveal">Ready to Build Something <span class="text-gradient" style="-webkit-text-fill-color:inherit;color:#fff;">Extraordinary?</span></h2>
        <p class="reveal">Let's talk about your vision. Our team of AI engineers and software architects is ready to turn your ideas into reality.</p>
        <div class="btn-group reveal" style="justify-content:center;">
            <a href="<?php echo esc_url($contact_url); ?>" class="btn btn-ghost-white btn-xl">
                Start Your Project
                <?php echo hngs_icon('arrow-right'); ?>
            </a>
        </div>
    </div>
</section>
