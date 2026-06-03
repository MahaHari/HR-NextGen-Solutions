<?php get_header(); ?>

<section class="section" style="min-height:70vh;display:flex;align-items:center;">
    <div class="container" style="text-align:center;">
        <div style="font-size:120px;font-weight:900;background:var(--gradient-brand);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;margin-bottom:var(--space-6);">404</div>
        <h1 style="margin-bottom:var(--space-4);">Page Not Found</h1>
        <p style="color:var(--text-muted);font-size:var(--text-xl);max-width:500px;margin:0 auto var(--space-10);">
            The page you're looking for doesn't exist or has been moved.
        </p>
        <div class="btn-group" style="justify-content:center;">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary btn-lg">
                Go Back Home
                <?php echo hngs_icon('arrow-right'); ?>
            </a>
            <a href="#contact" class="btn btn-ghost-gradient btn-lg">Contact Us</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
