<?php
require_once '../../../includes/config.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM gboya WHERE id = ?");
    $stmt->execute([$id]);
}
header("Location: liste.php");
exit;
?>
