<?php include 'app/views/shares/header.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Câu hỏi bảo mật</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f7;
            padding: 30px;
        }
        .form-container {
            background-color: #fff;
            max-width: 500px;
            margin: auto;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }
        select, input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .submit-btn {
            width: 100%;
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Chọn câu hỏi bảo mật</h2>
        <form method="POST" action="/project1/account/saveSecurityQuestion">
            <label for="question_id">Câu hỏi:</label>
            <select id="question_id" name="question_id" required>
                <option value="">-- Chọn câu hỏi --</option>
                <?php foreach ($questions as $q): ?>
                    <option value="<?= $q['id'] ?>"><?= htmlspecialchars($q['content']) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($errors['question_id'])): ?>
                <div class="error"><?= $errors['question_id'] ?></div>
            <?php endif; ?>

            <label for="answer">Câu trả lời:</label>
            <input type="text" id="answer" name="answer" required value="<?= htmlspecialchars($_POST['answer'] ?? '') ?>">
            <?php if (!empty($errors['answer'])): ?>
                <div class="error"><?= $errors['answer'] ?></div>
            <?php endif; ?>

            <button type="submit" class="submit-btn">Lưu câu hỏi bảo mật</button>
        </form>
    </div>
</body>
</html>
