<?php
require_once 'app/config/database.php';
require_once 'app/models/OrderModel.php';
require_once 'app/models/OrderDetailsModel.php';

class OrderControllerUser
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

    public function history()
    {
        // Đảm bảo đã khởi động session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']['id'])) {
            echo '<p class="text-danger">Bạn cần đăng nhập để xem lịch sử đơn hàng.</p>';
            return;
        }

        $userId = (int)$_SESSION['user']['id'];
        $orders = $this->orderModel->getOrdersByUser($userId);

        include 'app/views/order/history.php';
    }
}
