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


// хлебные крошки
function my_breadcrumbs() {

    // не выводим на главной
    if ( is_front_page() ) return;

    echo '<nav class="breadcrumbs__content">';
    echo '<a href="' . home_url() . '">Главная</a>';

    if ( is_category() || is_single() ) {
        $category = get_the_category();
        if ( $category ) {
            $cat_link = get_category_link( $category[0]->term_id );
            echo ' / <a href="' . $cat_link . '">' . $category[0]->name . '</a>';
        }
        if ( is_single() ) {
            echo ' / ' . get_the_title();
        }
    } elseif ( is_page() ) {
        global $post;
        if ( $post->post_parent ) {
            $parent_id   = $post->post_parent;
            $breadcrumbs = array();
            while ( $parent_id ) {
                $page = get_post($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ( $breadcrumbs as $crumb ) {
                echo ' / ' . $crumb;
            }
        }
        echo ' / ' . get_the_title();
    } elseif ( is_search() ) {
        echo ' / Результаты поиска по запросу "' . get_search_query() . '"';
    } elseif ( is_404() ) {
        echo ' / Ошибка 404';
    } elseif ( is_archive() ) {
        echo ' / Архив: ' . post_type_archive_title('', false);
    }

    echo '</nav>';
}


// ajax обработчик
function my_filter_products() {
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $arg = array(
        'post_type' => 'product',
        'posts_per_page' => '5',
        'paged' => $paged,
    );

    $tax_query = array(
        'relation' => 'AND',
    );

    $colors = isset($_GET['pa_color']) ? $_GET['pa_color'] : [];

    if(!empty($colors)){
        $tax_query[] = array(
            'taxonomy' => 'pa_color',
            'field'    => 'slug',
            'terms'    => $colors, // несколько терминов одной таксономии
            'operator' => 'IN',
        );

        $arg['tax_query'] = $tax_query;
    }

    $brands = isset($_GET['product_brand']) ? $_GET['product_brand'] : [];

        if(!empty($brands)){
        $tax_query[] = array(
            'taxonomy' => 'product_brand',
            'field'    => 'slug',
            'terms'    => $brands, // несколько терминов одной таксономии
            'operator' => 'IN',
        );

        $arg['tax_query'] = $tax_query;
    }

     $mechanism = isset($_GET['pa_mechanism']) ? $_GET['pa_mechanism'] : [];

        if(!empty($mechanism)){
        $tax_query[] = array(
            'taxonomy' => 'pa_mechanism',
            'field'    => 'slug',
            'terms'    => $mechanism, // несколько терминов одной таксономии
            'operator' => 'IN',
        );

        $arg['tax_query'] = $tax_query;
    }


    $min_price = isset($_GET['min_price']) ? intval($_GET['min_price']) : 0;
    $max_price = isset($_GET['max_price']) ? intval($_GET['max_price']) : 0;

    if ($min_price > 0 || $max_price > 0) {
        $range = ['key' => '_price', 'type' => 'NUMERIC'];

        if ($min_price > 0 && $max_price > 0) {
            $range['value']   = [$min_price, $max_price];
            $range['compare'] = 'BETWEEN';
        } elseif ($min_price > 0) {
            $range['value']   = $min_price;
            $range['compare'] = '>=';
        } elseif ($max_price > 0) {
            $range['value']   = $max_price;
            $range['compare'] = '<=';
        }

        $arg['meta_query'][] = $range;
    }
    // echo '<pre>';
    // print_r( $_GET);
    // echo '</pre>'; 
   
  

    $query = new WP_Query($arg);
//   1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
  ob_start();
    if($query->have_posts()){
        while($query->have_posts()){
            $query->the_post();
            get_template_part('templates/card-variant-1');
        }
    }else{
        echo 'товары не найдены';
    }

    wp_reset_postdata();
    $render_posts = ob_get_clean();
//   1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111

    // 2222222222222222222222222222222222222222222222222222222222222222222222222222222 
     ob_start();               
    $total_pages = $query->max_num_pages;

    if ($total_pages > 1) {

        // Стрелка "назад"
        if ($paged > 1) {
            echo '<div class="catalog-content__pagination-arrow">
                    <a href="' . get_pagenum_link($paged - 1) . '">
                        <svg width="23" height="10" viewBox="0 0 23 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.54038 4.54038C0.286539 4.79422 0.286539 5.20578 0.54038 5.45962L4.67695 9.59619C4.9308 9.85003 5.34235 9.85003 5.59619 9.59619C5.85003 9.34235 5.85003 8.9308 5.59619 8.67696L1.91924 5L5.59619 1.32304C5.85003 1.0692 5.85003 0.657647 5.59619 0.403806C5.34235 0.149965 4.9308 0.149965 4.67695 0.403806L0.54038 4.54038ZM23 4.35L1 4.35V5.65L23 5.65V4.35Z" fill="black"/>
                        </svg>
                    </a>
                </div>';
        }

        // Номера страниц
        echo '<div class="catalog-content__pagination-numbers">';
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $paged) {
                echo '<span class="current">' . $i . '</span>';
            } else {
                echo '<a href="' . get_pagenum_link($i) . '">' . $i . '</a>';
            }
        }
        echo '</div>';

        // Стрелка "вперед"
        if ($paged < $total_pages) {
            echo '<div class="catalog-content__pagination-arrow">
                    <a href="' . get_pagenum_link($paged + 1) . '">
                        <svg width="23" height="10" viewBox="0 0 23 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.323 9.59624L22.4596 5.45967C22.7135 5.20583 22.7135 4.79427 22.4596 4.54043L18.323 0.403852C18.0692 0.150011 17.6576 0.150011 17.4038 0.403852C17.15 0.657693 17.15 1.06925 17.4038 1.32309L20.4308 4.35005L0 4.35005L0 5.65005L20.4308 5.65005L17.4038 8.677C17.15 8.93084 17.15 9.3424 17.4038 9.59624C17.6576 9.85008 18.0692 9.85008 18.323 9.59624Z" fill="#121214"/>
                        </svg>
                    </a>
                </div>';
        }
    }
    $render_pagination = ob_get_clean();          
    // 2222222222222222222222222222222222222222222222222222222222222222222222222222222

    $result = $query->found_posts;
   
    wp_send_json([
    'posts' => $render_posts,
    'pagination' =>  $render_pagination,
    'resultNum' => $result,
    ]);

    wp_die(); // обязательно, чтобы завершить AJAX-запрос
}

add_action('wp_ajax_my_filter_products', 'my_filter_products');
add_action('wp_ajax_nopriv_my_filter_products', 'my_filter_products');
