<?php
// app/controllers/OrderController.php

require_once 'app/config/database.php';
require_once 'app/models/OrderModel.php';
require_once 'app/models/OrderDetailsModel.php';

class OrderController
{
    private $db;
    private $orderModel;
    private $detailsModel;

    public function __construct()
    {
        $this->db            = (new Database())->getConnection();
        $this->orderModel    = new OrderModel($this->db);
        $this->detailsModel  = new OrderDetailsModel($this->db);
    }

    /**
     * Hiển thị danh sách đơn hàng
     */
    public function index()
    {
        $orders = $this->orderModel->getOrders();
        include 'app/views/order/list.php';
    }

    /**
     * Hiển thị chi tiết một đơn hàng
     */
    public function show($id)
    {
        $order   = $this->orderModel->getOrderById((int)$id);
        if (!$order) {
            echo '<p class="text-danger">Không tìm thấy đơn hàng.</p>';
            return;
        }
        $details = $this->detailsModel->getByOrderId((int)$id);
        include 'app/views/order/show.php';
    }

    /**
     * Hiển thị form sửa trạng thái đơn hàng
     */
    public function edit($id)
    {
        $order = $this->orderModel->getOrderById((int)$id);
        if (!$order) {
            echo '<p class="text-danger">Không tìm thấy đơn hàng.</p>';
            return;
        }
        include 'app/views/order/edit.php';
    }

    /**
     * Xử lý POST cập nhật trạng thái đơn hàng
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /project1/Order');
            exit;
        }

        $id     = (int)($_POST['id']     ?? 0);
        $status = $_POST['status']      ?? '';

        $allowed = ['chưa giao', 'đang giao', 'đã giao'];
        if (!in_array($status, $allowed, true)) {
            echo '<p class="text-danger">Trạng thái không hợp lệ.</p>';
            return;
        }

        if ($this->orderModel->updateStatus($id, $status)) {
            header('Location: /project1/Order');
            exit;
        } else {
            echo '<p class="text-danger">Cập nhật trạng thái thất bại.</p>';
        }
    }

    /**
     * Xóa đơn hàng và chi tiết đơn hàng
     */
    public function delete($id)
    {
        $orderId = (int)$id;
        // Xóa chi tiết trước (nếu không có CASCADE)
        $this->detailsModel->deleteByOrderId($orderId);
        // Xóa đơn
        if ($this->orderModel->deleteOrder($orderId)) {
            header('Location: /project1/Order');
            exit;
        } else {
            echo '<p class="text-danger">Xóa đơn hàng thất bại.</p>';
        }
    }
}
