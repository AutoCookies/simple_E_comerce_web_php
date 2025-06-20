<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class ProductControllerUser
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function index()
    {
        $products = $this->productModel->getProducts();
        include 'app/views/product/listproduct.php'; // view dành riêng cho user
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php'; // view chi tiết dành cho user
        } else {
            echo "Không tìm thấy sản phẩm.";
        }
    }

    public function addToCart($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }
        header('Location: /project1/Product/cart');
    }
    public function cart()
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/product/cart.php';
    }
    public function checkout()
    {
        include 'app/views/product/checkout.php';
    }
    public function processCheckout()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name    = $_POST['name'];
            $phone   = $_POST['phone'];
            $address = $_POST['address'];

            // Kiểm tra giỏ hàng
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "Giỏ hàng trống.";
                return;
            }

            // Kiểm tra đăng nhập và lấy user_id
            if (!isset($_SESSION['user']['id'])) {
                echo "Bạn cần đăng nhập để đặt hàng.";
                return;
            }
            $userId = (int)$_SESSION['user']['id'];

            // Bắt đầu giao dịch
            $this->db->beginTransaction();
            try {
                // Lưu thông tin đơn hàng vào bảng orders, kèm user_id
                $query = "INSERT INTO orders (user_id, name, phone, address)
                      VALUES (:user_id, :name, :phone, :address)";

                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':name',    $name,   PDO::PARAM_STR);
                $stmt->bindParam(':phone',   $phone,  PDO::PARAM_STR);
                $stmt->bindParam(':address', $address, PDO::PARAM_STR);
                $stmt->execute();
                $order_id = $this->db->lastInsertId();

                // Lưu chi tiết đơn hàng vào bảng order_details
                $cart = $_SESSION['cart'];
                foreach ($cart as $product_id => $item) {
                    $query = "INSERT INTO order_details (order_id, product_id, quantity, price)
                          VALUES (:order_id, :product_id, :quantity, :price)";

                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id',   $order_id,       PDO::PARAM_INT);
                    $stmt->bindParam(':product_id', $product_id,     PDO::PARAM_INT);
                    $stmt->bindParam(':quantity',   $item['quantity'], PDO::PARAM_INT);
                    $stmt->bindParam(':price',      $item['price']); // PDO tự xác định type
                    $stmt->execute();
                }

                // Xóa giỏ hàng sau khi đặt hàng thành công
                unset($_SESSION['cart']);

                // Commit giao dịch
                $this->db->commit();

                // Chuyển hướng đến trang xác nhận đơn hàng
                header('Location: /project1/Product/orderConfirmation');
                exit;
            } catch (Exception $e) {
                // Rollback giao dịch nếu có lỗi
                $this->db->rollBack();
                echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
            }
        }
    }


    public function orderConfirmation()
    {
        include 'app/views/product/orderConfirmation.php';
    }

    public function updateCart($id)
    {
        // chỉ xử lý POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /project1/Product/cart');
            exit;
        }

        $id = (int)$id;
        $qty = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        if ($qty < 1) {
            // nếu số lượng <1 thì xoá khỏi giỏ
            unset($_SESSION['cart'][$id]);
        } else {
            // cập nhật nếu tồn tại
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['quantity'] = $qty;
            }
        }

        header('Location: /project1/Product/cart');
        exit;
    }

    public function removeFromCart($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: /project1/Product/cart');
        exit;
    }
}
