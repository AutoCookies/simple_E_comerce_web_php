<?php
require_once('app/config/database.php');
require_once('app/models/QuestionModel.php');
require_once('app/models/AccountModel.php'); // Cần để lấy user/đặt ID

class QuestionController
{
    private $questionModel;
    private $accountModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->questionModel = new QuestionModel($this->db);
        $this->accountModel  = new AccountModel($this->db);
    }

    /**
     * Hiển thị form hỏi 3 câu hỏi bảo mật cho user (sau khi đăng ký)
     * Controller này sẽ được gọi bởi AccountController, 
     * nhưng bạn có thể route trực tiếp tới đây nếu muốn tách riêng.
     */
    public function showSecurityQuestionsForm()
    {
        session_start();
        if (!isset($_SESSION['new_user_id'])) {
            // Nếu chưa có thông tin user mới từ session, quay về trang đăng ký
            header("Location: /project1/account/register");
            exit;
        }

        // Lấy 3 câu hỏi ngẫu nhiên (hoặc lấy từ session nếu muốn giữ nguyên 3 câu đã chọn)
        // Nếu bạn muốn giữ nguyên chính xác 3 câu trước đó, bạn có thể lưu 
        // vào session khi gọi từ AccountController. Ở đây ví dụ lấy lại ngẫu nhiên:
        $questions = $this->questionModel->getRandomQuestions(3);

        // Nếu bạn đã lưu 3 câu vào $_SESSION['new_user_questions'], có thể dùng:
        // $questions = $_SESSION['new_user_questions'];

        $errors = $_SESSION['security_errors'] ?? [];
        unset($_SESSION['security_errors']);

        include_once 'app/views/account/security_questions_form.php';
    }

    /**
     * Xử lý POST lưu 3 câu trả lời bảo mật từ form
     */
    public function saveSecurityAnswers()
    {
        session_start();
        if (!isset($_SESSION['new_user_id'])) {
            header("Location: /project1/account/register");
            exit;
        }

        $userId = $_SESSION['new_user_id'];

        // Lấy đúng 3 câu hỏi hiện đang hiển thị
        // Nếu bạn dùng getRandomQuestions thì cần chốt lại 3 câu đó ở session
        // Ví dụ: $questions = $_SESSION['new_user_questions'];
        $questions = $this->questionModel->getRandomQuestions(3);

        // Nếu bạn lưu mảng 3 câu vào session khi show form:
        // $questions = $_SESSION['new_user_questions'];

        $errors = [];

        // Validate từng câu trả lời
        foreach ($questions as $q) {
            $qid   = $q['id'];
            $field = "answer_$qid";
            $answer = trim($_POST[$field] ?? '');
            if ($answer === '') {
                $errors[$field] = "Vui lòng trả lời câu hỏi này.";
            }
        }

        if (!empty($errors)) {
            $_SESSION['security_errors'] = $errors;
            header("Location: /project1/account/security_questions");
            exit;
        }

        // Lưu từng câu trả lời
        foreach ($questions as $q) {
            $qid   = $q['id'];
            $answer = trim($_POST["answer_$qid"]);
            // (nếu cần mã hóa/hashing, có thể thực hiện ở đây)
            $this->questionModel->saveUserAnswer($userId, $qid, $answer);
        }

        // Xóa session tạm
        unset($_SESSION['new_user_id']);
        unset($_SESSION['new_user_questions']);

        // Chuyển hướng về trang login
        header("Location: /project1/account/login");
        exit;
    }

    /**
     * Hiển thị form quên mật khẩu: 
     * - Bước 1: Người dùng nhập username
     * - Bước 2: Lấy câu hỏi người dùng đã lưu (bằng getUserAnswers & getAllQuestions)
     */
    public function showForgotPasswordForm()
    {
        include_once 'app/views/account/forgot_password_form.php';
    }

    /**
     * Xác thực câu trả lời bảo mật khi quên mật khẩu
     */
    public function verifySecurityAnswers()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /project1/account/forgot_password");
            exit;
        }

        $username = $_POST['username'] ?? '';
        if (!$username) {
            echo "Vui lòng nhập username.";
            return;
        }

        $user = $this->accountModel->getAccountByUsername($username);
        if (!$user) {
            echo "Không tìm thấy tài khoản.";
            return;
        }

        // Lấy tất cả các câu hỏi và câu trả lời của user
        $allQuestions = $this->questionModel->getAllQuestions();
        $userAnswers  = $this->questionModel->getUserAnswers($user->id);

        $errors  = [];
        $correct = true;

        // Chạy qua mỗi câu hỏi mà user đã từng trả lời
        foreach ($allQuestions as $q) {
            $qid = $q['id'];
            // Chỉ kiểm những câu mà user có trả lời (nếu muốn yêu cầu trả lời đúng toàn bộ)
            if (isset($userAnswers[$qid])) {
                $submitted = trim($_POST["answer_$qid"] ?? '');
                if ($submitted === '' || 
                    strtolower($submitted) !== strtolower($userAnswers[$qid])
                ) {
                    $correct = false;
                    $errors["answer_$qid"] = "Sai câu trả lời cho câu: “{$q['question_text']}”.";
                }
            }
        }

        if (!$correct) {
            // Lưu lỗi để hiển thị lại
            session_start();
            $_SESSION['forgot_errors'] = $errors;
            header("Location: /project1/account/forgot_password");
            exit;
        }

        // Nếu đúng tất cả (hoặc bạn có thể kiểm quy định đúng ít nhất 2/3…) 
        session_start();
        $_SESSION['reset_user_id'] = $user->id;
        header("Location: /project1/account/reset_password_form");
        exit;
    }

    /**
     * Hiển thị form nhập mật khẩu mới (sau khi trả lời đúng bảo mật)
     */
    public function showResetPasswordForm()
    {
        session_start();
        if (!isset($_SESSION['reset_user_id'])) {
            header("Location: /project1/account/forgot_password");
            exit;
        }
        include_once 'app/views/account/reset_password_form.php';
    }

    /**
     * Xử lý đặt lại mật khẩu mới
     */
    public function resetPassword()
    {
        session_start();
        if (!isset($_SESSION['reset_user_id'])) {
            header("Location: /project1/account/forgot_password");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /project1/account/reset_password_form");
            exit;
        }

        $userId         = $_SESSION['reset_user_id'];
        $newPassword    = $_POST['password'] ?? '';
        $confirmPassword= $_POST['confirmpassword'] ?? '';

        if (!$newPassword) {
            echo "Vui lòng nhập mật khẩu mới.";
            return;
        }
        if ($newPassword !== $confirmPassword) {
            echo "Mật khẩu và xác nhận mật khẩu không khớp.";
            return;
        }

        $hashed = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashed, $userId]);

        unset($_SESSION['reset_user_id']);

        echo "Đặt lại mật khẩu thành công! Bạn có thể đăng nhập lại.";
        // Hoặc chuyển hướng:
        // header("Location: /project1/account/login");
        // exit;
    }
}
