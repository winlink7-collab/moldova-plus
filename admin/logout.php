<?php
if (session_status() === PHP_SESSION_NONE) session_start();

unset($_SESSION['mp_admin_ok']);
session_destroy();

setcookie('admin_token', '', time() - 3600, '/');

$return = $_GET['return'] ?? '';
// Validate: same-origin only (must start with /)
if ($return && preg_match('#^/#', rawurldecode($return))) {
    header('Location: ' . rawurldecode($return));
} else {
    header('Location: login.php');
}
exit;
