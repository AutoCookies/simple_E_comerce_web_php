<?php
// app/views/order/list.php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/OrderModel.php';
require_once __DIR__ . '/../../models/OrderDetailsModel.php';
require_once __DIR__ . '/../shares/header.php';

$db           = (new Database())->getConnection();
$orderModel   = new OrderModel($db);
$detailsModel = new OrderDetailsModel($db);
$orders       = $orderModel->getOrders();
?>

<div class="container py-4">
  <h1 class="h3 mb-4">Danh sách đơn hàng</h1>

  <?php if (empty($orders)): ?>
    <div class="alert alert-warning text-center">Chưa có đơn hàng nào.</div>
  <?php else: ?>
    <div class="accordion" id="orderAccordion">
      <?php foreach ($orders as $order): ?>
        <div class="accordion-item mb-3">
          <h2 class="accordion-header" id="heading-<?= $order->id ?>">
            <button class="accordion-button collapsed d-flex align-items-center"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse-<?= $order->id ?>"
                    aria-expanded="false"
                    aria-controls="collapse-<?= $order->id ?>">

              <!-- Order info -->
              <div class="me-auto">
                <strong>Đơn #<?= $order->id ?></strong> —
                <?= htmlspecialchars($order->name, ENT_QUOTES, 'UTF-8') ?>
                <span class="badge ms-2
                  <?php
                    switch ($order->status) {
                      case 'đã giao':   echo 'bg-success'; break;
                      case 'đang giao': echo 'bg-warning text-dark'; break;
                      default:          echo 'bg-secondary';
                    }
                  ?>">
                  <?= $order->status ?>
                </span>
              </div>

              <!-- Action buttons -->
              <div class="btn-group btn-group-sm">
                <a href="/project1/Order/edit/<?= $order->id ?>"
                   class="btn btn-outline-primary"
                   title="Sửa trạng thái">
                  <i class="bi bi-pencil"></i>
                </a>
                <a href="/project1/Order/delete/<?= $order->id ?>"
                   class="btn btn-outline-danger"
                   onclick="return confirm('Xác nhận xóa?')"
                   title="Xóa đơn">
                  <i class="bi bi-trash"></i>
                </a>
              </div>
            </button>
          </h2>

          <div id="collapse-<?= $order->id ?>"
               class="accordion-collapse collapse"
               aria-labelledby="heading-<?= $order->id ?>"
               data-bs-parent="#orderAccordion">
            <div class="accordion-body">

              <!-- Thông tin chung -->
              <div class="row mb-3">
                <div class="col-12 col-md-4"><strong>Ngày:</strong> <?= $order->created_at ?></div>
                <div class="col-12 col-md-4"><strong>Phone:</strong> <?= htmlspecialchars($order->phone, ENT_QUOTES, 'UTF-8') ?></div>
                <div class="col-12 col-md-4"><strong>Địa chỉ:</strong><br><?= nl2br(htmlspecialchars($order->address, ENT_QUOTES, 'UTF-8')) ?></div>
              </div>

              <!-- Bảng chi tiết đơn hàng -->
              <?php $details = $detailsModel->getByOrderId((int)$order->id); ?>
              <?php if (empty($details)): ?>
                <div class="alert alert-info">Không có chi tiết đơn hàng.</div>
              <?php else: ?>
                <div class="table-responsive">
                  <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                      <tr>
                        <th>#</th>
                        <th>Product ID</th>
                        <th>Số lượng</th>
                        <th>Giá đơn vị (VND)</th>
                        <th>Tổng (VND)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($details as $i => $d): ?>
                        <tr>
                          <td><?= $i + 1 ?></td>
                          <td><?= $d->product_id ?></td>
                          <td><?= $d->quantity ?></td>
                          <td><?= number_format($d->price, 2, ',', '.') ?></td>
                          <td><?= number_format($d->total, 2, ',', '.') ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              <?php endif; ?>

            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php require __DIR__ . '/../shares/footer.php'; ?>
