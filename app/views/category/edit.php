<?php include 'app/views/shares/header.php'; ?>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
          <h5 class="mb-0">Chỉnh sửa danh mục</h5>
        </div>
        <div class="card-body">

          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach ($errors as $e): ?>
                  <li><?= htmlspecialchars($e, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form method="POST" action="/project1/Category/update" class="row g-3">
            <input type="hidden" name="id" value="<?= htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8') ?>">

            <div class="col-12">
              <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
              <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                value="<?= htmlspecialchars($_POST['name'] ?? $category->name, ENT_QUOTES, 'UTF-8') ?>"
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
              ><?= htmlspecialchars($_POST['description'] ?? $category->description, ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <div class="col-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-success me-2">
                <i class="bi bi-save"></i> Lưu thay đổi
              </button>
              <a href="/project1/Category" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Hủy
              </a>
            </div>
          </form>

        </div>
      </div>

    </div>
  </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
