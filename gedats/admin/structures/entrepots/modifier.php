<?php
require_once '../../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/topbar.php';

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: liste.php"); exit; }

$stmt = $pdo->prepare("SELECT * FROM entrepots WHERE id = ?");
$stmt->execute([$id]);
$e = $stmt->fetch();
if (!$e) { header("Location: liste.php"); exit; }

$societes = $pdo->query("SELECT id, nom FROM societes ORDER BY nom ASC")->fetchAll();
$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE entrepots SET id_societe=?, adresse=?, nature_produit=?, marche_destination=?, date_enregistrement=? WHERE id=?");
    $stmt->execute([
        $_POST['id_societe'], $_POST['adresse'], $_POST['nature_produit'],
        $_POST['marche_destination'], $_POST['date_enregistrement'], $id
    ]);
    $success = "✅ Modifications enregistrées.";
    $stmt = $pdo->prepare("SELECT * FROM entrepots WHERE id = ?");
    $stmt->execute([$id]);
    $e = $stmt->fetch();
}
?>

<!-- même formulaire que ajouter.php, avec valeurs pré-remplies -->
<!-- remplace les `value=""` par `value="<?= htmlspecialchars($e['champ']) ?>"` -->

<!-- … même design que ajouter.php … -->
