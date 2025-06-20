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
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 16px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 4px;
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
        <h2>Trả lời câu hỏi bảo mật</h2>
        <p>Vui lòng trả lời 3 câu hỏi dưới để hoàn tất đăng ký.</p>
        <form method="POST" action="/project1/question/save">
            <?php foreach ($questions as $q): ?>
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
            <button type="submit" class="submit-btn">Lưu câu trả lời</button>
        </form>
    </div>
</body>
</html>
