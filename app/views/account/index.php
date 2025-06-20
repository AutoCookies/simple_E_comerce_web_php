<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
  <h2 class="mb-4">Danh sách tài khoản</h2>
  <?php if (empty($accounts)): ?>
    <div class="alert alert-info">Không có tài khoản nào.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Username</th>
            <th scope="col">Role</th>
            <th scope="col">Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($accounts as $acc): ?>
            <tr>
              <th scope="row"><?= htmlspecialchars($acc['id'] ?? '') ?></th>
              <td><?= htmlspecialchars($acc['username'] ?? '') ?></td>
              <td><?= htmlspecialchars(ucfirst($acc['role'] ?? '')) ?></td>
              <td>
                <a href="/project1/account/edit/<?= htmlspecialchars($acc['id'] ?? '') ?>" class="btn btn-sm btn-success me-2">
                  <i class="bi bi-pencil-fill"></i> Sửa
                </a>
                <a href="/project1/account/delete/<?= htmlspecialchars($acc['id'] ?? '') ?>" onclick="return confirm('Bạn chắc chắn muốn xóa?')" class="btn btn-sm btn-danger">
                  <i class="bi bi-trash-fill"></i> Xóa
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>
