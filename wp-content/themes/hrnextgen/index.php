<?php get_header(); ?>

<section class="section" style="min-height:60vh;">
    <div class="container">
        <?php if ( have_posts() ): ?>
        <?php while ( have_posts() ): the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h1><?php the_title(); ?></h1>
            <div class="entry-content" style="color:var(--text-secondary);line-height:var(--leading-relaxed);">
                <?php the_content(); ?>
            </div>
        </article>
        <?php endwhile; ?>
        <?php else: ?>
        <h2>No content found.</h2>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
