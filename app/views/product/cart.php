<?php include 'app/views/shares/header.php'; ?>

<div class="container py-4">
  <h1 class="h3 mb-4">Giỏ hàng</h1>

  <?php if (!empty($cart)): ?>
    <div class="table-responsive mb-4">
      <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Giá (VND)</th>
            <th>Số lượng</th>
            <th>Tổng (VND)</th>
            <th class="text-center">Xóa</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $i = 1; 
            $grandTotal = 0;
            foreach ($cart as $id => $item):
              $lineTotal = $item['price'] * $item['quantity'];
              $grandTotal += $lineTotal;
          ?>
            <tr>
              <th scope="row"><?= $i++ ?></th>
              <td>
                <?php if (!empty($item['image'])): ?>
                  <img src="/project1/<?= htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8') ?>"
                       class="img-thumbnail" style="max-width:80px;">
                <?php else: ?>
                  —
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= number_format($item['price'],2,',','.') ?></td>
              <td>
                <form method="POST"
                      action="/project1/Product/updateCart/<?= $id ?>"
                      class="d-flex align-items-center">
                  <input type="number" name="quantity"
                         value="<?= $item['quantity'] ?>"
                         min="1"
                         class="form-control form-control-sm me-2"
                         style="width:70px;">
                  <button class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-arrow-repeat"></i>
                  </button>
                </form>
              </td>
              <td><?= number_format($lineTotal,2,',','.') ?></td>
              <td class="text-center">
                <a href="/project1/Product/removeFromCart/<?= $id ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Xóa sản phẩm khỏi giỏ?');">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="5" class="text-end">Tổng cộng:</th>
            <th><?= number_format($grandTotal,2,',','.') ?></th>
            <th></th>
          </tr>
        </tfoot>
      </table>
    </div>

    <div class="d-flex justify-content-between">
      <a href="/project1/Product" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle"></i> Tiếp tục mua sắm
      </a>
      <a href="/project1/Product/checkout" class="btn btn-success">
        <i class="bi bi-credit-card"></i> Thanh toán
      </a>
    </div>

  <?php else: ?>
    <div class="alert alert-info text-center">
      Giỏ hàng trống.
    </div>
    <div class="text-center">
      <a href="/project1/Product" class="btn btn-success">
        <i class="bi bi-cart-plus"></i> Tiếp tục mua sắm
      </a>
    </div>
  <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>
