<?php
// Подключаем стили родителя и дочерние стили
function my_scripts() {

    wp_enqueue_script(
        'nouislider-js',
        get_stylesheet_directory_uri() . '/assets/libs/nouislider/nouislider.min.js',
        array(), // зависимости, если нужны
        '0.0.0.1',
        true // загрузка в футере
    );

    wp_enqueue_script(
        'slimselect-js',
        get_stylesheet_directory_uri() . '/assets/libs/slim-select/slimselect.min.js',
        array(), // зависимости, если нужны
        '0.0.0.1',
        true // загрузка в футере
    );

    wp_enqueue_script(
        'swiper-js',
        get_stylesheet_directory_uri() . '/assets/libs/swiper/swiper-bundle.min.js',
        array(), // зависимости, если нужны
        '0.0.0.1',
        true // загрузка в футере
    );

    wp_enqueue_script(
        'main-js',
        get_stylesheet_directory_uri() . '/js/main.js',
        array(), // зависимости, если нужны
        '0.0.0.1',
        true // загрузка в футере
    );

    wp_enqueue_script(
        'shop-filter',
        get_stylesheet_directory_uri() . '/js/shop-filter.js',
        array(), // зависимости, если нужны
        '0.0.0.1',
        true // загрузка в футере
    );

    wp_enqueue_style('theme-style', get_stylesheet_uri());
    wp_enqueue_style('fonts-1', 'https://fonts.googleapis.com');
    wp_enqueue_style('fonts-2', 'https://fonts.gstatic.com');
    wp_enqueue_style('fonts-3', 'https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap');
    wp_enqueue_style('nouislider', get_template_directory_uri() . '/assets/libs/nouislider/nouislider.min.css', [], '0.0.0.1');
    wp_enqueue_style('slimselect', get_template_directory_uri() . '/assets/libs/slim-select/slimselect.css', [], '0.0.0.1');
    wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/libs/swiper/swiper-bundle.min.css', [], '0.0.0.1');
    wp_enqueue_style('main-style', get_template_directory_uri() . '/css/style.css', [], '0.0.0.1');
    wp_enqueue_style('wp-styles', get_template_directory_uri() . '/css/wp_styles.css', [], '0.0.0.1');


      wp_localize_script('shop-filter', 'myShopFilters', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);
}
add_action('wp_enqueue_scripts', 'my_scripts');

function mytheme_add_woocommerce_support() {
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'mytheme_add_woocommerce_support');


// Вывести все post type + их таксономии + термины
add_action( 'admin_menu', function() {
    add_menu_page( 'WP Data Explorer', 'WP Data Explorer', 'manage_options', 'wp-data-explorer', function() {
        
        $post_types = get_post_types( array(), 'objects' );

        foreach ( $post_types as $post_type ) {
            echo '<h2>Post type: ' . $post_type->label . ' (' . $post_type->name . ')</h2>';

            $taxonomies = get_object_taxonomies( $post_type->name, 'objects' );
            if ( $taxonomies ) {
                foreach ( $taxonomies as $taxonomy ) {
                    echo '<h3>Таксономия: ' . $taxonomy->label . ' (' . $taxonomy->name . ')</h3>';

                    $terms = get_terms( array(
                        'taxonomy'   => $taxonomy->name,
                        'hide_empty' => false,
                    ) );

                    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                        echo '<ul>';
                        foreach ( $terms as $term ) {
                            echo '<li>' . $term->name . ' (slug: ' . $term->slug . ')</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<p>Нет терминов</p>';
                    }
                }
            } else {
                echo '<p>Таксономий нет</p>';
            }
        }
    });
});


// ajax обработчик

