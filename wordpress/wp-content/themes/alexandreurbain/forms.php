<?php
/* Template Name: Modèle pour formulaires */
/* Template Post Type: forms */
?>

<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php edit_post_link(); ?>
        <?php delete_post_link(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="post__content">
                <?php echo get_field('content'); ?>
            </div>
            <div class="post__form">
                <?php echo get_field('form'); ?>
            </div>
        </article>
<?php endwhile;
endif; ?>
<?php get_footer(); ?>