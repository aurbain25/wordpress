<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width">
    <?php wp_head(); ?>

    <style>
        html {
            --logo-url: url(<?php echo alexandreurbain_image_url('site_icon') ?>);
        }
    </style>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header>
        <img class="header__background" src="/wp-content/themes/alexandreurbain/assets/images/background-user.png" alt="Background User"/>

        <div class="header__nav">
            <a href="/" class="header__logo"></a>
            <div class="header__nav__mobile"></div>

            <?php wp_nav_menu(array('theme_location' => 'main-menu')); ?>
            <?php wp_nav_menu(array('theme_location' => 'language')); ?>

            <div class="contrast">
                <label class="switch switch-darker">
                    <input type="checkbox">
                    <span class="slider"></span>
                </label>
            </div>
        </div>
        <div class="page__title">
            <img class="page__title__image" src="<?php echo alexandreurbain_image_url('avatar') ?>" alt="">
            <div class="page__title__text">
                <h1>
                    <span><?php the_title(); ?></span>
                    <span><?php bloginfo('name'); ?></span>
                </h1>
                <div class="slogan"><?php bloginfo('description'); ?></div>
            </div>
        </div>
    </header>