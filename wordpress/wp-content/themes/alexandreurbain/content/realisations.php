<?php
/* Template Name: Modèle pour realisation */
/* Template Post Type: realisation */
?>

<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php // edit_post_link(); ?>
        <?php // delete_post_link(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <img class="image" src="<?php echo get_field('image')['url'] ?>" alt="">
            <div class="content">
                <h2 class="title"><?php echo $post->post_title; ?></h2>
                <div class="description">
                    <?php echo get_field('content'); ?>
                </div>
            </div>
        </article>
<?php endwhile;
endif; ?>
<?php get_footer(); ?>