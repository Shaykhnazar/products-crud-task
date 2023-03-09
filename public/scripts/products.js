$(document).ready(function() {
  // Set initial page number
  let page = 1

  // Load products list and pagination links for the given page number
  function loadProducts(page) {
    window.currentProductsPage = page
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

  function getOneProduct(id, callback) {
    $.ajax({
      url: '/api/products/getone',
      type: 'GET',
      dataType: 'json',
      data: {
        id: id,
      },
      success: function(response) {
        callback(response.data);
      }
    });
  }

  // Load products list and pagination links for initial page
  loadProducts(page);

  // Handle pagination link clicks
  $(document).on("click", ".pagination a", function () {
    const page = $(this).attr("data-page");
    const currentPage = document.querySelector(".pagination a.active").getAttribute("data-page");
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
            <button class="u-icon product_update_btn" data-id="${product.id}">
              <img src="/public/images/1828911.png" alt="" class="u-icon-img">
            </button>
            <button class="u-icon product_delete_btn" data-id="${product.id}">
              <img src="/public/images/565491.png" alt="" class="u-icon-img">
            </button>
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
  $(document).on("click", ".sku_generate_btn", function(event) {
    event.preventDefault();
    // get data-form attribute value of the form element
    const dataForm = this.closest('form').dataset.form;

    $.ajax({
      type: 'GET',
      url: '/api/sku/generate',
      success: function(response) {
        if (response.data) {
          // select the input element by name and data-form attribute value
          const skuInput = document.querySelector(`input[name="sku"][data-form="${dataForm}"]`);
          skuInput.value = response.data;
        } else {
          alert(response.message);
        }
      },
    });
  });


  // Edit existing product
  $('#product_edit_form').submit(function(event) {
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
          loadProducts(window.currentProductsPage)
          closeModalById("editModal")
        }
        if (response.message) {
          alert(response.message);
        }
      },
    });
  });

  // Delete product
  function deleteProduct(id, callback) {
    $.ajax({
      url: '/api/products/delete',
      type: 'POST',
      dataType: 'json',
      data: {
        id: id,
      },
      success: function(response) {
        callback(response);
      }
    });
  }


  /********************* Edit Modal ********************************************************/
  const modal = document.getElementById("editModal")

  // When the user clicks the button, open the modal
  $(document).on("click", ".product_update_btn", function(event) {
    event.preventDefault();
    let productId = this.getAttribute("data-id");

    // Call the getOneProduct function with a callback function
    getOneProduct(productId, function(product) {
      // Select the input fields of the modal and set their values
      const nameInput = modal.querySelector('input[name="name"]');
      const skuInput = modal.querySelector('input[name="sku"]');
      const idInput = modal.querySelector('input[name="id"]');

      nameInput.value = product['name'];
      skuInput.value = product['sku'];
      idInput.value = product['id'];

      modal.style.display = "block";
    });
  });

  // When the user clicks on <span> (x), close the modal
  $(document).on("click", ".close_model_span", function() {
    modal.style.display = "none";
  })

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  }

  /********************* Delete Modal ******************************************************/
  const deleteModal = document.getElementById("deleteModal")

  // When the user clicks the button, open the modal
  $(document).on("click", ".product_delete_btn", function(event) {
    event.preventDefault();
    let productId = this.getAttribute("data-id");
    // Set product id to data attribute
    const deleteBtn = document.querySelector(`button[class="deletebtn"]`);
    deleteBtn.setAttribute('data-product-id', productId)

    deleteModal.style.display = "block";
  });


  $(document).on("click", ".deletebtn", function(event) {
    event.preventDefault();
    let productId = this.getAttribute("data-product-id");
    deleteProduct(productId, function(response) {
      if (response.data === true) {
        loadProducts(window.currentProductsPage)
        closeModalById('deleteModal')
        alert(response.message)
      } else {
        alert(response.message)
      }
    });
  });

  $(document).on("click", ".cancelbtn", function(event) {
    event.preventDefault();
    closeModalById('deleteModal')
  });

  // When the user clicks on <span> (x), close the modal
  $(document).on("click", ".close_model_span", function() {
    deleteModal.style.display = "none";
  })

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target === modal) {
      deleteModal.style.display = "none";
    }
  }

  function closeModalById(modalId) {
    let modal = document.getElementById(modalId)
    modal.style.display = "none";
  }
});

