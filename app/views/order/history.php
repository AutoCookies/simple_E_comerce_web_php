<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-10">

      <h5 class="mb-4">Lịch sử đơn hàng của bạn</h5>

      <?php if (empty($orders)): ?>
        <div class="alert alert-warning text-center">Bạn chưa có đơn hàng nào.</div>
      <?php else: ?>
        <?php foreach ($orders as $order): ?>
          <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
              <strong>Đơn hàng #<?= $order['order_id'] ?></strong>
              <span class="float-end"><?= $order['created_at'] ?></span>
            </div>
            <div class="card-body">
              <p><strong>Người nhận:</strong> <?= htmlspecialchars($order['receiver_name']) ?></p>
              <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['address']) ?></p>
              <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['phone']) ?></p>
              <p><strong>Trạng thái:</strong> <span class="badge bg-success"><?= $order['status'] ?></span></p>
              <p class="mt-3"><strong>Tổng tiền:</strong> <?= number_format($order['total_price'], 0, ',', '.') ?> ₫</p>

              <h6 class="mt-4">Chi tiết sản phẩm:</h6>
              <ul class="list-group">
                <?php foreach ($order['details'] as $item): ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= htmlspecialchars($item['product_name']) ?> (x<?= $item['quantity'] ?>)
                    <span>Đơn giá: <?= number_format($item['price'], 0, ',', '.') ?> ₫</span>
                    <span class="badge">Tổng tiền: <?= number_format($item['total'], 0, ',', '.') ?> ₫</span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

    </div>
  </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
