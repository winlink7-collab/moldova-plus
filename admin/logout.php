<?php
if (session_status() === PHP_SESSION_NONE) session_start();
session_destroy();

$return = $_GET['return'] ?? '';
// Validate: same-origin only (must start with /)
if ($return && preg_match('#^/#', rawurldecode($return))) {
    header('Location: ' . rawurldecode($return));
} else {
    header('Location: login.php');
}
exit;
