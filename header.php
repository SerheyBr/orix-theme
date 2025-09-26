<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body>
    <header class="header">
      <div class="container">
        <div class="header__wrapper">
          <div class="burger-menu header__burger">
            <button class="burger-menu__button"></button>
          </div>
          <a href="<?php echo get_permalink(79); ?>"
            ><img
              class="header__logo"
              src="<?php echo get_stylesheet_directory_uri();?>/assets/images/placeholder.svg"
              alt="logo"
              width="80"
              height="60"
          /></a>

          <nav class="header__navigation">
            <ul>
              <li>
                <a href="<?php echo get_permalink(312); ?>">Каталог</a>
                <svg
                  width="8"
                  height="5"
                  viewBox="0 0 8 5"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    opacity="0.3"
                    d="M3.64645 4.35355C3.84171 4.54882 4.15829 4.54882 4.35355 4.35355L7.53553 1.17157C7.7308 0.976311 7.7308 0.659728 7.53553 0.464466C7.34027 0.269204 7.02369 0.269204 6.82843 0.464466L4 3.29289L1.17157 0.464466C0.976311 0.269204 0.659728 0.269204 0.464466 0.464466C0.269204 0.659728 0.269204 0.976311 0.464466 1.17157L3.64645 4.35355ZM3.5 3L3.5 4L4.5 4L4.5 3L3.5 3Z"
                    fill="white"
                  />
                </svg>

                <ul>
                  <li><a href="#">Lorem ipsum dolor sit amet.</a></li>
                  <li><a href="#">Lorem ipsum dolor sit amet.</a></li>
                  <li><a href="#">Lorem ipsum dolor sit amet.</a></li>
                  <li><a href="#">Lorem ipsum dolor sit amet.</a></li>
                </ul>
              </li>
              <li>
                <a href="<?php echo get_permalink(356); ?>">Sail</a>
                <svg
                  width="8"
                  height="5"
                  viewBox="0 0 8 5"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    opacity="0.3"
                    d="M3.64645 4.35355C3.84171 4.54882 4.15829 4.54882 4.35355 4.35355L7.53553 1.17157C7.7308 0.976311 7.7308 0.659728 7.53553 0.464466C7.34027 0.269204 7.02369 0.269204 6.82843 0.464466L4 3.29289L1.17157 0.464466C0.976311 0.269204 0.659728 0.269204 0.464466 0.464466C0.269204 0.659728 0.269204 0.976311 0.464466 1.17157L3.64645 4.35355ZM3.5 3L3.5 4L4.5 4L4.5 3L3.5 3Z"
                    fill="white"
                  />
                </svg>
                <ul>
                  <li><a href="#">Lorem ipsum dolor sit amet.</a></li>
                  <li><a href="#">Lorem ipsum dolor sit amet.</a></li>
                </ul>
              </li>
              <li>
                <a href="<?php echo get_permalink(354); ?>">Ремешки</a>
                <svg
                  width="8"
                  height="5"
                  viewBox="0 0 8 5"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    opacity="0.3"
                    d="M3.64645 4.35355C3.84171 4.54882 4.15829 4.54882 4.35355 4.35355L7.53553 1.17157C7.7308 0.976311 7.7308 0.659728 7.53553 0.464466C7.34027 0.269204 7.02369 0.269204 6.82843 0.464466L4 3.29289L1.17157 0.464466C0.976311 0.269204 0.659728 0.269204 0.464466 0.464466C0.269204 0.659728 0.269204 0.976311 0.464466 1.17157L3.64645 4.35355ZM3.5 3L3.5 4L4.5 4L4.5 3L3.5 3Z"
                    fill="white"
                  />
                </svg>
                <ul>
                  <li><a href="#">Lorem ipsum dolor sit amet.</a></li>
                  <li><a href="#">Lorem ipsum dolor sit amet.</a></li>
                </ul>
              </li>
              <li>
                <a href="#">Доставка</a>
              </li>
              <li>
                <a href="<?php echo wc_get_checkout_url();?>">Расчет стоимости</a>
              </li>
              <li>
                <a href="#">Информация</a>
              </li>
            </ul>
          </nav>
          <div class="header__icons">
            <div class="header__icon">
              <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icons/seacrh.svg" alt="search" />
            </div>
            <!-- <a href="#" class="header__icon">
          <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icons/star.svg" alt="star" />
        </a> -->
            <a href="<?php echo wc_get_page_permalink('myaccount'); ?>" class="header__icon">
              <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icons/profile.svg" alt="profile" />
            </a>
            <a href="<?php echo wc_get_cart_url(); ?>" class="header__icon">
              <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icons/cart.svg" alt="cart" />
              <p class="header__cart-price">11 899 ₽</p>
              <p class="header__numbers">7</p>
            </a>
          </div>
        </div>
      </div>
    </header>


