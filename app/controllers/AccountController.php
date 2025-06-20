<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');

class AccountController
{
    private $accountModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    public function register()
    {
        include_once 'app/views/account/register.php';
    }

    public function login()
    {
        include_once 'app/views/account/login.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $name = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $errors = [];

            if (empty($username)) {
                $errors['username'] = "Vui lòng nhập username!";
            }
            if (empty($name)) {
                $errors['fullname'] = "Vui lòng nhập họ tên!";
            }
            if (empty($password)) {
                $errors['password'] = "Vui lòng nhập mật khẩu!";
            } else {
                // Ràng buộc: ít nhất 1 số và 1 ký tự đặc biệt
                if (!preg_match('/[0-9]/', $password)) {
                    $errors['password'] = "Mật khẩu phải chứa ít nhất một chữ số!";
                } elseif (!preg_match('/[\W_]/', $password)) {
                    $errors['password'] = "Mật khẩu phải chứa ít nhất một ký tự đặc biệt!";
                }
            }

            if ($password !== $confirmPassword) {
                $errors['confirmPass'] = "Mật khẩu và xác nhận mật khẩu không khớp!";
            }

            $account = $this->accountModel->getAccountByUsername($username);
            if ($account) {
                $errors['account'] = "Tài khoản này đã được đăng ký!";
            }

            if (count($errors) > 0) {
                include_once 'app/views/account/register.php';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                $role = 'user'; // Mặc định role
                $result = $this->accountModel->save($username, $name, $hashedPassword, $role);

                if ($result) {
                    header('Location: /project1/account/login');
                    exit;
                } else {
                    echo "Đăng ký thất bại!";
                }
            }
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /project1/account/login');
        exit;
    }

    public function checkLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            session_start();

            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $account = $this->accountModel->getAccountByUsername($username);

            if ($account) {
                if (password_verify($password, $account->password)) {
                    // ✅ Sửa tại đây: Đảm bảo gán đúng format $_SESSION['user']
                    $_SESSION['user'] = [
                        'id'       => $account->id,       // <-- Gán ID từ DB
                        'username' => $account->username,
                        'role'     => $account->role
                    ];

                    // Điều hướng theo role từ DB
                    if ($account->role === 'admin') {
                        header('Location: /project1/product');
                    } else {
                        header('Location: /project1/product');
                    }
                    exit;
                } else {
                    echo "Mật khẩu không đúng.";
                }
            } else {
                echo "Không tìm thấy tài khoản.";
            }
        }
    }

    // Hiển thị danh sách tài khoản
    public function index()
    {
        $accounts = $this->accountModel->getAllAccounts();
        include_once 'app/views/account/index.php'; // Tạo view này để hiển thị danh sách
    }

    // Xóa tài khoản
    public function delete($id)
    {
        if ($this->accountModel->deleteAccount($id)) {
            header("Location: /project1/account/index");
            exit;
        } else {
            echo "Xóa tài khoản thất bại!";
        }
    }

    // Hiển thị form sửa
    public function edit($id)
    {
        $account = $this->accountModel->getAccountById($id);
        include_once 'app/views/account/edit.php'; // Tạo view này để hiển thị form chỉnh sửa
    }

    // Lưu chỉnh sửa tài khoản
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $username = $_POST['username'];
            $role = $_POST['role'];

            $result = $this->accountModel->updateAccount($id, $username, $role);

            if ($result) {
                // Nếu đang cập nhật chính mình thì cập nhật session
                if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $id) {
                    $_SESSION['user']['role'] = $role;
                    $_SESSION['user']['username'] = $username;
                }

                header("Location: /project1/account/index");
                exit;
            } else {
                echo "Cập nhật thất bại!";
            }
        }
    }

    public function profile()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            header('Location: /project1/account/login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $account = $this->accountModel->getAccountById($userId);

        if ($account) {
            include_once 'app/views/account/profile.php';
        } else {
            echo "Không tìm thấy thông tin người dùng.";
        }
    }
}
