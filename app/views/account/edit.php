<h2>Chỉnh sửa tài khoản</h2>

<style>
    form {
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fafafa;
        font-family: Arial, sans-serif;
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #333;
    }

    input[type="text"], select {
        width: 100%;
        padding: 8px 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 15px;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus, select:focus {
        border-color: #4CAF50;
        outline: none;
    }

    button {
        background-color: #4CAF50;
        color: white;
        font-weight: 600;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #45a049;
    }
</style>

<form method="POST" action="/project1/account/update">
    <input type="hidden" name="id" value="<?= htmlspecialchars($account->id) ?>">

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?= htmlspecialchars($account->username) ?>" required>

    <label for="role">Role:</label>
    <select id="role" name="role" required>
        <option value="user" <?= ($account->role == 'user') ? 'selected' : '' ?>>User</option>
        <option value="admin" <?= ($account->role == 'admin') ? 'selected' : '' ?>>Admin</option>
    </select>

    <button type="submit">Cập nhật</button>
</form>
