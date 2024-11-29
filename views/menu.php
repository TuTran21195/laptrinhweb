    <!-- end header section -->
    </div>
    <!-- food section -->
    <section class="food_section layout_padding-bottom">
      <div class="container">
        <div class="heading_container heading_center">
          <h2 class= "mt-2" >Menu món ăn</h2>
        </div>

        <div class="col-5 col-5 mt-3 mx-auto ">
          <input type="text" id="search-box" class="form-control align-self-lg-center" placeholder="Tìm kiếm món ăn...">
        </div>

        <ul class="filters_menu">
          <li class="active" data-filter="">Tất cả</li>
          <li data-filter="Bánh" >Bánh</li>
          <li data-filter="Bún" >Bún</li>
          <li data-filter="Canh" >Canh</li>
          <li data-filter="Cơm" >Cơm</li>
          <li data-filter="Nước" >Nước</li>
          <li data-filter="Khác" >Khác</li>
        </ul>

        <div class="filters-content">
          <div class="row d-flex flex-wrap" id="food-items">
            <!-- Food items will be loaded here via AJAX -->
            <div class="col-sm-6 col-lg-4 all pizza">
              <div class="box">
                <div>
                  <!-- hình ảnh của món ăn -->
                  <div class="img-box">
                    <img src="./assets/images/banh/banhca.png" alt="" /> 
                  </div>
                  <div class="detail-box">
                    <h5>Tên món ăn</h5>
                    <p>mô tả món ăn</p>
                    <div class="options">
                      <h6>Giá món ăn</h6>
                      <a href="your-cart-page.html" class="cart-container">
                        <i class="fas fa-shopping-cart cart-icon" style="font-size: 17px; color: aliceblue"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="btn-box">
          <a href="">Xem thêm</a>
        </div> -->
      </div>
    </section>
    <!-- end food section -->

    <!-- jQery -->
    <script src="./assets/js/jquery-3.4.1.min.js"></script>
  <script>

    $(document).ready(function() {
      loadFoodItems();

      function loadFoodItems(type = '', search = '') {
          $.ajax({
              url: './be/khachHang/get_food_items.php',
              method: 'GET',
              data: { type: type , search: search},
              success: function(data) {
                  let foodItems = JSON.parse(data);
                  // let foodItems = data;
                  let html = '';
                  foodItems.forEach(item => {
                    let imagePath = item.hinh_anh.replace('../uploads/', './be/uploads/');
                    // Định dạng giá tiền
                    let formattedPrice = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(item.gia);
                      html += `
                          <div class="col-sm-6 col-lg-4 all">
                              <div class="box">
                                  <div>
                                      <div class="img-box">
                                          <img src="${imagePath}" alt="" />
                                      </div>
                                      <div class="detail-box">
                                          <h5>${item.ten_mon}</h5>
                                          <p>${item.mo_ta}</p>
                                          <div class="options">
                                              <h6>${formattedPrice}</h6>
                                              <a href="#" class="cart-container" data-id="${item.id}">
                                                  <i class="fas fa-shopping-cart cart-icon" style="font-size: 17px; color: aliceblue"></i>
                                              </a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      `;
                  });
                  $('#food-items').html(html);
              }
          });
      }

      $('.filters_menu li').click(function () {
          $('.filters_menu li').removeClass('active');
          $(this).addClass('active');

          var type_mon_an = $(this).attr('data-filter');
          let search = $('#search-box').val();
          console.log(type_mon_an, search); 
          loadFoodItems(type_mon_an, search);
      });

      $('#search-box').on("input", function() {
        let search = $(this).val();
        let type = $('.filters_menu li.active').attr('data-filter') || '';
        console.log(type, search); 
        loadFoodItems(type, search);
      });
  })


  </script>
