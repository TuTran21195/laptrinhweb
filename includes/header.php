<?php
session_start(); 
// tạo session để kiểm tra xem người dùng đã đăng nhập chưa
?>

<html lang="en">
  <head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="Rest man" />
    <meta name="description" content="Quản lý nhà hàng, quán ăn" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="./assets/images/favicon.png" type="" />

    <title>B21DCAT134 - Quán ăn</title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.css" />

    <!--owl slider stylesheet -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <!-- nice select  -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css"
      integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ=="
      crossorigin="anonymous" />
    <!-- font awesome style -->
    <!-- <link href="css/font-awesome.min.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Custom styles for this template -->
    <link href="./assets/css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="./assets/css/responsive.css" rel="stylesheet" />
  </head>
  <body class="sub_page">
    <div class="hero_area">
      <div class="bg-box">
        <img src="./assets/images/hero-bg.jpg" alt="" />
      </div>
      <!-- header section strats -->
      <header class="header_section">
        <div class="container">
          <nav class="navbar navbar-expand-lg custom_nav-container">
            <a class="navbar-brand" href="../index.php">
              <?php if (isset($_SESSION['user_id'])): ?>
                <span>Xin chào, <?php echo $_SESSION['user_name'] ?></span>
              <?php else: ?>
                <span>Quán ăn</span>
              <?php endif; ?>
            </a>

            <button
              class="navbar-toggler"
              type="button"
              data-toggle="collapse"
              data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation">
              <span class=""></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                  <a class="nav-link" href="./index.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./index.php?page=menu">Menu</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./index.php?page=about">About</a>
                </li>
              </ul>
              



              <!-- sau khi user đăng nhập thì có option là user-profile để đổi thông tin user--->
              <?php if (isset($_SESSION['user_id'])): ?>
                  <div class="user_option">
                    <a href="user-profile.html" class="user_link">
                      <i class="fa fa-user" aria-hidden="true"></i>
                      <!-- <span class="sr-only">(current)</span> -->
                    </a>

                    <!-- Kiểm tra role nếu mà là khách hàng: có shoping cart, có nút đặt món link với menu-->
                    <?php if ($_SESSION['role'] == 'customer'): ?> 
                      <a href="##" class="cart-container">
                        <i class="fas fa-shopping-cart cart-icon"></i>
                        <span class="cart-badge">3</span> 
                      </a>
                      <form class="form-inline">
                        <button class="btn my-2 my-sm-0 nav_search-btn" type="submit">
                          <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                      </form>
                      <div class="user_option">
                        <a href=""  class="order_online">Đặt món online</a>
                      </div>
                    
                    <!-- Kiểm tra nếu mà là nhân viên/quản lý thì có thêm nút đưa họ đến trang quản trị của họ -->
                    <?php elseif ($_SESSION['role'] == 'sales'): ?>
                      <div class="user_option">
                        <a href="sales-dashboard.php" class="order_online" >Sales Dashboard</a>
                      </div>
                    <?php elseif ($_SESSION['role'] == 'manager'): ?>
                      <div class="user_option">
                        <a href="manager-dashboard.php"  class="order_online">Manager Dashboard</a>
                      </div>
                    <?php endif; ?>

                    <div class="user_option">
                      <a href= "./be/nguoiDung/logout.php" class="order_online">Đăng xuất</a>
                    </div>

                  </div>
              <!-- khi user chưa đăng nhập -->
              <?php else: ?>
                <div class="user_option">
                  <a href="./views/login-page.html" class="order_online">Đăng nhập</a>
                </div>
              <?php endif; ?>
            </div>
          </nav>
        </div>
      </header>
      <!-- end header section -->
    
