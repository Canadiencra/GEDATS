<?php
require_once '../../includes/config.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
require_once '../includes/topbar.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: liste.php");
    exit;
}

// Récupération de l'agrément
$stmt = $pdo->prepare("SELECT * FROM agrements WHERE id = ?");
$stmt->execute([$id]);
$agrement = $stmt->fetch();

if (!$agrement) {
    echo "<div class='alert alert-danger'>Agrément introuvable.</div>";
    exit;
}

$type_structure = $agrement['type_structure'];
$id_structure = $agrement['id_structure'];
$mode_paiement = $agrement['mode_paiement'];
$classification = $agrement['classification'];
$date_expiration = $agrement['date_expiration'];

$structures = $pdo->query("SELECT id, nom FROM $type_structure ORDER BY nom ASC")->fetchAll();

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_structure = $_POST['id_structure'];
    $mode_paiement = $_POST['mode_paiement'];
    $classification = $_POST['classification'];
    $date_expiration = $_POST['date_expiration'];

    if ($id_structure && $mode_paiement && $classification && $date_expiration) {
        $stmt = $pdo->prepare("UPDATE agrements SET id_structure = ?, mode_paiement = ?, classification = ?, date_expiration = ? WHERE id = ?");
        $stmt->execute([$id_structure, $mode_paiement, $classification, $date_expiration, $id]);
        $success = "✅ Agrément mis à jour avec succès.";
    } else {
        $error = "❌ Tous les champs sont requis.";
    }
}
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h5>✏️ Modifier l’Agrément</h5>
        </div>
        <div class="card-body">
            <?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
            <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

            <form method="POST">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Structure (<?= $type_structure ?>)</label>
                        <select name="id_structure" class="form-select" required>
                            <?php foreach ($structures as $s): ?>
                                <option value="<?= $s['id'] ?>" <?= $s['id'] == $id_structure ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($s['nom']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Mode de paiement</label>
                        <input type="text" name="mode_paiement" class="form-control" value="<?= htmlspecialchars($mode_paiement) ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Classification</label>
                        <select name="classification" class="form-select" required>
                            <?php foreach (['A', 'B', 'C', 'D'] as $c): ?>
                                <option value="<?= $c ?>" <?= $classification == $c ? 'selected' : '' ?>><?= $c ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Date d'expiration</label>
                        <input type="date" name="date_expiration" class="form-control" value="<?= $date_expiration ?>" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">💾 Enregistrer les modifications</button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
