<?php
require_once '../../includes/config.php';

$id = $_GET['id'] ?? null;

if ($id && is_numeric($id)) {
    // Supprimer la société
    $stmt = $pdo->prepare("DELETE FROM societes WHERE id = ?");
    $stmt->execute([$id]);
}

// Rediriger après suppression
header("Location: liste.php");
exit;
