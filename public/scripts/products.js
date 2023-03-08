$(document).ready(function() {
  // Set initial page number
  let page = 1

  // Load products list and pagination links for the given page number
  function loadProducts(page) {
    $.ajax({
      url: '/api/products/getlist',
      dataType: 'json',
      type: 'GET',
      data: {
        page: page,
      },
      success: function(response) {
        let i
        // Render products list
        $("#products-list").html('');
        for (i = 0; i < response.data.length; i++) {
          const product = response.data[i]
          appendProductToList(product)
        }

        // Render pagination links
        let products_html = ''
        // console.log(response.links)

        // If pagination links exists
        if (response.links) {

          // First page
          if (response.links.first !== "") {
            products_html += `<a data-page="${response.links.first}">
<!--                <img src="/public/icons/left_arrow.svg" class="u-pagination-icon-img" alt="">-->
                &laquo;
              </a>
              `;
          }

          // Prev
          if (response.links.prev) {
            products_html += `<a data-page="${response.links.prev}">${response.links.prev}</a>`
          }

          // Current page
          products_html += `<a data-page="${response.links.self}" class='active'>${response.links.self}</a>`

          // Next
          if (response.links.next) {
            products_html += `<a data-page="${response.links.next}">${response.links.next}</a>`
          }


          // Last page
          if (response.links.last !== "") {
            products_html += `<a data-page="${response.links.last}">
<!--            <img src="/public/icons/right_arrow.svg" class="u-pagination-icon-img" alt="">-->
                &raquo;
              </a>
              `;
          }

          $("#pagination").html(products_html)
        }
      }
    });
  }

  // Load products list and pagination links for initial page
  loadProducts(page);

  // Handle pagination link clicks
  $(document).on("click", ".pagination a", function () {
    const page = $(this).attr("data-page");
    const currentPage= document.querySelector(".pagination a.active").getAttribute("data-page");
    // Preventing requests for current page data many times
    if (page !== null && page !== currentPage) {
      loadProducts(page);
    }
  });

  // Append product to table list
  function appendProductToList(product) {
    $('#products-list').append(`
      <tr class="u-table-row">
          <td class="u-table-cell-4">${product.name}</td>
          <td class="u-table-cell-5">${product.sku}</td>
          <td class="u-table-cell-actions">
              <span class="u-icon"><img src="/public/images/1828911.png" alt=""  class="u-icon-img"></span>
              <span class="u-icon"><img src="/public/images/565491.png" alt="" class="u-icon-img"></span>
          </td>
      </tr>
    `);
  }

  // Create new product
  $('#product_add_form').submit(function(event) {
    // let json
    event.preventDefault();
    $.ajax({
      type: $(this).attr('method'),
      url: $(this).attr('action'),
      data: $(this).serialize(),
      cache: false,
      success: function(response) {
        // console.log(response)
        if (response.data) {
          appendProductToList(response.data)
        }
        if (response.message) {
          alert(response.message);
        }
      },
    });
  });

  // Generate sku for product
  const skuGenBtn = document.getElementById("sku_generate_btn");

  skuGenBtn.addEventListener("click", (event) => {
    event.preventDefault();
    $.ajax({
      type: 'GET',
      url: '/api/sku/generate',
      success: function(response) {
        // console.log(response)
        if (response.data) {
          document.getElementById("generatedSkuInput").value = response.data;
        } else {
          alert(response.message);
        }
      },
    });
  });


  // Edit existing product

  // Delete product
});

