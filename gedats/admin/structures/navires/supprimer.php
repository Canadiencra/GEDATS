<?php
require_once '../../../includes/config.php';

$id = $_GET['id'] ?? null;

if ($id && is_numeric($id)) {
    $stmt = $pdo->prepare("DELETE FROM navires WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: liste.php");
exit;
