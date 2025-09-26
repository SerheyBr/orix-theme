// action berger menu
const btnBurger = document.querySelector(".burger-menu");
const burgerMenu = document.querySelector(".header__navigation");
if (btnBurger) {
  btnBurger.addEventListener("click", (e) => {
    e.currentTarget.classList.toggle("active");
    burgerMenu.classList.toggle("active");
    if (burgerMenu.classList.contains("active")) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "visible";
    }
  });
}

// action droprown for burger menu
const allLiInBurgerMenu = document.querySelectorAll(
  ".header__navigation ul li"
);
if (allLiInBurgerMenu.length) {
  allLiInBurgerMenu.forEach((el) => {
    el.addEventListener("click", (e) => {
      const element = e.currentTarget;
      if (element.querySelector("ul")) {
        element.querySelector("ul").classList.toggle("active");
      } else {
        console.log("no");
      }
    });
  });
}

// action dropdown for footer
const dropdownFooter = document.querySelectorAll(".footer__dropdown");

if (dropdownFooter.length) {
  dropdownFooter.forEach((el) => {
    el.addEventListener("click", (e) => {
      const element = e.currentTarget;
      dropdownFooter.forEach((item) => {
        if (item === element) {
          item.classList.toggle("active");
        } else {
          item.classList.remove("active");
        }
      });
    });
  });
}

// action dropdown for sidebar
const filterBox = document.querySelectorAll(".sidebar__filter");

if (filterBox.length) {
  filterBox.forEach((el) => {
    const trigger = el.querySelector(".sidebar-filter__header");

    trigger.addEventListener("click", (e) => {
      el.classList.toggle("active");
    });
  });
}

// action sidebar open/closse

const sidebarMobil = document.querySelector(".sidebar");
const btnClose = document.querySelector(".sidebar__btn-close");
const btnOpenSidebarMobil = document.querySelector(
  ".catalog__button-triger-mobil-menu"
);

if (sidebarMobil) {
  document.addEventListener("click", (e) => {
    if (e.target === sidebarMobil) {
      sidebarMobil.classList.remove("mobil-active");
      document.body.style.overflow = "visible";
    }
  });
}

if (btnClose) {
  btnClose.addEventListener("click", (e) => {
    if (e.currentTarget) {
      sidebarMobil.classList.remove("mobil-active");
      document.body.style.overflow = "visible";
    }
  });
}
if (btnOpenSidebarMobil) {
  btnOpenSidebarMobil.addEventListener("click", (e) => {
    if (e.currentTarget) {
      sidebarMobil.classList.add("mobil-active");
      document.body.style.overflow = "hidden";
    }
  });
}

// active tabs for full page
const tab = document.querySelector(".tab-for-full-card");

if (tab) {
  const tabsBtns = tab.querySelectorAll(".tab-for-full-card__item");
  const tabsContent = tab.querySelectorAll(".tab-for-full-card__body");

  tabsBtns[0].classList.add("active");
  tabsContent[0].classList.add("active");

  tabsBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      const tabId = e.currentTarget.dataset.tab;

      tabsBtns.forEach((el) => {
        el.classList.remove("active");
      });

      tabsContent.forEach((el) => {
        el.classList.remove("active");
      });

      e.currentTarget.classList.add("active");
      const selectedContentTab = document
        .querySelector(`.tab-for-full-card__body[data-tab="${tabId}"]`)
        .classList.add("active");
    });
  });
}

// active accordion for full page

const faq = document.querySelector(".tab-for-full-card-fac");
if (faq) {
  const facTriggers = faq.querySelectorAll(".tab-for-full-card-fac__trigger");
  const facBodys = faq.querySelectorAll(".tab-for-full-card-fac__body");

  facTriggers.forEach((trigger) => {
    trigger.addEventListener("click", (e) => {
      const btn = e.currentTarget;
      const body = btn.nextElementSibling;

      // if (btn.classList.contains("active")) {
      //   btn.classList.remove("active");
      //   body.classList.remove("active");
      //   return;
      // }

      // facTriggers.forEach((el) => el.classList.remove("active"));
      // facBodys.forEach((el) => el.classList.remove("active"));

      btn.classList.toggle("active");
      body.classList.toggle("active");
    });
  });
}

// active tabs for account page
const tabAccount = document.querySelector(".account");

if (tabAccount) {
  const tabsBtns = tabAccount.querySelectorAll(".account-sidebar__item");
  const tabsContent = tabAccount.querySelectorAll(".account-content");

  tabsBtns[0].classList.add("active");
  tabsContent[0].classList.add("active");

  tabsBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      const tabId = e.currentTarget.dataset.account;

      tabsBtns.forEach((el) => {
        el.classList.remove("active");
      });

      tabsContent.forEach((el) => {
        el.classList.remove("active");
      });

      e.currentTarget.classList.add("active");
      const selectedContentTab = document
        .querySelector(`.account-content[data-account="${tabId}"]`)
        .classList.add("active");
    });
  });
}

// active sort menu mobil

const sortTriggerMob = document.querySelector(".catalog__text-sort-mobil");
const sortTriggerDesc = document.querySelector(".catalog-content__text-sort");

if (sortTriggerMob) {
  sortTriggerMob.addEventListener("click", (e) => {
    e.currentTarget.classList.toggle("active");
  });
}

// замена текста в сортировке

// if (sortTriggerDesc) {
//   const menuSortItems = sortTriggerDesc.querySelectorAll("ul li");
//   const textSortTrigerDesc = sortTriggerDesc.querySelector("b");
//   menuSortItems.forEach((el) => {
//     el.addEventListener("click", (e) => {
//       const textSelectSort = e.currentTarget.innerHTML;
//       textSortTrigerDesc.innerHTML = textSelectSort;
//       console.log(textSelectSort);
//     });
//   });
// }

// if (sortTriggerMob) {
//   const menuSortItems = sortTriggerMob.querySelectorAll("ul li");
//   const textSortTrigerMob = sortTriggerMob.querySelector("b");
//   menuSortItems.forEach((el) => {
//     el.addEventListener("click", (e) => {
//       const textSelectSort = e.currentTarget.innerHTML;
//       textSortTrigerMob.innerHTML = textSelectSort;
//       console.log(menuSortItems);
//     });
//   });
// }

const priceSlider = document.querySelector(".sidebar-filter__price-range");
const minPriceInput = document.querySelector(
  ".sidebar-filter__price-number--min"
);
const maxPriceInput = document.querySelector(
  ".sidebar-filter__price-number--max"
);

if (priceSlider) {
  noUiSlider.create(priceSlider, {
    start: [0, 2000],
    connect: true,
    range: {
      min: 0,
      max: 2000,
    },
    step: 100,
  });

  priceSlider.noUiSlider.on("update", function (values, handle) {
    const value = values[handle];
    if (handle) {
      maxPriceInput.value = Math.round(value);
    } else {
      minPriceInput.value = Math.round(value);
    }
  });

  minPriceInput.addEventListener("change", function () {
    priceSlider.noUiSlider.set([this.value, null]);
  });

  maxPriceInput.addEventListener("change", function () {
    priceSlider.noUiSlider.set([null, this.value]);
  });

  // Триггерим AJAX при движении слайдера
  priceSlider.noUiSlider.on("change", function () {
    minPriceInput.dispatchEvent(new Event("change", { bubbles: true }));
    maxPriceInput.dispatchEvent(new Event("change", { bubbles: true }));
  });
}

document.addEventListener("DOMContentLoaded", function () {
  new SlimSelect({
    select: ".my-form .wpcf7-select",
    settings: {
      showSearch: false,
      placeholderText: "Выберите услугу",
    },
  });
});

const swiper = new Swiper(".my-slider", {
  direction: "horizontal",
  loop: true,
  slidesPerView: 1,
  spaceBetween: 20,
  pagination: {
    el: ".my-slider__pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".my-slider__button-next",
    prevEl: ".my-slider__button-prev",
  },
});

const swiper1 = new Swiper(".slider-hero", {
  direction: "horizontal",
  loop: true,
  autoplay: true,
  slidesPerView: 1,
  spaceBetween: 0,
  pagination: {
    el: ".slider-hero__pagination",
    clickable: true,
  },
});

const swiper2 = new Swiper(".slider-demo-category", {
  direction: "horizontal",
  loop: false,
  slidesPerView: 4,
  slidesPerGroup: 4,
  spaceBetween: 30,
  pagination: {
    el: ".slider-demo-category__pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".slider-demo-category__button-next",
    prevEl: ".slider-demo-category__button-prev",
  },
  breakpoints: {
    320: {
      slidesPerView: 2,
      slidesPerGroup: 2,
      spaceBetween: 20,
    },
    840: {
      slidesPerView: 3,
      slidesPerGroup: 3,
      spaceBetween: 25,
    },
    1200: {
      slidesPerView: 4,
      slidesPerGroup: 4,
      spaceBetween: 30,
    },
  },
});

// Слайдер превью
const thumbsSwiper = new Swiper(".full-card-thumbs-slider", {
  spaceBetween: 10,
  slidesPerView: 3,
  freeMode: true,
  watchSlidesProgress: true,
});

// Основной слайдер
const mainSwiper = new Swiper(".full-card-main-slider", {
  spaceBetween: 10,
  thumbs: {
    swiper: thumbsSwiper,
  },
});
// 11111111111111111111111111111111111111111111111111111111111111111111111111
/**
 * Инициализация Swiper слайдера
 *
 * Базовые настройки:
 */
// const swiper = new Swiper(".swiper", {
//   // Основные параметры
//   direction: "horizontal", // Ориентация слайдера ('horizontal' или 'vertical')
//   loop: true, // Бесконечная прокрутка
//   slidesPerView: "auto", // Количество видимых слайдов ('auto' или число)
//   spaceBetween: 20, // Отступ между слайдами (в px)
//   centeredSlides: true, // Центрирование активного слайда
//   speed: 500, // Скорость анимации перехода (мс)

//   // Настройки пагинации (точки)
//   pagination: {
//     el: ".swiper-pagination", // Селектор контейнера для пагинации
//     clickable: true, // Кликабельность точек
//     dynamicBullets: false, // Динамические точки (меняют размер)
//     type: "bullets", // Тип пагинации ('bullets', 'fraction', 'progressbar')
//   },

//   // Настройки навигации (стрелки)
//   navigation: {
//     nextEl: ".swiper-button-next", // Селектор кнопки "Вперед"
//     prevEl: ".swiper-button-prev", // Селектор кнопки "Назад"
//     disabledClass: "swiper-button-disabled", // Класс для неактивных кнопок
//   },

//   // Адаптивность
//   breakpoints: {
//     // Настройки для экранов >= 320px
//     320: {
//       slidesPerView: 1,
//       spaceBetween: 10,
//     },
//     // Настройки для экранов >= 768px
//     768: {
//       slidesPerView: 2,
//       spaceBetween: 20,
//     },
//     // Настройки для экранов >= 1024px
//     1024: {
//       slidesPerView: 3,
//       spaceBetween: 30,
//     },
//   },

// Дополнительные эффекты
//   effect: "slide", // 'slide', 'fade', 'cube', 'coverflow', 'flip'
//   autoplay: {
//     // Автопрокрутка
//     delay: 3000, // Интервал между слайдами (мс)
//     disableOnInteraction: false, // Продолжать после взаимодействия
//   },
// });

/**
 * ИНСТРУКЦИЯ ПО ИСПОЛЬЗОВАНИЮ:
 *
 * 1. HTML-структура:
 *    <div class="swiper">
 *      <div class="swiper-wrapper">
 *        <div class="swiper-slide">Слайд 1</div>
 *        <div class="swiper-slide">Слайд 2</div>
 *      </div>
 *      <!-- Пагинация -->
 *      <div class="swiper-pagination"></div>
 *      <!-- Навигация -->
 *      <div class="swiper-button-prev"></div>
 *      <div class="swiper-button-next"></div>
 *    </div>
 *
 * 2. CSS-рекомендации:
 *    - Для .swiper задать фиксированную высоту
 *    - Для .swiper-slide указать width (фиксированный или процентный)
 *    - Для стрелок/пагинации использовать position: absolute
 *
 * 3. Частые проблемы:
 *    - Обрезание стрелок: добавить padding к .swiper
 *    - Конфликты стилей: повысить специфичность селекторов
 *    - Не работает loop: проверить количество слайдов (нужно минимум 2 дубликата)
 *
 * 4. Документация:
 *    https://swiperjs.com/swiper-api
 */
