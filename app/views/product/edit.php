<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Sửa sản phẩm</h5>
        </div>
        <div class="card-body">

          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                  <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form method="POST"
                action="/project1/Product/update"
                enctype="multipart/form-data"
                onsubmit="return validateForm();">

            <input type="hidden" name="id" value="<?= $product->id; ?>">

            <div class="mb-3">
              <label for="name" class="form-label">Tên sản phẩm</label>
              <input type="text"
                     id="name"
                     name="name"
                     class="form-control"
                     value="<?= htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>"
                     required>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Mô tả</label>
              <textarea id="description"
                        name="description"
                        class="form-control"
                        rows="4"
                        required><?= htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>

            <div class="mb-3">
              <label for="price" class="form-label">Giá</label>
              <input type="number"
                     id="price"
                     name="price"
                     class="form-control"
                     step="0.01"
                     value="<?= htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>"
                     required>
            </div>

            <div class="mb-3">
              <label for="category_id" class="form-label">Danh mục</label>
              <select id="category_id"
                      name="category_id"
                      class="form-select"
                      required>
                <option value="" disabled>Chọn danh mục</option>
                <?php foreach ($categories as $category): ?>
                  <option value="<?= $category->id; ?>" <?= $category->id == $product->category_id ? 'selected' : '';?>>
                    <?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
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
              <input type="hidden"
                     name="existing_image"
                     value="<?= htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>">
              <?php if ($product->image): ?>
                <div class="mt-2">
                  <img src="/<?= htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                       alt="Product Image"
                       class="img-thumbnail"
                       style="max-width: 150px;">
                </div>
              <?php endif; ?>
            </div>

            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-success me-2">
                <i class="bi bi-save"></i> Lưu thay đổi
              </button>
              <a href="/project1/Product/" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
              </a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
