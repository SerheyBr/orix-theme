<?php 
    //   Template name: шаблон Saill
    get_header(); 
    function render_filter_block($template, $taxonomy){
      $template_path = locate_template('templates/filters/'.$template.'.php');

      if(!$template_path){
        return;
      }

      $name_taxonomy = get_taxonomy($taxonomy);
      $name_taxonomy = $name_taxonomy->labels->singular_name;

      $terms = get_terms(array(
          'taxonomy' => $taxonomy,
          'hide_empty' => true,
      ));

       include $template_path;
    }
       
    $filters = array(
      array('template' => 'filter-variant-2', 'taxanomy' => 'pa_color'),
      array('template' => 'filter-variant-1', 'taxanomy' => 'pa_mechanism'),
      array('template' => 'filter-variant-1', 'taxanomy' => 'product_brand'),
      array('template' => 'filter-variant-1', 'taxanomy' => 'pa_sex'),
      array('template' => 'filter-variant-1', 'taxanomy' => 'pa_style'),
      array('template' => 'filter-variant-1', 'taxanomy' => 'pa_material'),
      array('template' => 'filter-variant-1', 'taxanomy' => 'pa_finishing'),

    );


 ?>

 <main class="catalog sail">
      <div class="container">
        <div class="breadcrumbs">
          <?php my_breadcrumbs();?>
        </div>

            <?php
              $arg = array(
                  'post_type' => 'product',
                  'posts_per_page' => '20',
                  'paged' => 1,
                  'meta_key'   => '_price',
                  'orderby' => 'date',
                  // 'orderby'    => 'meta_value_num', // сортировка как по числу
                  'order'      => 'DESC', //DESC | ASC
                  'tax_query' => array(
                    array(
                      'taxonomy' => 'product_cat',
                      'field' => 'slug',
                      'terms' => 'watch',
                    )
                    ),
                    'meta_query' => array(
                        array(
                            'key'     => '_sale_price',
                            'value'   => 0,
                            'compare' => '>',
                            'type'    => 'NUMERIC',
                        ),
                    ),
              );

              $query = new WP_Query($arg);
            ?>

            <?php if($query->have_posts()):?>

        <div class="catalog__wrapper">
          <div class="catalog__head--mobill">
            <div class="catalog__info">
              <h4 class="catalog__title title-section"><?php the_title() ;?></h4>
              <p class="catalog__subtitle"><?php echo $query->found_posts;?> товаров</p>
            </div>
            <div class="catalog__text-sort sort-container">
              <p class='sort-container__title'>Сортировать &nbsp;<b data-sort='3'>От новых к старым</b></p>
              <svg
                width="8"
                height="5"
                viewBox="0 0 8 5"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M3.64645 4.35355C3.84171 4.54882 4.15829 4.54882 4.35355 4.35355L7.53553 1.17157C7.7308 0.976311 7.7308 0.659728 7.53553 0.464466C7.34027 0.269204 7.02369 0.269204 6.82843 0.464466L4 3.29289L1.17157 0.464466C0.976311 0.269204 0.659728 0.269204 0.464466 0.464466C0.269204 0.659728 0.269204 0.976311 0.464466 1.17157L3.64645 4.35355ZM3.5 3L3.5 4L4.5 4L4.5 3L3.5 3Z"
                  fill="#6A6E71"
                />
              </svg>
              <ul class="catalog__menu-sort sort-container__list">
                <li data-sort='1'>От дешевых к дорогим</li>
                <li data-sort='2'>От дорогих к дешевым</li>
              </ul>
            </div>
          </div>
          <button class="catalog__button-triger-mobil-menu">
            Открыть Фильтры
            <svg
              width="9"
              height="5"
              viewBox="0 0 9 5"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M4.14645 4.85355C4.34171 5.04882 4.65829 5.04882 4.85355 4.85355L8.03553 1.67157C8.2308 1.47631 8.2308 1.15973 8.03553 0.964466C7.84027 0.769204 7.52369 0.769204 7.32843 0.964466L4.5 3.79289L1.67157 0.964466C1.47631 0.769204 1.15973 0.769204 0.964466 0.964466C0.769204 1.15973 0.769204 1.47631 0.964466 1.67157L4.14645 4.85355ZM4 3.5L4 4.5L5 4.5L5 3.5L4 3.5Z"
                fill="#232323"
              />
            </svg>
          </button>
          <div class="catalog__text-sort-mobil sort-container">
            <p class='sort-container__title'>Сортировать &nbsp;<b data-sort='3'>От новых к старым</b></p>
            <svg
              width="8"
              height="5"
              viewBox="0 0 8 5"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M3.64645 4.35355C3.84171 4.54882 4.15829 4.54882 4.35355 4.35355L7.53553 1.17157C7.7308 0.976311 7.7308 0.659728 7.53553 0.464466C7.34027 0.269204 7.02369 0.269204 6.82843 0.464466L4 3.29289L1.17157 0.464466C0.976311 0.269204 0.659728 0.269204 0.464466 0.464466C0.269204 0.659728 0.269204 0.976311 0.464466 1.17157L3.64645 4.35355ZM3.5 3L3.5 4L4.5 4L4.5 3L3.5 3Z"
                fill="#6A6E71"
              />
            </svg>
            <ul class="catalog__menu-sort sort-container__list">
              <li data-sort='1'>От дешевых к дорогим</li>
              <li data-sort='2'>От дорогих к дешевым</li>
            </ul>
          </div>
          <aside class="sidebar">
            <div class="sidebar__wrapper">
              <button class="sidebar__btn-close">
                <svg
                  width="14"
                  height="14"
                  viewBox="0 0 14 14"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <g opacity="0.8">
                    <path
                      d="M1 12.3137L12.3137 1.00001"
                      stroke="white"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                    <path
                      d="M12.3145 12.3137L1.00074 1.00001"
                      stroke="white"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </g>
                </svg>
              </button>
              <div class="sidebar__body">
                <form class="sidebar__filters">
                  <?php
                    get_template_part('templates/filters/price-filter'); 
                    foreach($filters as $filter){
                      render_filter_block($filter['template'], $filter['taxanomy']);
                    }
              
                  ?>
                  <button class="sidebar-filter__reset">
                    <svg
                      width="9"
                      height="8"
                      viewBox="0 0 9 8"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M1 7.49954L7.99954 0.5M8 7.49977L1.00046 0.50023"
                        stroke="#2C2C2C"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    Сбросить все фильтры
                  </button>
            </form>
              </div>
            </div>
          </aside>

          <div class="catalog-content">
            <div class="catalog-content__head">
              <div class="catalog-content__info">
                <h4 class="catalog-content__title title-section"><?php the_title();?></h4> 
                <p class="catalog-content__subtitle"><?php echo $query->found_posts;?> товаров</p>
              </div>
              <div class="catalog-content__text-sort sort-container">
                <p class='sort-container__title'>Сортировать &nbsp;<b data-sort='3'>От новых к старым</b></p>
                <svg
                  width="8"
                  height="5"
                  viewBox="0 0 8 5"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M3.64645 4.35355C3.84171 4.54882 4.15829 4.54882 4.35355 4.35355L7.53553 1.17157C7.7308 0.976311 7.7308 0.659728 7.53553 0.464466C7.34027 0.269204 7.02369 0.269204 6.82843 0.464466L4 3.29289L1.17157 0.464466C0.976311 0.269204 0.659728 0.269204 0.464466 0.464466C0.269204 0.659728 0.269204 0.976311 0.464466 1.17157L3.64645 4.35355ZM3.5 3L3.5 4L4.5 4L4.5 3L3.5 3Z"
                    fill="#6A6E71"
                  />
                </svg>
                <ul class="catalog-content__menu-sort sort-container__list">
                  <li data-sort='1'>От дешевых к дорогим</li>
                  <li data-sort='2'>От дорогих к дешевым</li>
                </ul>
              </div>
            </div>
            <!-- <ul class="catalog-content__tags">
              <li class="catalog-content__tag">
                <div class="catalog-content__tag-text">
                  <span>название атрибута</span>: <span>выбранный атрибут</span>
                </div>
                <button>&#x2716;</button>
              </li>
            </ul> -->
            <div class="catalog-content__body">
              <div class="catalog-content__grid">
                <?php while($query->have_posts()): $query->the_post()?>
                      <?php get_template_part('templates/card-variant-1');?>
                    <?php endwhile;?>
                  <?php endif;?>
                  <?php  wp_reset_postdata();;?>
              </div>

              <div id=pagination>
               <?php
                  $total_pages_value = $query->max_num_pages;
                  
                  include 'templates/pagination.php' ;
                ?>
              </div>
              </div> 
            
            </div>
          </div>
        </div>
      </div>
    </main>

    <div class="laoding">
      <div class="laoding__gif">
        <img src="https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExOXFka3lrODYyNDgyZG9sMWIxeGszNDMxaGs4eGFkOHhhZjU4M2hudSZlcD12MV9zdGlja2Vyc19zZWFyY2gmY3Q9cw/5AtXMjjrTMwvK/giphy.gif" alt="">
      </div>
    </div>



<?php get_footer();?>