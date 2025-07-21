<?php
require_once '../../../includes/config.php';

$id = $_GET['id'] ?? null;
if ($id && is_numeric($id)) {
    $pdo->prepare("DELETE FROM entrepots WHERE id = ?")->execute([$id]);
}
header("Location: liste.php");
exit;
