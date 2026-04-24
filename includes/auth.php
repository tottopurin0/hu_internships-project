<?php
// =====================================================
// Authentication helpers & Role guards
// =====================================================

require_once __DIR__ . '/db_connect.php';

function current_user() {
    return $_SESSION['user'] ?? null;
}

function current_role() {
    return $_SESSION['role'] ?? null;
}

function is_logged_in() {
    return !empty($_SESSION['user']) && !empty($_SESSION['role']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: /login.php');
        exit;
    }
}

function require_role($allowed_roles) {
    require_login();
    $role = current_role();
    if (!in_array($role, (array)$allowed_roles, true)) {
        http_response_code(403);
        die('403 Forbidden: You do not have access to this page.');
    }
}

function logout() {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}
