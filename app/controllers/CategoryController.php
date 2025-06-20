<?php
// app/controllers/CategoryController.php

require_once 'app/config/database.php';
require_once 'app/models/CategoryModel.php';

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($db);
    }

    /**
     * Hiển thị danh sách category
     */
    public function index()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    /**
     * Hiển thị form thêm mới
     */
    public function add()
    {
        include 'app/views/category/add.php';
    }

    /**
     * Xử lý POST lưu category mới
     */
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /project1/Category');
            exit;
        }

        $name        = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $errors      = [];

        // Validate tên
        if (trim($name) === '') {
            $errors[] = 'Tên danh mục không được để trống.';
        } elseif (mb_strlen($name) < 3) {
            $errors[] = 'Tên danh mục phải ít nhất 3 ký tự.';
        }

        if ($errors) {
            include 'app/views/category/add.php';
            return;
        }

        if ($this->categoryModel->addCategory($name, $description)) {
            header('Location: /project1/Category');
            exit;
        } else {
            $errors[] = 'Không thể lưu danh mục. Vui lòng thử lại sau.';
            include 'app/views/category/add.php';
        }
    }

    /**
     * Hiển thị form sửa category
     */
    public function edit($id)
    {
        $id = (int)$id;
        $category = $this->categoryModel->getCategoryById($id);
        if (!$category) {
            echo '<p class="text-danger">Không tìm thấy danh mục.</p>';
            return;
        }
        include 'app/views/category/edit.php';
    }

    /**
     * Xử lý POST cập nhật category
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /project1/Category');
            exit;
        }

        $id          = (int) ($_POST['id'] ?? 0);
        $name        = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $errors      = [];

        // Validate tên
        if (trim($name) === '') {
            $errors[] = 'Tên danh mục không được để trống.';
        } elseif (mb_strlen($name) < 3) {
            $errors[] = 'Tên danh mục phải ít nhất 3 ký tự.';
        }

        if ($errors) {
            // tạo đối tượng tạm để view có dữ liệu
            $category = (object)[
                'id'          => $id,
                'name'        => $name,
                'description' => $description
            ];
            include 'app/views/category/edit.php';
            return;
        }

        if ($this->categoryModel->updateCategory($id, $name, $description)) {
            header('Location: /project1/Category');
            exit;
        } else {
            echo '<p class="text-danger">Có lỗi xảy ra khi cập nhật danh mục.</p>';
        }
    }

    /**
     * Xóa category theo id
     */
    public function delete($id)
    {
        $id = (int)$id;
        if ($this->categoryModel->deleteCategory($id)) {
            header('Location: /project1/Category');
            exit;
        } else {
            echo '<p class="text-danger">Xóa thất bại. Vui lòng thử lại.</p>';
        }
    }
}
