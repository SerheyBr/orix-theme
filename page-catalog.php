 <?php 
    //   Template name: шаблон Каталога
    get_header(); 
    
       

        function my_get_wc_terms($taxonomy) {
            $terms = get_terms(array(
                'taxonomy' => $taxonomy,
                'hide_empty' => true,
            ));

            if(!empty($terms) && !is_wp_error($terms)) {
                foreach($terms as $term) {

                    if($taxonomy === 'product_brand' || $taxonomy === 'pa_mechanism'){
                        echo '<label>';
                        echo '<input type="checkbox" name="'.$taxonomy.'[]" value="'.esc_attr($term->slug).'"> ';
                        echo esc_html($term->name);
                        echo '</label><br>';
                    }elseif($taxonomy === 'pa_color'){
                        $colors = array(
                            'красный' => 'red',
                            'белый' => 'white',
                            'желтый' => 'yellow',
                            'зеленый' => 'green',
                            'синик' => 'blue',
                            'черный' => 'black',    
                        );
                        $color = $colors[$term->name] ?? '';
                        echo '<label class="label-filter-color">';
                        echo '<input type="checkbox" name="'.$taxonomy.'[]" value="'.esc_attr($term->slug).'"> ';
                        echo '<div class="sidebar-filter__color">';
                        echo '<div class="sidebar-filter__color-exemple" style="background-color:'.$color.'"></div>';
                        echo '<p>'.$term->name.'</p>';
                        echo '</div>';
                        echo '</label>';
                    }elseif($taxonomy === 'pa_sex'){
                        
                    }else{
                        echo '<label>';
                        echo '<input type="checkbox" name="'.$taxonomy.'[]" value="'.esc_attr($term->slug).'"> ';
                        echo esc_html($term->name);
                        echo '</label><br>';
                    }
                
                }
            }
        }
 ?>

 <main class="catalog">
      <div class="container">
        <div class="breadcrumbs">
          <!-- <p class="breadcrumbs__content">Главная / Каталог товаров / Обувь</p> -->
          <?php my_breadcrumbs();?>
        </div>

            <?php
              $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
              $arg = array(
                  'post_type' => 'product',
                  'posts_per_page' => '5',
                  'paged' => $paged,
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
            <div class="catalog__text-sort">
              <p>Сортировать по &nbsp;<b>От дешевых к дорогим</b></p>
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
              <ul class="catalog__menu-sort">
                <li>От дешевых к дорогим</li>
                <li>От новых к старым</li>
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
          <div class="catalog__text-sort-mobil">
            <p>Сортировать по &nbsp;<b>От дешевых к дорогим</b></p>
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
            <ul class="catalog__menu-sort">
              <li>От дешевых к дорогим</li>
              <li>От новых к старым</li>
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
                  <!-- <div class="sidebar__filter sidebar-filter">
                    <div class="sidebar-filter__header">
                      <h4 class="sidebar__title title-filter-category">
                        Категории
                      </h4>
                      <svg
                        width="8"
                        height="5"
                        viewBox="0 0 8 5"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M3.64645 0.146447C3.84171 -0.0488155 4.15829 -0.0488155 4.35355 0.146447L7.53553 3.32843C7.7308 3.52369 7.7308 3.84027 7.53553 4.03553C7.34027 4.2308 7.02369 4.2308 6.82843 4.03553L4 1.20711L1.17157 4.03553C0.976311 4.2308 0.659728 4.2308 0.464466 4.03553C0.269204 3.84027 0.269204 3.52369 0.464466 3.32843L3.64645 0.146447ZM4 1.5L3.5 1.5L3.5 0.5L4 0.5L4.5 0.5L4.5 1.5L4 1.5Z"
                          fill="#232323"
                        />
                      </svg>
                    </div>
                    <div class="sidebar-filter__body">
                      <ul class="sidebar-filter__list">
                        <li><a href="#">Кроссовки </a></li>
                        <li><a href="#">Кеды </a></li>
                        <li><a href="#">Лофферы </a></li>
                        <li><a href="#">Сандали </a></li>
                        <li><a href="#">Шлепки </a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="sidebar__filter sidebar-filter">
                    <div class="sidebar-filter__header">
                      <h4 class="sidebar__title title-filter-category">
                        Категории
                      </h4>
                      <svg
                        width="8"
                        height="5"
                        viewBox="0 0 8 5"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M3.64645 0.146447C3.84171 -0.0488155 4.15829 -0.0488155 4.35355 0.146447L7.53553 3.32843C7.7308 3.52369 7.7308 3.84027 7.53553 4.03553C7.34027 4.2308 7.02369 4.2308 6.82843 4.03553L4 1.20711L1.17157 4.03553C0.976311 4.2308 0.659728 4.2308 0.464466 4.03553C0.269204 3.84027 0.269204 3.52369 0.464466 3.32843L3.64645 0.146447ZM4 1.5L3.5 1.5L3.5 0.5L4 0.5L4.5 0.5L4.5 1.5L4 1.5Z"
                          fill="#232323"
                        />
                      </svg>
                    </div>
                    <div class="sidebar-filter__body">
                      <ul class="sidebar-filter__list">
                        <li><a href="#">Кроссовки </a></li>
                        <li><a href="#">Кеды </a></li>
                        <li><a href="#">Лофферы </a></li>
                        <li><a href="#">Сандали </a></li>
                        <li><a href="#">Шлепки </a></li>
                      </ul>
                    </div>
                  </div> -->
                  <div class="sidebar__filter sidebar-filter">
                    <div class="sidebar-filter__header">
                      <h4 class="sidebar__title title-filter-category">
                        Фильтр по цене
                      </h4>
                      <svg
                        width="8"
                        height="5"
                        viewBox="0 0 8 5"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M3.64645 0.146447C3.84171 -0.0488155 4.15829 -0.0488155 4.35355 0.146447L7.53553 3.32843C7.7308 3.52369 7.7308 3.84027 7.53553 4.03553C7.34027 4.2308 7.02369 4.2308 6.82843 4.03553L4 1.20711L1.17157 4.03553C0.976311 4.2308 0.659728 4.2308 0.464466 4.03553C0.269204 3.84027 0.269204 3.52369 0.464466 3.32843L3.64645 0.146447ZM4 1.5L3.5 1.5L3.5 0.5L4 0.5L4.5 0.5L4.5 1.5L4 1.5Z"
                          fill="#232323"
                        />
                      </svg>
                    </div>
                    <div class="sidebar-filter__body">
                      <div class="sidebar-filter__price">
                        <div class="sidebar-filter__price-header">
                          <input
                            name="min_price"
                            type="number"
                            class="sidebar-filter__price-number sidebar-filter__price-number--min"
                          />
                          <p>-</p>
                          <input
                            name="max_price"
                            type="number"
                            class="sidebar-filter__price-number sidebar-filter__price-number--max"
                          />
                        </div>
                        <div class="sidebar-filter__price-range"></div>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="sidebar__filter sidebar-filter">
                    <div class="sidebar-filter__header">
                      <h4 class="sidebar__title title-filter-category">
                        Размеры (EU)
                      </h4>
                      <svg
                        width="8"
                        height="5"
                        viewBox="0 0 8 5"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M3.64645 0.146447C3.84171 -0.0488155 4.15829 -0.0488155 4.35355 0.146447L7.53553 3.32843C7.7308 3.52369 7.7308 3.84027 7.53553 4.03553C7.34027 4.2308 7.02369 4.2308 6.82843 4.03553L4 1.20711L1.17157 4.03553C0.976311 4.2308 0.659728 4.2308 0.464466 4.03553C0.269204 3.84027 0.269204 3.52369 0.464466 3.32843L3.64645 0.146447ZM4 1.5L3.5 1.5L3.5 0.5L4 0.5L4.5 0.5L4.5 1.5L4 1.5Z"
                          fill="#232323"
                        />
                      </svg>
                    </div>
                    <div class="sidebar-filter__body">
                      <div class="sidebar-filter__size-grid">
                        <button>36</button>
                        <button>37</button>
                        <button>38</button>
                        <button>39</button>
                        <button>40</button>
                        <button>41</button>
                        <button>42</button>
                        <button>42</button>
                        <button>43</button>
                        <button>44</button>
                      </div>
                    </div>
                  </div>  -->

                   <div class="sidebar__filter sidebar-filter">
                    <div class="sidebar-filter__header">
                      <h4 class="sidebar__title title-filter-category">
                        Механизм
                      </h4>
                      <svg
                        width="8"
                        height="5"
                        viewBox="0 0 8 5"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M3.64645 0.146447C3.84171 -0.0488155 4.15829 -0.0488155 4.35355 0.146447L7.53553 3.32843C7.7308 3.52369 7.7308 3.84027 7.53553 4.03553C7.34027 4.2308 7.02369 4.2308 6.82843 4.03553L4 1.20711L1.17157 4.03553C0.976311 4.2308 0.659728 4.2308 0.464466 4.03553C0.269204 3.84027 0.269204 3.52369 0.464466 3.32843L3.64645 0.146447ZM4 1.5L3.5 1.5L3.5 0.5L4 0.5L4.5 0.5L4.5 1.5L4 1.5Z"
                          fill="#232323"
                        />
                      </svg>
                    </div>
                    <div class="sidebar-filter__body">
                      <div class="sidebar-filter__brends">
                        <?php my_get_wc_terms('pa_mechanism');?>
                      </div>
                    </div>
                  </div>

                  <div class="sidebar__filter sidebar-filter">
                    <div class="sidebar-filter__header">
                      <h4 class="sidebar__title title-filter-category">
                        Бренды
                      </h4>
                      <svg
                        width="8"
                        height="5"
                        viewBox="0 0 8 5"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M3.64645 0.146447C3.84171 -0.0488155 4.15829 -0.0488155 4.35355 0.146447L7.53553 3.32843C7.7308 3.52369 7.7308 3.84027 7.53553 4.03553C7.34027 4.2308 7.02369 4.2308 6.82843 4.03553L4 1.20711L1.17157 4.03553C0.976311 4.2308 0.659728 4.2308 0.464466 4.03553C0.269204 3.84027 0.269204 3.52369 0.464466 3.32843L3.64645 0.146447ZM4 1.5L3.5 1.5L3.5 0.5L4 0.5L4.5 0.5L4.5 1.5L4 1.5Z"
                          fill="#232323"
                        />
                      </svg>
                    </div>
                    <div class="sidebar-filter__body">
                      <div class="sidebar-filter__brends">
                        <?php my_get_wc_terms('product_brand');?>
                      </div>
                    </div>
                  </div>
                 
                  <div class="sidebar__filter sidebar-filter">
                    <div class="sidebar-filter__header">
                      <h4 class="sidebar__title title-filter-category">Цвет</h4>
                      <svg
                        width="8"
                        height="5"
                        viewBox="0 0 8 5"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M3.64645 0.146447C3.84171 -0.0488155 4.15829 -0.0488155 4.35355 0.146447L7.53553 3.32843C7.7308 3.52369 7.7308 3.84027 7.53553 4.03553C7.34027 4.2308 7.02369 4.2308 6.82843 4.03553L4 1.20711L1.17157 4.03553C0.976311 4.2308 0.659728 4.2308 0.464466 4.03553C0.269204 3.84027 0.269204 3.52369 0.464466 3.32843L3.64645 0.146447ZM4 1.5L3.5 1.5L3.5 0.5L4 0.5L4.5 0.5L4.5 1.5L4 1.5Z"
                          fill="#232323"
                        />
                      </svg>
                    </div>
                    <div class="sidebar-filter__body">
                      <div class="sidebar-filter__colors-grid">
                        <?php  my_get_wc_terms('pa_color') ;?>
                      </div>
                    </div>
                  </div>

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
              <div class="catalog-content__text-sort">
                <p>Сортировать по &nbsp;<b>От дешевых к дорогим</b></p>
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
                <ul class="catalog-content__menu-sort">
                  <li>От дешевых к дорогим</li>
                  <li>От новых к старым</li>
                </ul>
              </div>
            </div>
            <ul class="catalog-content__tags">
              <li class="catalog-content__tag">
                <div class="catalog-content__tag-text">
                  <span>название атрибута</span>: <span>выбранный атрибут</span>
                </div>
                <button>&#x2716;</button>
              </li>
            </ul>
            <div class="catalog-content__body">
              <div class="catalog-content__grid">
                <?php while($query->have_posts()): $query->the_post()?>
                      <?php get_template_part('templates/card-variant-1');?>
                    <?php endwhile;?>
                  <?php endif;?>
                  <?php  wp_reset_postdata();;?>
              </div>

              <div class="catalog-content__pagination">
                <?php
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
                    ?>
                </div>
              </div> 
            </div>
          </div>
        </div>
      </div>
    </main>




<?php get_footer();?>