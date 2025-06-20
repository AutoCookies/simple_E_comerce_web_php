<?php include 'app/views/shares/header.php'; ?>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Danh sách sản phẩm</h1>
    <a href="/project1/Product/add" class="btn btn-success">
      <i class="bi bi-plus-lg"></i> Thêm sản phẩm mới
    </a>
  </div>

  <?php if (empty($products)): ?>
    <div class="alert alert-warning text-center">
      Chưa có sản phẩm nào.
    </div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Tên</th>
            <th>Hình ảnh</th>
            <th>Mô tả</th>
            <th>Giá (VND)</th>
            <th>Danh mục</th>
            <th class="text-center">Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $i => $product): ?>
            <tr>
              <th scope="row"><?= $i + 1 ?></th>
              <td>
                <a href="/project1/Product/show/<?= $product->id ?>">
                  <?= htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8') ?>
                </a>
              </td>
              <td>
                <?php if ($product->image): ?>
                  <img src="/project1/<?= htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8') ?>"
                       alt="Product Image"
                       class="img-thumbnail"
                       style="max-width: 80px;">
                <?php else: ?>
                  <span class="text-muted">—</span>
                <?php endif; ?>
              </td>
              <td><?= nl2br(htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8')) ?></td>
              <td><?= number_format($product->price, 2, ',', '.') ?></td>
              <td><?= htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8') ?></td>
              <td class="text-center">
                <div class="btn-group btn-group-sm" role="group" aria-label="Actions">
                  <a href="/project1/Product/edit/<?= $product->id ?>"
                     class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Sửa
                  </a>
                  <a href="/project1/Product/delete/<?= $product->id ?>"
                     class="btn btn-danger"
                     onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                    <i class="bi bi-trash"></i> Xóa
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>
