document.addEventListener("DOMContentLoaded", () => {
  const filters = document.querySelector(".sidebar__filters");
  const content = document.querySelector(".catalog-content__grid");

  filters.addEventListener("change", (e) => {
    console.log(e.target);
    const formData = new FormData(filters);
    const params = new URLSearchParams(formData);
    params.append("action", "my_filter_products");
    content.innerHTML = "21323";
    fetch(myShopFilters.ajax_url + "?" + params.toString())
      .then((res) => res.text())
      .then((data) => {
        content.innerHTML = data;
      })
      .catch((err) => console.error(err));
  });
});
