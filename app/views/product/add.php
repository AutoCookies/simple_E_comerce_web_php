<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <h1 class="mb-4">Thêm sản phẩm mới</h1>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
              <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <div class="card shadow-sm">
        <div class="card-body">
          <form method="POST"
                action="/project1/Product/save"
                enctype="multipart/form-data"
                onsubmit="return validateForm();">

            <div class="mb-3">
              <label for="name" class="form-label">Tên sản phẩm</label>
              <input type="text"
                     id="name"
                     name="name"
                     class="form-control"
                     required>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Mô tả</label>
              <textarea id="description"
                        name="description"
                        class="form-control"
                        rows="4"
                        required></textarea>
            </div>

            <div class="mb-3">
              <label for="price" class="form-label">Giá</label>
              <input type="number"
                     id="price"
                     name="price"
                     class="form-control"
                     step="0.01"
                     required>
            </div>

            <div class="mb-3">
              <label for="category_id" class="form-label">Danh mục</label>
              <select id="category_id"
                      name="category_id"
                      class="form-select"
                      required>
                <option value="" disabled selected>Chọn danh mục</option>
                <?php foreach ($categories as $category): ?>
                  <option value="<?= $category->id ?>">
                    <?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8') ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-4">
              <label for="image" class="form-label">Hình ảnh</label>
              <input type="file"
                     id="image"
                     name="image"
                     class="form-control"
                     accept="image/*">
              <div class="form-text">Chọn file JPG, PNG,… (nếu có).</div>
            </div>

            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary me-2">
                <i class="bi bi-plus-circle"></i> Thêm sản phẩm
              </button>
              <a href="/project1/Product" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Quay lại
              </a>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
