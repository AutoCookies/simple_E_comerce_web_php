<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu</title>
    <style>
        /* Giống style form trước */
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Đặt lại mật khẩu</h2>
        <form method="POST" action="/project1/account/resetPassword">
            <div class="form-group">
                <label for="password">Mật khẩu mới:</label>
                <input type="password" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="confirmpassword">Xác nhận mật khẩu mới:</label>
                <input type="password" id="confirmpassword" name="confirmpassword">
            </div>
            <button type="submit" class="submit-btn">Cập nhật mật khẩu</button>
        </form>
    </div>
</body>
</html>
