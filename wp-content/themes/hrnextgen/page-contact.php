<?php
/**
 * Template Name: Contact Us
 */
get_header();
?>

<!-- Page Hero -->
<section class="page-hero text-center">
    <div class="container container--narrow">
        <nav class="breadcrumb" style="justify-content:center;" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
            <span class="breadcrumb-sep" aria-hidden="true">/</span>
            <span aria-current="page">Contact Us</span>
        </nav>
        <div class="section-label reveal">
            <span class="section-label-dot"></span>
            Let's Connect
        </div>
        <h1 class="reveal">Start Your <span class="text-gradient">Project Today</span></h1>
        <p class="reveal">We respond to every inquiry within 1–2 business days with a tailored approach and honest, transparent pricing.</p>
    </div>
</section>

<?php get_template_part('template-parts/contact'); ?>

<?php get_footer();
