<?php
    get_header() ;

    $product = wc_get_product(get_the_ID());
    $id_product = $product->id;
    $taxonomies = get_object_taxonomies( 'product', 'objects' );

    $brand_terms = get_the_terms( $id_product, 'product_brand' );
    $brand = $brand_terms[0]->name ?? '';
    $brand_slug  = $brand_terms[0]->slug ?? '';
    $category_terms = get_the_terms( $id_product, 'product_cat' );
    $category_slug = $category_terms[0]->slug ?? '';


    $name = $product->name;
    $full_description = $product->description;
    $short_description = $product->short_description;
    $sale_price = $product->sale_price;
    $regular_price = $product->regular_price;
    $weight = $product->weight;
    $length = $product->length;
    $width = $product->width;
    $height = $product->height;

    $attributes = $product->attributes;
    $gallery = $product->gallery_image_ids;

    $main_img_id = $product->image_id;
    $url_main_img = wp_get_attachment_url( $main_img_id);

    //создаем и собираем массив из url изображений галерее товара !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $array_img_url = array($url_main_img);
    foreach ( $gallery as $image_id ) {
        $url = wp_get_attachment_url( $image_id );
        $array_img_url[] = $url;
    }

    // собираем массив из габаритов товара !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $details = array(
        array('name' => 'вес', 'value' => $weight),
        array('name' => 'длина', 'value' => $length),
        array('name' => 'ширина', 'value' => $width),
        array('name' => 'высота', 'value' => $height),
    );

    // создаем и собираем массив из атрибутов товара (цвет, материал и т.д) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $array_atributes = array(
        [
            'name' => 'Бренд', 
            'value' => $brand,
        ]
    );

    foreach($attributes as $atr){
        $terms = get_the_terms( $id_product, $atr['name'] );
        $tax = get_taxonomy($atr['name']);

        if ( ! $tax || empty($terms) || is_wp_error($terms) ) {
        continue; // пропускаем, если таксономии или терминов нет
    }

        $name_atribut = $tax->labels->singular_name;
        $value = $terms[0]->name;

        $array_atributes[] = array(
           'name' => $name_atribut, 
           'value' => $value,
        );
    }

 // функция которая обрабатывает массивы и выводит разметку !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    function render_list_details($array) {
        foreach($array as $item){
            echo '<li>';    
            echo '<p class="full-card__description-name">'.$item['name'].'</p>';        
            echo '<span>';        
            echo '<div class="full-card__description-line"></div>';            
            echo '</span>';        
            echo '<p class="full-card__description-result">'.$item['value'].'</p>';        
            echo '</li>';   
        }
     
    }
?>

    <main class="page-full-card">
      <div class="page-full-card__wrapper">
        <div class="container">
          <div class="breadcrumbs">
            <p class="breadcrumbs__content">
              Главная / Каталог товаров / Обувь 
            </p>
          </div>
        </div>

        <div class="page-full-card__body">
          <div class="container">
            <div class="full-card">
              <div class="full-card__wrapper">
                <h3 class="full-card__title hidden">
                  <?php print_r($name);?>
                </h3>
                <div class="full-card__slider">
                  <!-- Основной слайдер -->
                  <div class="swiper full-card-main-slider">
                    <div class="swiper-wrapper">
                        <?php
                            foreach($array_img_url as $url){
                            echo '<div class="swiper-slide">';
                            echo '<img src="'.$url.'" alt=""/>';
                            echo '</div>';
                            }
                        ?>
                    </div>
                  </div>

                  <!-- Слайдер превью -->
                  <div class="swiper full-card-thumbs-slider">
                    <div class="swiper-wrapper">
                        <?php
                            foreach($array_img_url as $url){
                            echo '<div class="swiper-slide">';
                            echo '<img src="'.$url.'" alt=""/>';
                            echo '</div>';
                            }
                        ?>
                    </div>
                    <div class="full-card-thumbs-slider__pagination"></div>
                  </div>
                </div>
                <div class="full-card__description">
                  <h3 class="full-card__title">
                    <?php print_r($name);?>
                  </h3>
                  <p class="full-card__subtitle">Детали:</p>
                  <div class="full-card__description__body">
                    <ul class="full-card__description-items">
                        <?php render_list_details($array_atributes);?>
                        <?php render_list_details($details);?>
                    </ul>
                  </div>
                  <?php woocommerce_template_single_add_to_cart(); ?>
                  <button class="full-card__btn button">
                    Длбавить в карзину<svg
                      width="6"
                      height="10"
                      viewBox="0 0 6 10"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M5.36529 5.56549C5.67771 5.25307 5.67771 4.74654 5.36529 4.43412L1.36529 0.434119C1.05288 0.1217 0.546343 0.1217 0.233924 0.434119C-0.0784959 0.746538 -0.0784959 1.25307 0.233924 1.56549L3.66824 4.9998L0.233924 8.43412C-0.0784955 8.74654 -0.0784955 9.25307 0.233924 9.56549C0.546343 9.87791 1.05288 9.87791 1.36529 9.56549L5.36529 5.56549Z"
                        fill="white"
                      />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-for-full-card">
            <div class="tab-for-full-card__top">
              <div class="container">
                <div class="tab-for-full-card__list">
                  <button class="tab-for-full-card__item" data-tab="1">
                    Доставка
                  </button>
                  <button class="tab-for-full-card__item" data-tab="2">
                    Оплата
                  </button>
                  <button class="tab-for-full-card__item" data-tab="3">
                    FAQ
                  </button>
                </div>
              </div>
            </div>
            <div class="container">
              <div class="tab-for-full-card__body" data-tab="1">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit
                adipisci iste impedit id, soluta nesciunt veniam molestias
                expedita odit odio quidem corporis sequi voluptatum, libero
                veritatis tempore reiciendis facere. Sint? Iusto ea perferendis
                expedita minus! Omnis illum distinctio perspiciatis, dolorum
                ipsum fugiat reprehenderit accusantium, nobis suscipit, beatae
                aliquid consequatur minus dignissimos iure! Porro cupiditate
                fugit, unde a eveniet cum iusto! Laborum at expedita blanditiis
                rerum cumque voluptas. Ipsum, alias quam accusantium dolorem
                fugiat aspernatur itaque culpa asperiores exercitationem
                excepturi doloribus, suscipit veniam velit, rerum esse quae quia
                ipsa iure nemo. Facere quae reprehenderit illo architecto modi
                ex possimus quasi ratione, facilis quam assumenda, asperiores
                distinctio, quia hic! Modi nulla veniam numquam libero
                consequatur id eos autem hic, accusantium sit aut! Quidem quae
                eum deserunt aspernatur pariatur odit? Expedita illum laboriosam
                sint ut, quam sed saepe maiores? Ducimus, et facilis? Ut
                delectus voluptas iure. Voluptas sint voluptatum soluta optio
                error eveniet. Repudiandae facere laudantium accusamus at sed
                voluptates dignissimos rerum ratione unde consequuntur quisquam
                itaque ab doloremque quibusdam, iste asperiores maxime fuga
                aliquam dolor alias maiores cum! Nobis commodi pariatur
                provident.
              </div>
              <div class="tab-for-full-card__body" data-tab="2">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                Dignissimos aut eaque, voluptatem aliquid ullam quisquam,
                laudantium ratione consectetur cumque quas reiciendis labore
                blanditiis asperiores quaerat repellendus vel quia? Possimus,
                nostrum. Culpa inventore praesentium tempora? Illo aspernatur
                nemo earum dicta, sint possimus quod amet ullam iste nulla
                soluta corporis sunt accusamus consequuntur dolorum sit,
                perferendis vitae quae provident laboriosam ratione dignissimos!
                Ratione voluptatem mollitia, quam error illum ex vel?
                Blanditiis, ipsum accusamus necessitatibus quidem veniam
                suscipit animi debitis numquam, tenetur corrupti cupiditate
                repellat magnam tempora sed quae aliquid atque, cumque
                laudantium! Iste nesciunt optio eligendi consectetur est? Iure
                quis, vero velit sint, aut, dolorem quisquam iusto unde sit
                nostrum assumenda reiciendis praesentium earum est possimus
                culpa mollitia perferendis exercitationem aperiam? Quis!
              </div>
              <div class="tab-for-full-card__body" data-tab="3">
                <div class="tab-for-full-card-fac">
                  <div class="tab-for-full-card-fac__item">
                    <button class="tab-for-full-card-fac__trigger">
                      <p>Вопрос 1</p>
                      <svg
                        width="6"
                        height="10"
                        viewBox="0 0 6 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M1 9L5 5L1 1"
                          stroke="#121214"
                          stroke-width="1.6"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                      </svg>
                    </button>
                    <div class="tab-for-full-card-fac__body text-WYSIWYG">
                      <h2>Введение в современный веб-дизайн</h2>
                      <p>
                        Создание сайта в XXI веке — это гораздо больше, чем
                        просто написание кода. Это
                        <strong>искусство</strong> сочетать эстетику с
                        функциональностью, чтобы предоставить пользователю
                        незабываемый опыт. Современный веб-дизайн основывается
                        на нескольких ключевых принципах, которые отличают
                        посредственный сайт от выдающегося.
                      </p>
                      <p>
                        Понимание этих принципов <em>крайне важно</em> для
                        любого, кто работает в digital-сфере: будь вы
                        маркетолог, копирайтер или backend-разработчик. В этой
                        статье мы рассмотрим основные столпы, на которых
                        держится хороший дизайн.
                      </p>
                      <h3>Ключевые принципы UI/UX дизайна</h3>
                      <p>
                        Пользовательский интерфейс (UI) и пользовательский опыт
                        (UX) идут рука об руку. Вот что делает их по-настоящему
                        эффективными:
                      </p>
                      <ul>
                        <li>
                          <strong>Простота и интуитивность:</strong>
                          Пользователь не должен гадать, как использовать ваш
                          сайт. Навигация и интерфейсные элементы должны быть
                          предсказуемыми и понятными.
                        </li>
                        <li>
                          <strong>Визуальная иерархия:</strong> Правильное
                          использование размера, цвета и контраста позволяет
                          направить внимание пользователя к самым важным
                          элементам на странице.
                        </li>
                        <li>
                          <strong>Консистентность:</strong> Шрифты, цвета и
                          стили элементов должны быть единообразны на всех
                          страницах сайта. Это создает чувство цельности и
                          профессиональности.
                        </li>
                        <li>
                          <strong>Отзывчивость (Responsiveness):</strong> В
                          эпоху мобильных устройств сайт обязан идеально
                          работать и выглядеть на экране любого размера.
                        </li>
                      </ul>
                      <h3>Технические аспекты разработки</h3>
                      <p>
                        Красивый дизайн бесполезен, если он не подкреплен
                        качественной технической реализацией. Основу фронтенда
                        современного веба составляют три кита:
                      </p>
                      <ol>
                        <li>
                          <strong>HTML (HyperText Markup Language)</strong> —
                          это каркас вашей страницы. Он определяет структуру
                          контента: заголовки, абзацы, списки, ссылки и
                          изображения.
                        </li>
                        <li>
                          <strong>CSS (Cascading Style Sheets)</strong> — это
                          язык стилей, который превращает скучный HTML-каркас в
                          визуально привлекательную страницу. Он контролирует
                          цвета, шрифты, расположение блоков и анимацию.
                        </li>
                        <li>
                          <strong>JavaScript</strong> — это то, что делает ваш
                          сайт интерактивным. От простых слайдеров до сложных
                          одностраничных приложений (SPA) — всё это заслуга
                          JavaScript.
                        </li>
                      </ol>
                      <p>
                        Глубокая оптимизация каждого из этих аспектов напрямую
                        влияет на
                        <em>скорость загрузки</em>, а значит, и на позиции в
                        поисковой выдаче, и на удовлетворенность пользователей.
                      </p>
                      <h3>Заключение</h3>
                      <p>
                        Создание успешного веб-продукта — это всегда командная
                        работа и внимание к деталям. Не существует единственно
                        правильного ответа на вопрос, как должен выглядеть
                        идеальный сайт, но есть проверенные временем практики и
                        принципы, которые служат надежным компасом в мире
                        веб-разработки.
                      </p>
                      <p>
                        Постоянное обучение и адаптация к новым тенденциям —
                        <strong>единственный путь</strong> оставаться
                        востребованным специалистом и создавать по-настоящему
                        качественные digital-продукты.
                      </p>
                    </div>
                  </div>
                  <div class="tab-for-full-card-fac__item">
                    <button class="tab-for-full-card-fac__trigger">
                      <p>вопрос 2</p>
                      <svg
                        width="6"
                        height="10"
                        viewBox="0 0 6 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M1 9L5 5L1 1"
                          stroke="#121214"
                          stroke-width="1.6"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                      </svg>
                    </button>
                    <div class="tab-for-full-card-fac__body text-WYSIWYG">
                      <h2>Введение в современный веб-дизайн</h2>
                      <p>
                        Создание сайта в XXI веке — это гораздо больше, чем
                        просто написание кода. Это
                        <strong>искусство</strong> сочетать эстетику с
                        функциональностью, чтобы предоставить пользователю
                        незабываемый опыт. Современный веб-дизайн основывается
                        на нескольких ключевых принципах, которые отличают
                        посредственный сайт от выдающегося.
                      </p>
                      <p>
                        Понимание этих принципов <em>крайне важно</em> для
                        любого, кто работает в digital-сфере: будь вы
                        маркетолог, копирайтер или backend-разработчик. В этой
                        статье мы рассмотрим основные столпы, на которых
                        держится хороший дизайн.
                      </p>
                      <h3>Ключевые принципы UI/UX дизайна</h3>
                      <p>
                        Пользовательский интерфейс (UI) и пользовательский опыт
                        (UX) идут рука об руку. Вот что делает их по-настоящему
                        эффективными:
                      </p>
                      <ul>
                        <li>
                          <strong>Простота и интуитивность:</strong>
                          Пользователь не должен гадать, как использовать ваш
                          сайт. Навигация и интерфейсные элементы должны быть
                          предсказуемыми и понятными.
                        </li>
                        <li>
                          <strong>Визуальная иерархия:</strong> Правильное
                          использование размера, цвета и контраста позволяет
                          направить внимание пользователя к самым важным
                          элементам на странице.
                        </li>
                        <li>
                          <strong>Консистентность:</strong> Шрифты, цвета и
                          стили элементов должны быть единообразны на всех
                          страницах сайта. Это создает чувство цельности и
                          профессиональности.
                        </li>
                        <li>
                          <strong>Отзывчивость (Responsiveness):</strong> В
                          эпоху мобильных устройств сайт обязан идеально
                          работать и выглядеть на экране любого размера.
                        </li>
                      </ul>
                      <h3>Технические аспекты разработки</h3>
                      <p>
                        Красивый дизайн бесполезен, если он не подкреплен
                        качественной технической реализацией. Основу фронтенда
                        современного веба составляют три кита:
                      </p>
                      <ol>
                        <li>
                          <strong>HTML (HyperText Markup Language)</strong> —
                          это каркас вашей страницы. Он определяет структуру
                          контента: заголовки, абзацы, списки, ссылки и
                          изображения.
                        </li>
                        <li>
                          <strong>CSS (Cascading Style Sheets)</strong> — это
                          язык стилей, который превращает скучный HTML-каркас в
                          визуально привлекательную страницу. Он контролирует
                          цвета, шрифты, расположение блоков и анимацию.
                        </li>
                        <li>
                          <strong>JavaScript</strong> — это то, что делает ваш
                          сайт интерактивным. От простых слайдеров до сложных
                          одностраничных приложений (SPA) — всё это заслуга
                          JavaScript.
                        </li>
                      </ol>
                      <p>
                        Глубокая оптимизация каждого из этих аспектов напрямую
                        влияет на
                        <em>скорость загрузки</em>, а значит, и на позиции в
                        поисковой выдаче, и на удовлетворенность пользователей.
                      </p>
                      <h3>Заключение</h3>
                      <p>
                        Создание успешного веб-продукта — это всегда командная
                        работа и внимание к деталям. Не существует единственно
                        правильного ответа на вопрос, как должен выглядеть
                        идеальный сайт, но есть проверенные временем практики и
                        принципы, которые служат надежным компасом в мире
                        веб-разработки.
                      </p>
                      <p>
                        Постоянное обучение и адаптация к новым тенденциям —
                        <strong>единственный путь</strong> оставаться
                        востребованным специалистом и создавать по-настоящему
                        качественные digital-продукты.
                      </p>
                    </div>
                  </div>
                  <div class="tab-for-full-card-fac__item">
                    <button class="tab-for-full-card-fac__trigger">
                      <p>вопрос 3</p>
                      <svg
                        width="6"
                        height="10"
                        viewBox="0 0 6 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M1 9L5 5L1 1"
                          stroke="#121214"
                          stroke-width="1.6"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                      </svg>
                    </button>
                    <div class="tab-for-full-card-fac__body text-WYSIWYG">
                      <h2>Введение в современный веб-дизайн</h2>
                      <p>
                        Создание сайта в XXI веке — это гораздо больше, чем
                        просто написание кода. Это
                        <strong>искусство</strong> сочетать эстетику с
                        функциональностью, чтобы предоставить пользователю
                        незабываемый опыт. Современный веб-дизайн основывается
                        на нескольких ключевых принципах, которые отличают
                        посредственный сайт от выдающегося.
                      </p>
                      <p>
                        Понимание этих принципов <em>крайне важно</em> для
                        любого, кто работает в digital-сфере: будь вы
                        маркетолог, копирайтер или backend-разработчик. В этой
                        статье мы рассмотрим основные столпы, на которых
                        держится хороший дизайн.
                      </p>
                      <h3>Ключевые принципы UI/UX дизайна</h3>
                      <p>
                        Пользовательский интерфейс (UI) и пользовательский опыт
                        (UX) идут рука об руку. Вот что делает их по-настоящему
                        эффективными:
                      </p>
                      <ul>
                        <li>
                          <strong>Простота и интуитивность:</strong>
                          Пользователь не должен гадать, как использовать ваш
                          сайт. Навигация и интерфейсные элементы должны быть
                          предсказуемыми и понятными.
                        </li>
                        <li>
                          <strong>Визуальная иерархия:</strong> Правильное
                          использование размера, цвета и контраста позволяет
                          направить внимание пользователя к самым важным
                          элементам на странице.
                        </li>
                        <li>
                          <strong>Консистентность:</strong> Шрифты, цвета и
                          стили элементов должны быть единообразны на всех
                          страницах сайта. Это создает чувство цельности и
                          профессиональности.
                        </li>
                        <li>
                          <strong>Отзывчивость (Responsiveness):</strong> В
                          эпоху мобильных устройств сайт обязан идеально
                          работать и выглядеть на экране любого размера.
                        </li>
                      </ul>
                      <h3>Технические аспекты разработки</h3>
                      <p>
                        Красивый дизайн бесполезен, если он не подкреплен
                        качественной технической реализацией. Основу фронтенда
                        современного веба составляют три кита:
                      </p>
                      <ol>
                        <li>
                          <strong>HTML (HyperText Markup Language)</strong> —
                          это каркас вашей страницы. Он определяет структуру
                          контента: заголовки, абзацы, списки, ссылки и
                          изображения.
                        </li>
                        <li>
                          <strong>CSS (Cascading Style Sheets)</strong> — это
                          язык стилей, который превращает скучный HTML-каркас в
                          визуально привлекательную страницу. Он контролирует
                          цвета, шрифты, расположение блоков и анимацию.
                        </li>
                        <li>
                          <strong>JavaScript</strong> — это то, что делает ваш
                          сайт интерактивным. От простых слайдеров до сложных
                          одностраничных приложений (SPA) — всё это заслуга
                          JavaScript.
                        </li>
                      </ol>
                      <p>
                        Глубокая оптимизация каждого из этих аспектов напрямую
                        влияет на
                        <em>скорость загрузки</em>, а значит, и на позиции в
                        поисковой выдаче, и на удовлетворенность пользователей.
                      </p>
                      <h3>Заключение</h3>
                      <p>
                        Создание успешного веб-продукта — это всегда командная
                        работа и внимание к деталям. Не существует единственно
                        правильного ответа на вопрос, как должен выглядеть
                        идеальный сайт, но есть проверенные временем практики и
                        принципы, которые служат надежным компасом в мире
                        веб-разработки.
                      </p>
                      <p>
                        Постоянное обучение и адаптация к новым тенденциям —
                        <strong>единственный путь</strong> оставаться
                        востребованным специалистом и создавать по-настоящему
                        качественные digital-продукты.
                      </p>
                    </div>
                  </div>
                  <div class="tab-for-full-card-fac__item">
                    <button class="tab-for-full-card-fac__trigger">
                      <p>вопрос 4</p>
                      <svg
                        width="6"
                        height="10"
                        viewBox="0 0 6 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M1 9L5 5L1 1"
                          stroke="#121214"
                          stroke-width="1.6"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                      </svg>
                    </button>
                    <div class="tab-for-full-card-fac__body text-WYSIWYG">
                      <h2>Введение в современный веб-дизайн</h2>
                      <p>
                        Создание сайта в XXI веке — это гораздо больше, чем
                        просто написание кода. Это
                        <strong>искусство</strong> сочетать эстетику с
                        функциональностью, чтобы предоставить пользователю
                        незабываемый опыт. Современный веб-дизайн основывается
                        на нескольких ключевых принципах, которые отличают
                        посредственный сайт от выдающегося.
                      </p>
                      <p>
                        Понимание этих принципов <em>крайне важно</em> для
                        любого, кто работает в digital-сфере: будь вы
                        маркетолог, копирайтер или backend-разработчик. В этой
                        статье мы рассмотрим основные столпы, на которых
                        держится хороший дизайн.
                      </p>
                      <h3>Ключевые принципы UI/UX дизайна</h3>
                      <p>
                        Пользовательский интерфейс (UI) и пользовательский опыт
                        (UX) идут рука об руку. Вот что делает их по-настоящему
                        эффективными:
                      </p>
                      <ul>
                        <li>
                          <strong>Простота и интуитивность:</strong>
                          Пользователь не должен гадать, как использовать ваш
                          сайт. Навигация и интерфейсные элементы должны быть
                          предсказуемыми и понятными.
                        </li>
                        <li>
                          <strong>Визуальная иерархия:</strong> Правильное
                          использование размера, цвета и контраста позволяет
                          направить внимание пользователя к самым важным
                          элементам на странице.
                        </li>
                        <li>
                          <strong>Консистентность:</strong> Шрифты, цвета и
                          стили элементов должны быть единообразны на всех
                          страницах сайта. Это создает чувство цельности и
                          профессиональности.
                        </li>
                        <li>
                          <strong>Отзывчивость (Responsiveness):</strong> В
                          эпоху мобильных устройств сайт обязан идеально
                          работать и выглядеть на экране любого размера.
                        </li>
                      </ul>
                      <h3>Технические аспекты разработки</h3>
                      <p>
                        Красивый дизайн бесполезен, если он не подкреплен
                        качественной технической реализацией. Основу фронтенда
                        современного веба составляют три кита:
                      </p>
                      <ol>
                        <li>
                          <strong>HTML (HyperText Markup Language)</strong> —
                          это каркас вашей страницы. Он определяет структуру
                          контента: заголовки, абзацы, списки, ссылки и
                          изображения.
                        </li>
                        <li>
                          <strong>CSS (Cascading Style Sheets)</strong> — это
                          язык стилей, который превращает скучный HTML-каркас в
                          визуально привлекательную страницу. Он контролирует
                          цвета, шрифты, расположение блоков и анимацию.
                        </li>
                        <li>
                          <strong>JavaScript</strong> — это то, что делает ваш
                          сайт интерактивным. От простых слайдеров до сложных
                          одностраничных приложений (SPA) — всё это заслуга
                          JavaScript.
                        </li>
                      </ol>
                      <p>
                        Глубокая оптимизация каждого из этих аспектов напрямую
                        влияет на
                        <em>скорость загрузки</em>, а значит, и на позиции в
                        поисковой выдаче, и на удовлетворенность пользователей.
                      </p>
                      <h3>Заключение</h3>
                      <p>
                        Создание успешного веб-продукта — это всегда командная
                        работа и внимание к деталям. Не существует единственно
                        правильного ответа на вопрос, как должен выглядеть
                        идеальный сайт, но есть проверенные временем практики и
                        принципы, которые служат надежным компасом в мире
                        веб-разработки.
                      </p>
                      <p>
                        Постоянное обучение и адаптация к новым тенденциям —
                        <strong>единственный путь</strong> оставаться
                        востребованным специалистом и создавать по-настоящему
                        качественные digital-продукты.
                      </p>
                    </div>
                  </div>
                  <div class="tab-for-full-card-fac__item">
                    <button class="tab-for-full-card-fac__trigger">
                      <p>вопрос 5</p>
                      <svg
                        width="6"
                        height="10"
                        viewBox="0 0 6 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M1 9L5 5L1 1"
                          stroke="#121214"
                          stroke-width="1.6"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                      </svg>
                    </button>
                    <div class="tab-for-full-card-fac__body text-WYSIWYG">
                      <h2>Введение в современный веб-дизайн</h2>
                      <p>
                        Создание сайта в XXI веке — это гораздо больше, чем
                        просто написание кода. Это
                        <strong>искусство</strong> сочетать эстетику с
                        функциональностью, чтобы предоставить пользователю
                        незабываемый опыт. Современный веб-дизайн основывается
                        на нескольких ключевых принципах, которые отличают
                        посредственный сайт от выдающегося.
                      </p>
                      <p>
                        Понимание этих принципов <em>крайне важно</em> для
                        любого, кто работает в digital-сфере: будь вы
                        маркетолог, копирайтер или backend-разработчик. В этой
                        статье мы рассмотрим основные столпы, на которых
                        держится хороший дизайн.
                      </p>
                      <h3>Ключевые принципы UI/UX дизайна</h3>
                      <p>
                        Пользовательский интерфейс (UI) и пользовательский опыт
                        (UX) идут рука об руку. Вот что делает их по-настоящему
                        эффективными:
                      </p>
                      <ul>
                        <li>
                          <strong>Простота и интуитивность:</strong>
                          Пользователь не должен гадать, как использовать ваш
                          сайт. Навигация и интерфейсные элементы должны быть
                          предсказуемыми и понятными.
                        </li>
                        <li>
                          <strong>Визуальная иерархия:</strong> Правильное
                          использование размера, цвета и контраста позволяет
                          направить внимание пользователя к самым важным
                          элементам на странице.
                        </li>
                        <li>
                          <strong>Консистентность:</strong> Шрифты, цвета и
                          стили элементов должны быть единообразны на всех
                          страницах сайта. Это создает чувство цельности и
                          профессиональности.
                        </li>
                        <li>
                          <strong>Отзывчивость (Responsiveness):</strong> В
                          эпоху мобильных устройств сайт обязан идеально
                          работать и выглядеть на экране любого размера.
                        </li>
                      </ul>
                      <h3>Технические аспекты разработки</h3>
                      <p>
                        Красивый дизайн бесполезен, если он не подкреплен
                        качественной технической реализацией. Основу фронтенда
                        современного веба составляют три кита:
                      </p>
                      <ol>
                        <li>
                          <strong>HTML (HyperText Markup Language)</strong> —
                          это каркас вашей страницы. Он определяет структуру
                          контента: заголовки, абзацы, списки, ссылки и
                          изображения.
                        </li>
                        <li>
                          <strong>CSS (Cascading Style Sheets)</strong> — это
                          язык стилей, который превращает скучный HTML-каркас в
                          визуально привлекательную страницу. Он контролирует
                          цвета, шрифты, расположение блоков и анимацию.
                        </li>
                        <li>
                          <strong>JavaScript</strong> — это то, что делает ваш
                          сайт интерактивным. От простых слайдеров до сложных
                          одностраничных приложений (SPA) — всё это заслуга
                          JavaScript.
                        </li>
                      </ol>
                      <p>
                        Глубокая оптимизация каждого из этих аспектов напрямую
                        влияет на
                        <em>скорость загрузки</em>, а значит, и на позиции в
                        поисковой выдаче, и на удовлетворенность пользователей.
                      </p>
                      <h3>Заключение</h3>
                      <p>
                        Создание успешного веб-продукта — это всегда командная
                        работа и внимание к деталям. Не существует единственно
                        правильного ответа на вопрос, как должен выглядеть
                        идеальный сайт, но есть проверенные временем практики и
                        принципы, которые служат надежным компасом в мире
                        веб-разработки.
                      </p>
                      <p>
                        Постоянное обучение и адаптация к новым тенденциям —
                        <strong>единственный путь</strong> оставаться
                        востребованным специалистом и создавать по-настоящему
                        качественные digital-продукты.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- br -->
          <div class="container">
            <div class="page-full-card__slider-bottom">
              <div class="swiper slider-demo-category">
                <div class="swiper-wrapper">

                <?php
                    if($category_slug == 'watch'){

                       $args = array(
                            'post_type'      => 'product',
                            'posts_per_page' => 20,
                            'tax_query'      => array(
                                'relation' => 'AND', // важно, чтобы учитывались оба условия
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'slug',
                                    'terms'    => $category_slug,
                                ),
                                array(
                                    'taxonomy' => 'product_brand',
                                    'field'    => 'slug',
                                    'terms'    => $brand_slug, // сюда передаём слаг бренда
                                ),
                            ),
                        );

                    }else{
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 20,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'slug',
                                    'terms'    =>  $category_slug,
                                ),
                            ),
                        );
                    }
                   

                    $query = new WP_Query( $args );

                    if($query->have_posts() ){
                        while($query->have_posts() ){
                            $query->the_post();
                            echo '<div class="swiper-slide">';
                           
                            get_template_part('templates/card-variant-1');
                            echo '</div>';
                        }
                    }
                    wp_reset_postdata();
                    ?>
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
        </div>
      </div>
    </main>

<?php get_footer() ;?>