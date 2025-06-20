<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Thanh toán</h5>
        </div>
        <div class="card-body">

          <form method="POST"
                action="/project1/Product/processCheckout"
                class="needs-validation"
                novalidate>

            <div class="mb-3">
              <label for="name" class="form-label">Họ tên</label>
              <input type="text"
                     class="form-control"
                     id="name"
                     name="name"
                     required>
              <div class="invalid-feedback">
                Vui lòng nhập họ tên.
              </div>
            </div>

            <div class="mb-3">
              <label for="phone" class="form-label">Số điện thoại</label>
              <input type="tel"
                     class="form-control"
                     id="phone"
                     name="phone"
                     pattern="\d{10,11}"
                     required>
              <div class="invalid-feedback">
                Vui lòng nhập số điện thoại hợp lệ (10–11 chữ số).
              </div>
            </div>

            <div class="mb-3">
              <label for="address" class="form-label">Địa chỉ</label>
              <textarea class="form-control"
                        id="address"
                        name="address"
                        rows="3"
                        required></textarea>
              <div class="invalid-feedback">
                Vui lòng nhập địa chỉ.
              </div>
            </div>

            <div class="d-flex justify-content-between">
              <a href="/project1/Product/cart" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Quay lại giỏ hàng
              </a>
              <button type="submit" class="btn btn-success">
                <i class="bi bi-credit-card"></i> Thanh toán
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</div>

<script>
// Bootstrap 5 custom validation
(() => {
  'use strict'
  const forms = document.querySelectorAll('.needs-validation')
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      form.classList.add('was-validated')
    }, false)
  })
})()
</script>

<?php include 'app/views/shares/footer.php'; ?>
