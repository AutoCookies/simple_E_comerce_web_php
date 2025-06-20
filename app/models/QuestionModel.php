<?php
class QuestionModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Lấy tất cả câu hỏi bảo mật (bảng security_questions)
     * @return array [
     *   ['id' => 1, 'question_text' => '...'],
     *   ...
     * ]
     */
    public function getAllQuestions()
    {
        $stmt = $this->conn->prepare("SELECT * FROM security_questions ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy 3 câu hỏi ngẫu nhiên (hoặc số lượng tùy ý) từ tất cả
     * @param int $limit Số lượng câu hỏi cần lấy (mặc định 3)
     * @return array
     */
    public function getRandomQuestions($limit = 3)
    {
        // Lấy hết, sau đó dùng PHP để shuffle và slice
        $all = $this->getAllQuestions();
        if (count($all) > $limit) {
            shuffle($all);
            return array_slice($all, 0, $limit);
        }
        return $all;
    }

    /**
     * Lưu hoặc cập nhật câu trả lời bảo mật cho user
     * @param int    $userId
     * @param int    $questionId
     * @param string $answer    (đã strip_tags/escape ở controller)
     * @return bool
     */
    public function saveUserAnswer($userId, $questionId, $answer)
    {
        // Check xem đã có bản ghi chưa
        $check = $this->conn->prepare(
            "SELECT id 
             FROM user_security_answers 
             WHERE user_id = ? AND question_id = ?"
        );
        $check->execute([$userId, $questionId]);
        if ($check->rowCount() > 0) {
            // Update
            $stmt = $this->conn->prepare(
                "UPDATE user_security_answers 
                 SET answer = ? 
                 WHERE user_id = ? AND question_id = ?"
            );
            return $stmt->execute([$answer, $userId, $questionId]);
        } else {
            // Insert
            $stmt = $this->conn->prepare(
                "INSERT INTO user_security_answers (user_id, question_id, answer)
                 VALUES (?, ?, ?)"
            );
            return $stmt->execute([$userId, $questionId, $answer]);
        }
    }

    /**
     * Lấy tất cả câu trả lời bảo mật của user theo user_id
     * Trả về mảng [question_id => answer, ...]
     * @param int $userId
     * @return array
     */
    public function getUserAnswers($userId)
    {
        $stmt = $this->conn->prepare(
            "SELECT question_id, answer 
             FROM user_security_answers 
             WHERE user_id = ?"
        );
        $stmt->execute([$userId]);

        $answers = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $answers[$row['question_id']] = $row['answer'];
        }
        return $answers;
    }
}
