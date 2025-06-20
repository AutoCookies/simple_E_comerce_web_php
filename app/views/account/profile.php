<?php include_once 'app/views/shares/header.php'; ?> <!-- Nếu bạn có header layout chung -->

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
          <h4><i class="bi bi-person-circle"></i> Thông Tin Cá Nhân</h4>
        </div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-sm-4 text-muted">Tên đăng nhập:</div>
            <div class="col-sm-8"><?= htmlspecialchars($account->username) ?></div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-4 text-muted">Vai trò:</div>
            <div class="col-sm-8">
              <span class="badge bg-info text-dark text-uppercase"><?= htmlspecialchars($account->role) ?></span>
            </div>
          </div>
          <div class="text-end">
            <a href="/project1/account/edit/<?= $account->id ?>" class="btn btn-outline-primary">
              <i class="bi bi-pencil-square"></i> Chỉnh sửa
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once 'app/views/shares/footer.php'; ?> <!-- Nếu bạn có footer layout -->
