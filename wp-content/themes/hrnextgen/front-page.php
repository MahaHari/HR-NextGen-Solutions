<?php
/**
 * Front Page Template
 * Assembles all homepage sections
 */
get_header(); ?>

<?php get_template_part('template-parts/hero'); ?>
<?php get_template_part('template-parts/trusted-by'); ?>
<?php get_template_part('template-parts/services'); ?>
<?php get_template_part('template-parts/ai-focus'); ?>
<?php get_template_part('template-parts/industries'); ?>
<?php get_template_part('template-parts/why-us'); ?>
<?php get_template_part('template-parts/case-studies'); ?>
<?php get_template_part('template-parts/process'); ?>
<?php get_template_part('template-parts/testimonials'); ?>
<?php get_template_part('template-parts/vision'); ?>
<?php get_template_part('template-parts/contact'); ?>

<?php get_footer(); ?>
