<?php include 'app/views/shares/header.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f7;
            padding: 30px;
        }
        .form-container {
            background-color: #fff;
            max-width: 400px;
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
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
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
        <h2>Đăng ký tài khoản</h2>
        <form method="POST" action="/project1/account/save">
            <div class="form-group">
                <label for="fullname">Họ và tên:</label>
                <input type="text" id="fullname" name="fullname" value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>">
                <?php if (!empty($errors['fullname'])): ?>
                    <div class="error"><?= $errors['fullname'] ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                <?php if (!empty($errors['username'])): ?>
                    <div class="error"><?= $errors['username'] ?></div>
                <?php endif; ?>
                <?php if (!empty($errors['account'])): ?>
                    <div class="error"><?= $errors['account'] ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password">
                <?php if (!empty($errors['password'])): ?>
                    <div class="error"><?= $errors['password'] ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="confirmpassword">Xác nhận mật khẩu:</label>
                <input type="password" id="confirmpassword" name="confirmpassword">
                <?php if (!empty($errors['confirmPass'])): ?>
                    <div class="error"><?= $errors['confirmPass'] ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="submit-btn">Đăng ký</button>
        </form>
    </div>
</body>
</html>
