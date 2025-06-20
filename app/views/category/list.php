<?php include 'app/views/shares/header.php'; ?>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Danh sách danh mục</h1>
    <a href="/project1/Category/add" class="btn btn-success">
      <i class="bi bi-plus-lg"></i> Thêm danh mục
    </a>
  </div>

  <?php if (empty($categories)): ?>
    <div class="alert alert-warning text-center">
      Chưa có danh mục nào.
    </div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Tên danh mục</th>
            <th>Mô tả</th>
            <th class="text-center">Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($categories as $i => $cat): ?>
            <tr>
              <th scope="row"><?= $i + 1 ?></th>
              <td><?= htmlspecialchars($cat->name, ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= nl2br(htmlspecialchars($cat->description, ENT_QUOTES, 'UTF-8')) ?></td>
              <td class="text-center">
                <a href="/project1/Category/delete/<?= $cat->id ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                  <i class="bi bi-trash"></i> Xóa
                </a>
                <a href="/project1/Category/edit/<?= $cat->id ?>" class="btn btn-sm btn-primary">
                  <i class="bi bi-pencil"></i> Sửa
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>
