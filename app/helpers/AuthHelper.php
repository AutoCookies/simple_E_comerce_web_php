<?php
class AuthHelper {
    public static function isAdmin() {
        return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin';
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user']['username']);
    }

    public static function getUsername() {
        return $_SESSION['user']['username'] ?? '';
    }

    public static function getUserId() {
        return $_SESSION['user']['id'] ?? null;
    }

    public static function getUserRole() {
        return $_SESSION['user']['role'] ?? null;
    }
}
