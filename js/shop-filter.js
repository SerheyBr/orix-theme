document.addEventListener("DOMContentLoaded", () => {
  const filters = document.querySelector(".sidebar__filters");
  const content = document.querySelector(".catalog-content__grid");
  const pagination = document.querySelector(".catalog-content__pagination");
  const resultText = document.querySelector(".catalog-content__subtitle");

  filters.addEventListener("change", (e) => {
    console.log(e.target);
    const formData = new FormData(filters);
    const params = new URLSearchParams(formData);
    params.append("action", "my_filter_products");
    content.innerHTML = "21323";
    fetch(myShopFilters.ajax_url + "?" + params.toString())
      .then((res) => res.json())
      .then((data) => {
        console.log(data);
        content.innerHTML = data.posts;
        pagination.innerHTML = data.pagination;
        resultText.innerHTML = data.resultNum + " товаров";
      })
      .catch((err) => console.error(err));
  });
});
