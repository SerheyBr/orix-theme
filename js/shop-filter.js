document.addEventListener("DOMContentLoaded", () => {
  // if (document.querySelector(".watch")) {
  const filters = document.querySelector(".sidebar__filters");
  const paginationWrapper = document.querySelector("#pagination");
  const sortMain = document.querySelectorAll(".sort-container");
  const resultText = document.querySelector(".catalog-content__subtitle");
  const content = document.querySelector(".catalog-content__grid");
  const laoding = document.querySelector(".laoding");
  const btnReset = document.querySelector(".sidebar-filter__reset");
  let category;
  let isSail = "";
  if (document.querySelector(".watch")) {
    category = "watch";
  } else if (document.querySelector(".straps")) {
    category = "straps";
  } else if (document.querySelector(".sail")) {
    category = "watch";
    isSail = "&sail=sail";
  }

  const ajaxFn = (filters, sort, page) => {
    laoding.style.display = "flex";
    fetch(
      myShopFilters.ajax_url +
        "?" +
        filters +
        sort +
        page +
        `&category=${category}` +
        isSail
    )
      .then((res) => res.json())
      .then((data) => {
        // console.log(data.get);
        console.log(data.arg);
        content.innerHTML = data.posts;
        paginationWrapper.innerHTML = data.paginationNew;
        resultText.innerHTML = data.resultNum;

        sortMain.forEach((el) => {
          const title = el.querySelector(".sort-container__title");
          const list = el.querySelector(".sort-container__list");

          title.innerHTML = data.sortContent.title;
          list.innerHTML = data.sortContent.list;
        });

        laoding.style.display = "none";
      });
  };

  const getFilters = (newFilter) => {
    const filters = document.querySelector(".sidebar__filters");
    const formData = new FormData(filters);
    const params = new URLSearchParams(formData);
    params.append("action", "my_filter_products");

    if (newFilter) {
      return newFilter.toString();
    } else {
      return params.toString();
    }
  };

  const getSort = (newSort) => {
    const sort1Text = document.querySelector(".catalog__text-sort p b");
    const sort2Text = document.querySelector(".catalog__text-sort-mobil p b");
    const sort3Text = document.querySelector(".catalog-content__text-sort p b");

    if (newSort) {
      return `&sort=${newSort}`;
    }

    if (
      sort1Text.innerHTML === sort2Text.innerHTML &&
      sort2Text.innerHTML === sort3Text.innerHTML
    ) {
      return `&sort=${sort3Text.dataset.sort}`;
    } else {
      return;
    }
  };
  const getPage = (newPage) => {
    const paginationWrapper = document.querySelector("#pagination");
    const numPagination = paginationWrapper.querySelector(".is-active");
    if (newPage) {
      return `&page=${newPage}`;
    } else {
      return `&page=${numPagination.dataset.page}`;
    }
  };

  filters.addEventListener("change", (e) => {
    const filters = document.querySelector(".sidebar__filters");
    const formData = new FormData(filters);
    const params = new URLSearchParams(formData);
    params.append("action", "my_filter_products");
    // тут надо вставить соотвествующее значение а в остальные аргументы вставить собранную заранее информацию
    ajaxFn(getFilters(params), getSort(), getPage(1));
  });

  sortMain.forEach((el) => {
    el.addEventListener("click", (e) => {
      const li = e.target.closest("li");
      if (!li || !el.contains(li)) return;
      const variantSorting = li.dataset.sort;
      ajaxFn(getFilters(), getSort(variantSorting), getPage(1));
    });
  });

  paginationWrapper.addEventListener("click", (e) => {
    const btn = e.target.closest("button"); // ищем ближайший <button>
    if (!btn || !paginationWrapper.contains(btn)) return; // если клик не по кнопке — выходим
    const page = btn.dataset.page;

    ajaxFn(getFilters(), getSort(), getPage(page));
  });

  btnReset.addEventListener("click", () => {
    ajaxFn(getFilters(), getSort(), getPage());
  });
  // }

  // if (document.querySelector(".straps")) {
  //   const filters = document.querySelector(".sidebar__filters");
  //   const paginationWrapper = document.querySelector("#pagination");
  //   const sortMain = document.querySelectorAll(".sort-container");
  //   const resultText = document.querySelector(".catalog-content__subtitle");
  //   const content = document.querySelector(".catalog-content__grid");
  //   const laoding = document.querySelector(".laoding");
  //   const btnReset = document.querySelector(".sidebar-filter__reset");

  //   const ajaxFn = (filters, sort, page, category = "straps") => {
  //     laoding.style.display = "flex";
  //     fetch(
  //       myShopFilters.ajax_url +
  //         "?" +
  //         filters +
  //         sort +
  //         page +
  //         `&category=${category}`
  //     )
  //       .then((res) => res.json())
  //       .then((data) => {
  //         // console.log(data.get);
  //         console.log(data.sortContent);
  //         content.innerHTML = data.posts;
  //         paginationWrapper.innerHTML = data.paginationNew;
  //         resultText.innerHTML = data.resultNum;

  //         sortMain.forEach((el) => {
  //           const title = el.querySelector(".sort-container__title");
  //           const list = el.querySelector(".sort-container__list");

  //           title.innerHTML = data.sortContent.title;
  //           list.innerHTML = data.sortContent.list;
  //         });

  //         laoding.style.display = "none";
  //       });
  //   };

  //   const getFilters = (newFilter) => {
  //     const filters = document.querySelector(".sidebar__filters");
  //     const formData = new FormData(filters);
  //     const params = new URLSearchParams(formData);
  //     params.append("action", "my_filter_products");

  //     if (newFilter) {
  //       return newFilter.toString();
  //     } else {
  //       return params.toString();
  //     }
  //   };

  //   const getSort = (newSort) => {
  //     const sort1Text = document.querySelector(".catalog__text-sort p b");
  //     const sort2Text = document.querySelector(".catalog__text-sort-mobil p b");
  //     const sort3Text = document.querySelector(
  //       ".catalog-content__text-sort p b"
  //     );

  //     if (newSort) {
  //       return `&sort=${newSort}`;
  //     }

  //     if (
  //       sort1Text.innerHTML === sort2Text.innerHTML &&
  //       sort2Text.innerHTML === sort3Text.innerHTML
  //     ) {
  //       return `&sort=${sort3Text.dataset.sort}`;
  //     } else {
  //       return;
  //     }
  //   };
  //   const getPage = (newPage) => {
  //     const paginationWrapper = document.querySelector("#pagination");
  //     const numPagination = paginationWrapper.querySelector(".is-active");
  //     if (newPage) {
  //       return `&page=${newPage}`;
  //     } else {
  //       return `&page=${numPagination.dataset.page}`;
  //     }
  //   };

  //   filters.addEventListener("change", (e) => {
  //     const filters = document.querySelector(".sidebar__filters");
  //     const formData = new FormData(filters);
  //     const params = new URLSearchParams(formData);
  //     params.append("action", "my_filter_products");
  //     // тут надо вставить соотвествующее значение а в остальные аргументы вставить собранную заранее информацию
  //     ajaxFn(getFilters(params), getSort(), getPage(1));
  //   });

  //   sortMain.forEach((el) => {
  //     el.addEventListener("click", (e) => {
  //       const li = e.target.closest("li");
  //       if (!li || !el.contains(li)) return;
  //       const variantSorting = li.dataset.sort;
  //       ajaxFn(getFilters(), getSort(variantSorting), getPage(1));
  //     });
  //   });

  //   paginationWrapper.addEventListener("click", (e) => {
  //     const btn = e.target.closest("button"); // ищем ближайший <button>
  //     if (!btn || !paginationWrapper.contains(btn)) return; // если клик не по кнопке — выходим
  //     const page = btn.dataset.page;

  //     ajaxFn(getFilters(), getSort(), getPage(page));
  //   });

  //   btnReset.addEventListener("click", () => {
  //     ajaxFn(getFilters(), getSort(), getPage());
  //   });
  // }
});
