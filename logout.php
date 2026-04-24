<?php // ไม่มีบรรทัดว่างข้างบนนี้เลย
session_start();
require_once __DIR__ . '/includes/auth.php';
logout();
header('Location: login.php');
exit;