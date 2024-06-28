<?php
/* Template Name: Modèle pour listes */
/* Template Post Type: list */
?>

<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php // edit_post_link(); ?>
        <?php // delete_post_link(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php
                $post_type = get_field('post_type');
                $posts = get_posts(['post_type' => get_field('post_type')]);
            ?>
            <?php foreach ($posts as $post) : ?>
                <div class="list-item <?php echo $post_type; ?>">
                    <img class="list-item-image" src="<?php echo get_field('image')['url'] ?>" alt="">
                    <h2 class="list-item-title"><?php echo $post->post_title; ?></h2>
                    <div class="list-item-description">
                        <?php echo get_field('content'); ?>
                        <a class="list-item-link" href="<?php echo get_post_permalink($post->ID); ?>">En savoir plus</a>
                    </div>
                </div>
            <?php endforeach ?>
        </article>
<?php endwhile;
endif; ?>
<?php get_footer(); ?>