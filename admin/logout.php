<?php
session_start();
unset($_SESSION['admin_id']);
$_SESSION['alert'] = ['type' => 'success', 'message' => 'Logged out successfully.'];
header('Location: login.php');
exit();
?>