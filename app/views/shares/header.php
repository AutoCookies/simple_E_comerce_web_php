<?php
require_once 'app/helpers/AuthHelper.php';
// app/views/shares/header.php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
// Tính tổng số lượng trong giỏ
$cartCount = 0;
if (!empty($_SESSION['cart'])) {
  foreach ($_SESSION['cart'] as $item) {
    $cartCount += (int)$item['quantity'];
  }
}

// Kiểm tra user đã đăng nhập chưa và role
$isLoggedIn = AuthHelper::isLoggedIn();
$loggedUsername = AuthHelper::getUsername();
$isAdmin = AuthHelper::isAdmin();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quản lý sản phẩm</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="/project1/product">Quản lý sản phẩm</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <!-- Left links -->
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="/project1/product/index">Danh sách sản phẩm</a>
          </li>
          <?php if ($isAdmin): ?>
            <li class="nav-item">
              <a class="nav-link" href="/project1/product/add">Thêm sản phẩm</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/project1/category">Danh sách danh mục</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/project1/category/add">Thêm danh mục</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/project1/order">Danh sách đơn hàng</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/project1/account">Danh sách tài khoản</a>
            </li>
          <?php endif; ?>
        </ul>

        <!-- Cart icon + badge và tài khoản -->
        <ul class="navbar-nav ml-auto">
          <!-- Giỏ hàng: chỉ cho user -->
          <?php if ($isLoggedIn && !$isAdmin): ?>
            <li class="nav-item">
              <a class="nav-link position-relative" href="/project1/product/cart">
                <i class="bi bi-cart"></i> Giỏ hàng
                <?php if ($cartCount > 0): ?>
                  <span class="badge badge-pill badge-danger ml-1"><?= $cartCount ?></span>
                <?php endif; ?>
              </a>
            </li>
          <?php endif; ?>

          <?php if ($isLoggedIn && !$isAdmin): ?>
            <li class="nav-item">
              <a class="nav-link" href="/project1/order/history">Lịch sử giao dịch</a>
            </li>
          <?php endif; ?>

          <?php if ($isLoggedIn): ?>
            <!-- Dropdown chứa tên user và logout -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bi bi-person-circle"></i> <?= htmlspecialchars($loggedUsername) ?>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/project1/account/profile">
                  <i class="bi bi-person-lines-fill"></i> Thông tin cá nhân
                </a>
                <a class="dropdown-item" href="/project1/account/logout">
                  <i class="bi bi-box-arrow-right"></i> Đăng xuất
                </a>
              </div>
            </li>
          <?php else: ?>
            <!-- Nếu chưa đăng nhập -->
            <li class="nav-item">
              <a class="nav-link" href="/project1/account/login">
                <i class="bi bi-box-arrow-in-right"></i> Đăng nhập
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/project1/account/register">
                <i class="bi bi-pencil-square"></i> Đăng ký
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Bootstrap JS + jQuery + Popper -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B0UglyR+LyTjoauU1z+Mjit4303QZ6jIW3" crossorigin="anonymous"></script>

  <div class="container mt-4">