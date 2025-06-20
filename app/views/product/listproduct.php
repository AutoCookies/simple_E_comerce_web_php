<?php
// app/views/product/listproduct.php
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <?php include __DIR__ . '/../shares/header.php'; ?>
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-4">Danh sách sản phẩm</h2>
        <?php if (empty($products)): ?>
            <div class="alert alert-info">Hiện chưa có sản phẩm nào.</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
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
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo htmlspecialchars($product->name); ?></h5>
                                <p class="card-text text-truncate"><?php echo htmlspecialchars($product->description); ?></p>
                                <p class="card-text"><strong>Giá: </strong><?php echo number_format($product->price, 0, ',', '.'); ?> ₫</p>
                                <p class="card-text"><small class="text-muted">Danh mục: <?php echo htmlspecialchars($product->category_name); ?></small></p>
                                <div class="mt-auto">
                                    <a href="/project1/product/show/<?php echo $product->id; ?>" class="btn btn-primary btn-sm">Chi tiết</a>
                                    <a href="/project1/product/addToCart/<?php echo $product->id; ?>" class="btn btn-success btn-sm">Thêm vào giỏ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php include __DIR__ . '/../shares/footer.php'; ?>