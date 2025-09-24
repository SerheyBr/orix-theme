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
        console.log(data.get);
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

  // const btn = document.querySelector(".ddd");
  // btn.addEventListener("click", (e) => {
  //   console.log("asd");
  //   rrr(2);
  // });

  paginationWrapper.addEventListener("click", (e) => {
    const click = e.target;
    // if(click.dataset.page){

    // }
    console.log(click.dataset.page);
    rrr(click.dataset.page);
  });
});
