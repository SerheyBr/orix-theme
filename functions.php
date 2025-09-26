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
    $paged = $_GET['page'] ? $_GET['page'] : 1;
    $sort_variant = $_GET['sort'] ? $_GET['sort'] : 3;
    $category = $_GET['category'] ? $_GET['category'] : 'watch';
    $is_sail = $_GET['sail'] ? $_GET['sail'] : false;

  function myshop_add_tax_filter($tax_name, $arg){
    $filter = isset($_GET[$tax_name]) ? (array) $_GET[$tax_name] : [];

    if(!empty($filter)){
        $arg['tax_query'][] = array(
            'taxonomy' => $tax_name,
            'field'    => 'slug',
            'terms'    => $filter,
            'operator' => 'IN',
        );
    }
    return $arg;
}


    // $sort_param = array(
    //     'meta_key' => '_price',
    //     'orderby' => 'date',
    //     // 'orderby'    => 'meta_value_num', // сортировка как по числу
    //     'order' => 'DESC', //DESC | ASC
    // )

    $sort_param = array(
        'meta_key' => '_price',
        'orderby' => 'date',
        // 'orderby'    => 'meta_value_num', // сортировка как по числу
        'order' => 'DESC', //DESC | ASC
    );


   switch ( $sort_variant ) {
    case 1:
        $sort_param['orderby'] = 'meta_value_num';
        $sort_param['order']   = 'ASC';
        break;

    case 2:
        $sort_param['orderby'] = 'meta_value_num';
        $sort_param['order']   = 'DESC';
        break;

    default:
         $sort_param;
        break;
}

    $arg = array(
        'post_type' => 'product',
        'posts_per_page' => '20',
        'paged' => $paged,
    );

    $arg = array_merge( $arg, $sort_param );
    // $tax_query = array(
    //     'relation' => 'AND',
    // );

 if ($category) {
        $arg['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }


    $arg = myshop_add_tax_filter('pa_color', $arg);
    $arg = myshop_add_tax_filter('product_brand', $arg);
    $arg = myshop_add_tax_filter('pa_mechanism', $arg);
    $arg = myshop_add_tax_filter('pa_sex', $arg);
    $arg = myshop_add_tax_filter('pa_style', $arg);
    $arg = myshop_add_tax_filter('pa_material', $arg);
    $arg = myshop_add_tax_filter('pa_finishing', $arg);
    $arg = myshop_add_tax_filter('pa_strap_color', $arg);
    $arg = myshop_add_tax_filter('pa_strap_length', $arg);
    $arg = myshop_add_tax_filter('pa_strap_width', $arg);


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


    if($is_sail){
         $arg['meta_query'][] = array(
            'key'     => '_sale_price',
            'value'   => 0,
            'compare' => '>',
            'type'    => 'NUMERIC',
        );
    }

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

// 222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222
    $sort_container = array(
        'title' => "Сортировать &nbsp;<b data-sort='3'>От новых к старым</b>",
        'list' => "<li data-sort='1'>От дешевых к дорогим</li>
            <li data-sort='2'>От дорогих к дешевым</li>",
    );

    switch ( $sort_variant ) {
    case 1:
        $sort_container['title'] = "Сортировать &nbsp;<b data-sort='1'>От дешевых к дорогим</b>";
        $sort_container['list'] = "<li data-sort='3'>От новых к старым</li>
            <li data-sort='2'>От дорогих к дешевым</li>";
        break;

    case 2:
        $sort_container['title'] = "Сортировать &nbsp;<b data-sort='2'>От дорогих к дешевым</b>";
        $sort_container['list'] = "<li data-sort='3'>От новых к старым</li>
            <li data-sort='1'>От дешевых к дорогим</li>";
        break;

    default:
        $sort_container['title'] = "Сортировать &nbsp;<b data-sort='3'>От новых к старым</b>";
        $sort_container['list'] = "<li data-sort='1'>От дешевых к дорогим</li>
            <li data-sort='2'>От дорогих к дешевым</li>";
        break;
    }
     
// 222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222

    // 333333333333333333333333333333333333333333333333333333333333333333333333333333333333
    ob_start();

    $total_pages_value = $query->max_num_pages;
    $num_page = $paged;             
    include 'templates/pagination.php' ;

    $render_pagination_2 = ob_get_clean(); 
    // 33333333333333333333333333333333333333333333333333333333333333333333333333333333333333

    $result = $query->found_posts;
   
    global $_GET;
    
    wp_send_json([
        'posts' => $render_posts,
        'resultNum' => $result,
        'paginationNew' =>  $render_pagination_2,
        'sortContent' => $sort_container,
        'get' => $_GET,
        'sail' =>  $is_sail,
        'arg' => $arg,
    ]);

    wp_die(); // обязательно, чтобы завершить AJAX-запрос
}

add_action('wp_ajax_my_filter_products', 'my_filter_products');
add_action('wp_ajax_nopriv_my_filter_products', 'my_filter_products');
