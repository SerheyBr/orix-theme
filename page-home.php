 <?php 
    //   Template name: шаблон Главной
    get_header();   
 ?>

<main>
    <div class="swiper slider-hero">
        <div class="swiper-wrapper">
            <?php if(have_rows('slider_main')):?>
                <?php while(have_rows('slider_main')) : the_row();?>
                    <?php get_template_part('templates/main-slider-slide') ;?>
                <?php endwhile;?>
            <?php endif;?>
        </div>
        <div class="slider-hero__pagination"></div>
    </div>



    <!-- вывод секций старт -->
    <?php
        $terms = get_terms('product_brand', [
            'hide_empty' => false,
        ]);
        $brand_name;
        $brand_logo_url; 
    ?>
    <?php if($terms && ! is_wp_error( $terms )) :?>
        <?php foreach($terms as $term):?>
            <?php
                $term_id = $term->term_id;
                $term_meta = get_term_meta($term_id);
                $img_id = $term_meta['thumbnail_id'][0];

                $brand_logo_url = wp_get_attachment_url($img_id);
                $brand_name = $term->name;
            ?>
            <div class="section-for-main1">
                <div class="container">
                    <div class="section-for-main1__wrapper">
                        <?php
                            if( $brand_logo_url){
                                echo '<img src="'.$brand_logo_url.'" class="section-for-main1__logo" alt="">';
                            }else{
                                echo 'h2 class="section-for-main1__title">'. $brand_name .'</h2>';
                            }
                        ?>
                        <?php
                            $arg = array(
                                'post_type' => 'product',
                                'posts_per_page' => 4,
                                'tax_query' => array(
                                    array(
                                    'taxonomy' => 'product_brand',
                                    'field' => 'slug',
                                    'terms' => $term->slug,
                                    )

                                ),
                            );
                            $query = new WP_Query($arg);
                        ?>
                            <div class="section-for-main1__body">
                                <div class="section-for-main1__img-left">
                                    <?php
                                    $image_id = get_field('brend_img', 'product_brand_' . $term->term_id);
                                  
                                    if ($image_id) {
                                        echo '<img src="'.$image_id.'" alt="#" />';
                                    }
                                    ?>
                                    <img src="/assets/images/model3.webp" alt="#" />
                                </div>
                                    <div class="section-for-main1__products-wrapper">

                                        <?php if($query->have_posts()):?>
                                            <div class="section-for-main1__grid">
                                                <?php while($query->have_posts()): $query->the_post();?>
                                                    <div class="section-for-main1__grid--item">
                                                        <?php get_template_part('templates/card-variant-1');?>
                                                    </div>
                                                <?php endwhile;?>
                                            </div>
                                        <?php endif;?>
                                        <?php wp_reset_postdata(); ?>
                                    </div>
                                </div>
                            </div>

            <div class="section-for-main1__slider">
              <section class="sec-demo-catalog">
                <div class="sec-demo-catalog__wrapper">
                  <div class="sec-demo-catalog__category">
                    <div class="sec-demo-catalog__header">
                      <!-- <h2
                        class="sec-demo-catalog__category-title title-section"
                      >
                        Обувь
                      </h2>
                      <a href="#" class="sec-demo-catalog__link-more">
                        больше товаров
                        <svg
                          width="6"
                          height="11"
                          viewBox="0 0 6 11"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M5.36529 6.06549C5.67771 5.75307 5.67771 5.24654 5.36529 4.93412L1.36529 0.934119C1.05288 0.6217 0.546343 0.6217 0.233924 0.934119C-0.0784959 1.24654 -0.0784959 1.75307 0.233924 2.06549L3.66824 5.4998L0.233924 8.93412C-0.0784955 9.24654 -0.0784955 9.75307 0.233924 10.0655C0.546343 10.3779 1.05288 10.3779 1.36529 10.0655L5.36529 6.06549Z"
                            fill="#121214"
                          />
                        </svg>
                      </a> -->
                    </div>
                    <div class="swiper slider-demo-category">
                      <div class="swiper-wrapper">
                        <?php
                         $arg['posts_per_page'] = -1;
                         $query = new WP_Query($arg);
                         ?>

                        <?php if($query->have_posts()):?>
                            <?php while($query->have_posts()): $query->the_post();?>
                                <div class="swiper-slide">
                                    <?php get_template_part('templates/card-variant-1');?>
                                </div>
                            <?php endwhile;?>
                        <?php endif;?>

                

                      </div>

                      <div class="slider-demo-category__navigation">
                        <div class="slider-demo-category__button-prev">
                          <svg
                            width="8"
                            height="14"
                            viewBox="0 0 8 14"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                              d="M7 13L1 7L7 1"
                              stroke="#121214"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                            />
                          </svg>
                        </div>
                        <div class="slider-demo-category__pagination"></div>
                        <div class="slider-demo-category__button-next">
                          <svg
                            width="8"
                            height="14"
                            viewBox="0 0 8 14"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                              d="M1 13L7 7L1 1"
                              stroke="#121214"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                            />
                          </svg>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            </div>
        <?php endforeach;?>
    <?php endif;?>

          </div>
        </div>
      </div>
    </main>

<?php get_footer();?>