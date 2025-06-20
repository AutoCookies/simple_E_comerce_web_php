<?php
class CategoryModel
{
    private $conn;
    private $table_name = "category";

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    /**
     * Lấy về toàn bộ danh mục
     * @return array[object]
     */
    public function getCategories(): array
    {
        $query = "SELECT id, name, description FROM {$this->table_name} ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Lấy một danh mục theo ID
     * @param int $id
     * @return object|null
     */
    public function getCategoryById(int $id)
    {
        $query = "SELECT id, name, description FROM {$this->table_name} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }

    /**
     * Thêm mới danh mục
     */
    public function addCategory(string $name, string $description): bool
    {
        $query = "INSERT INTO {$this->table_name} (name, description)
                  VALUES (:name, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':name', htmlspecialchars(strip_tags($name)), PDO::PARAM_STR);
        $stmt->bindValue(':description', htmlspecialchars(strip_tags($description)), PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Cập nhật danh mục
     */
    public function updateCategory(int $id, string $name, string $description): bool
    {
        $query = "UPDATE {$this->table_name}
                  SET name = :name, description = :description
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':name', htmlspecialchars(strip_tags($name)), PDO::PARAM_STR);
        $stmt->bindValue(':description', htmlspecialchars(strip_tags($description)), PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Xóa danh mục
     */
    public function deleteCategory(int $id): bool
    {
        $query = "DELETE FROM {$this->table_name} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
