<?php
// app/models/OrderDetailsModel.php

class OrderDetailsModel
{
    private $conn;
    private $table = 'order_details';

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function getByOrderId(int $orderId): array
    {
        $sql = "SELECT id, order_id, product_id, quantity, price, total
                FROM {$this->table}
                WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addDetail(int $orderId, int $productId, int $quantity, float $price): bool
    {
        $sql = "INSERT INTO {$this->table}
                (order_id, product_id, quantity, price)
                VALUES (:order_id, :product_id, :quantity, :price)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':order_id',   $orderId,   PDO::PARAM_INT);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':quantity',   $quantity,  PDO::PARAM_INT);
        $stmt->bindValue(':price',      $price);
        return $stmt->execute();
    }

    public function deleteByOrderId(int $orderId): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
