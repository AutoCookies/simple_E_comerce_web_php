<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu</title>
    <style>
        /* Giống style form trước */
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Quên mật khẩu</h2>
        <form method="POST" action="/project1/account/verifySecurityAnswers">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                <?php if (!empty($errors['username'])): ?>
                    <div class="error"><?= $errors['username'] ?></div>
                <?php endif; ?>
            </div>

            <div class="section-title">Các câu hỏi bảo mật</div>
            <?php 
            // Hiển thị tất cả câu hỏi bảo mật mà user đã lưu (sẽ load bằng controller trước khi include view)
            if (!empty($questionsForUser)):
                foreach ($questionsForUser as $q):
            ?>
                    <div class="form-group">
                        <label for="answer_<?= $q['id'] ?>">
                            <?= htmlspecialchars($q['question_text']) ?>
                        </label>
                        <input
                            type="text"
                            id="answer_<?= $q['id'] ?>"
                            name="answer_<?= $q['id'] ?>"
                            value="<?= htmlspecialchars($_POST['answer_' . $q['id']] ?? '') ?>"
                        >
                        <?php if (!empty($errors['answer_' . $q['id']])): ?>
                            <div class="error"><?= $errors['answer_' . $q['id']] ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Vui lòng nhập username để hiển thị câu hỏi bảo mật.</p>
            <?php endif; ?>

            <button type="submit" class="submit-btn">Xác minh</button>
        </form>
    </div>
</body>
</html>
