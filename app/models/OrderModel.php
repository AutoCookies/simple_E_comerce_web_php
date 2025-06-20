// app/models/OrderModel.php
<?php
class OrderModel
{
    private $conn;
    private $table = 'orders';

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    /**
     * Lấy tất cả đơn hàng
     * @return array of objects
     */
    public function getOrders(): array
    {
        $sql = "SELECT id, name, phone, address, created_at, status
                FROM {$this->table}
                ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Lấy chi tiết một đơn hàng theo ID
     */
    public function getOrderById(int $id)
    {
        $sql = "SELECT id, name, phone, address, created_at, status
                FROM {$this->table}
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }

    /**
     * Thêm đơn hàng, trả về order_id mới
     */
    public function addOrder(string $name, string $phone, string $address): int
    {
        $sql = "INSERT INTO {$this->table} (name, phone, address)
                VALUES (:name, :phone, :address)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':name', htmlspecialchars(strip_tags($name)), PDO::PARAM_STR);
        $stmt->bindValue(':phone', htmlspecialchars(strip_tags($phone)), PDO::PARAM_STR);
        $stmt->bindValue(':address', htmlspecialchars(strip_tags($address)), PDO::PARAM_STR);
        $stmt->execute();
        return (int)$this->conn->lastInsertId();
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus(int $id, string $status): bool
    {
        $sql = "UPDATE {$this->table}
                SET status = :status
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Xóa đơn hàng (và chi tiết bên cascade nếu thiết lập FK ON DELETE CASCADE)
     */
    public function deleteOrder(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getOrdersByUser($userId)
    {
        $query = "
        SELECT 
            o.id AS order_id,
            o.status,
            o.created_at,
            o.name AS receiver_name,
            o.phone,
            o.address,
            od.quantity,
            od.price AS detail_price,
            od.total AS detail_total,
            p.name AS product_name
        FROM orders o
        JOIN order_details od ON o.id = od.order_id
        JOIN product p ON od.product_id = p.id
        WHERE o.user_id = :user_id
        ORDER BY o.created_at DESC
    ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $rawData = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Group by order_id
        $orders = [];
        foreach ($rawData as $row) {
            $orderId = $row->order_id;
            if (!isset($orders[$orderId])) {
                $orders[$orderId] = [
                    'order_id' => $row->order_id,
                    'status' => $row->status,
                    'created_at' => $row->created_at,
                    'receiver_name' => $row->receiver_name,
                    'phone' => $row->phone,
                    'address' => $row->address,
                    'total_price' => 0, // Khởi tạo tổng
                    'details' => []
                ];
            }

            // Dùng total đã được tính sẵn trong CSDL
            $orders[$orderId]['total_price'] += $row->detail_total;

            $orders[$orderId]['details'][] = [
                'product_name' => $row->product_name,
                'quantity' => $row->quantity,
                'price' => $row->detail_price,
                'total' => $row->detail_total
            ];
        }

        return $orders;
    }
}
