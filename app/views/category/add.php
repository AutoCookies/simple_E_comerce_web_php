<?php include 'app/views/shares/header.php'; ?>

<div class="container py-4">
  <h1 class="h3 mb-4">Thêm danh mục mới</h1>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <div class="card shadow-sm">
    <div class="card-body">
      <form method="POST" action="/project1/Category/save" class="row g-3">
        <div class="col-12">
          <label for="name" class="form-label">Tên danh mục<span class="text-danger">*</span></label>
          <input
            type="text"
            id="name"
            name="name"
            class="form-control"
            value="<?= htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
            required
          >
        </div>

        <div class="col-12">
          <label for="description" class="form-label">Mô tả</label>
          <textarea
            id="description"
            name="description"
            class="form-control"
            rows="4"
          ><?= htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <div class="col-12 d-flex justify-content-end">
          <button type="submit" class="btn btn-primary me-2">
            <i class="bi bi-save"></i> Lưu
          </button>
          <a href="/project1/Category" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Hủy
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
