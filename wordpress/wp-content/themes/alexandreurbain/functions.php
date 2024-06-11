<?php

function delete_post_link()
{
    $css_class = 'post-delete-link';
    $text = __('Delete');
    $url = get_delete_post_link();

    if (!$url) {
        return;
    }

    echo '<a class="' . esc_attr($css_class) . '" href="' . esc_url($url) . '">' . $text . '</a>';
}

function alexandreurbain_image_url($setting)
{
    $image = get_option($setting);
    return wp_get_attachment_image_src($image, 'full')[0];
}

add_filter('post_type_link', 'alexandreurbain_post_type_link', 10, 2);
function alexandreurbain_post_type_link($data, $post)
{
    if ("forms" != $post->post_type) {
        return $data;
    }

    $data = str_replace('/acf-slug/', '/', $data);

    return $data;
}

function alexandreurbain_parse_request($query)
{
    if (!empty($query->query['name'])) {
        $query->set('post_type', array('forms'));
    }
}
add_action('pre_get_posts', 'alexandreurbain_parse_request');

// -----------------------------
// -- List styles & scripts

function alexandreurbain_enqueue()
{
    $assetsDirectory = get_template_directory_uri() . '/assets/';
    $cssDirectory = $assetsDirectory . '/css/';
    $jsDirectory = $assetsDirectory . '/js/';

    $defaultCss = ['reset', 'variables', 'header', 'toggle', 'footer'];

    foreach($defaultCss as $css) {
        wp_enqueue_style($css, $cssDirectory . $css . '.css');
    }

    global $wp_query;
    $currentPostType = 'post-' . $wp_query->get_queried_object()->post_type;
    wp_enqueue_style($currentPostType, $cssDirectory . $currentPostType . '.css');

    wp_enqueue_script('cdn_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js');
    wp_enqueue_script('menu', $jsDirectory . 'menu.js', [], '1.0.0', ['strategy'  => 'defer']);
    wp_enqueue_script('cookie', $jsDirectory . 'cookie.js', [], '1.0.0', ['strategy'  => 'defer']);
    wp_enqueue_script('darker_mode', $jsDirectory . 'darker-mode.js', [], '1.0.0', ['strategy'  => 'defer']);
    wp_localize_script('darker_mode', 'favicon', array(
        'darker' => alexandreurbain_image_url('site_icon'),
        'lighter' => alexandreurbain_image_url('site_icon_lighter'),
    ));
}

add_action('wp_enqueue_scripts', 'alexandreurbain_enqueue');

function alexandreurbain_meta_title()
{
    $title = '';

    if (is_front_page()) {
        $title = get_bloginfo('name');
    } else {
        $title = the_title('', '', false) . ' | ' . get_bloginfo('name');
    }

    echo "<title>$title</title>";
}
add_action('wp_head', 'alexandreurbain_meta_title');

function alexandreurbain_meta_description()
{
    global $post;
    if (is_singular()) {
        $des_post = strip_tags($post->post_content);
        $des_post = strip_shortcodes($post->post_content);
        $des_post = str_replace(array("\n", "\r", "\t"), ' ', $des_post);
        $des_post = mb_substr($des_post, 0, 300, 'utf8');
        echo '<meta name="description" content="' . $des_post . '" />' . "\n";
    }
    if (is_front_page()) {
        echo '<meta name="description" content="' . get_bloginfo("description") . '" />' . "\n";
    }
    if (is_category()) {
        $des_cat = strip_tags(category_description());
        echo '<meta name="description" content="' . $des_cat . '" />' . "\n";
    }
}
add_action('wp_head', 'alexandreurbain_meta_description');


function alexandreurbain_body_class($classes)
{
    $classes[] = 'darker';
    return $classes;
}

add_filter('body_class', 'alexandreurbain_body_class');

// -----------------------------
// -- List all menu section

function register_my_menus()
{
    register_nav_menus(
        array(
            'main-menu' => __('Menu principal'),
            'language' => __('Langue'),
        )
    );
}
add_action('init', 'register_my_menus');

// -----------------------------
// -- Add field to General Options

function register_fields()
{
    register_setting('general', 'site_icon_lighter');
    add_settings_field('site_icon_lighter', '<label for="site_icon_lighter">' . __('Icône du site	clair', 'site_icon_lighter') . '</label>', 'print_setting_image', 'general', 'default', ['id' => 'site_icon_lighter']);
    register_setting('general', 'avatar');
    add_settings_field('avatar', '<label for="avatar">' . __('Avatar', 'avatar') . '</label>', 'print_setting_image', 'general', 'default', ['id' => 'avatar']);
}

function print_setting_image($attr)
{
    $id = $attr['id'];

    // Set variables
    $options = get_option($id);
    $default_image = get_template_directory_uri() . '/img/img_lazy.png';

    if (!empty($options)) {
        $image_attributes = wp_get_attachment_image_src($options, 'thumbnail');
        $src = $image_attributes[0];
        $value = $options;
    } else {
        $src = $default_image;
        $value = '';
    }
    $text = __('Upload', 'uploadplugin');
    echo '
        <div class="upload">
            <img data-src="' . $default_image . '" src="' . $src . '" height="150px" width="150px" />
            <div>
        <input type="hidden" name="' . $id . '" id="' . $id . '" value="' . $value . '" />
                <button type="submit" class="upload_image_button button">' . $text . '</button>
                <button type="submit" class="remove_image_button button">&times;</button>
            </div>
        </div>
    ';
?>
    <script>
        jQuery('.upload_image_button').click(function(e) {
            e.preventDefault;
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = jQuery(this);
            wp.media.editor.send.attachment = function(props, attachment) {
                jQuery(button).parent().prev().attr('src', attachment.url);
                jQuery(button).prev().val(attachment.id);
                wp.media.editor.send.attachment = send_attachment_bkp;
            }
            wp.media.editor.open(button);
            return false;
        });

        jQuery('.remove_image_button').click(function(e) {
            e.preventDefault;
            var answer = confirm('Are you sure?');
            if (answer == true) {
                var src = jQuery(this).parent().prev().attr('data-src');
                jQuery(this).parent().prev().attr('src', src);
                jQuery(this).prev().prev().val('');
            }
            return false;
        });
    </script>
<?php
}

add_filter('admin_init', 'register_fields');