document.addEventListener("DOMContentLoaded", () => {
  const filters = document.querySelector(".sidebar__filters");
  const content = document.querySelector(".catalog-content__grid");
  const resultText = document.querySelector(".catalog-content__subtitle");
  const paginationWrapper = document.querySelector("#pagination");

  const rrr = (numPage = 1) => {
    const formData = new FormData(filters);
    const params = new URLSearchParams(formData);
    params.append("action", "my_filter_products");

    content.innerHTML = "загрузка...";
    fetch(myShopFilters.ajax_url + "?" + params.toString() + `&page=${numPage}`)
      .then((res) => res.json())
      .then((data) => {
        console.log(data.arg);
        content.innerHTML = data.posts;
        // pagination.innerHTML = data.pagination;
        paginationWrapper.innerHTML = data.paginationNew;
        resultText.innerHTML = data.resultNum + " товаров";
      })
      .catch((err) => console.error(err));
  };

  filters.addEventListener("change", (e) => {
    rrr(1);
  });

  paginationWrapper.addEventListener("click", (e) => {
    if (e.target.tagName === "A") {
      e.preventDefault();

      // Достаём номер страницы из href
      const url = new URL(e.target.href);
      const page = url.searchParams.get("paged") || 1;
      console.log("asdasd", url);
      rrr(page);
    }
  });
});
