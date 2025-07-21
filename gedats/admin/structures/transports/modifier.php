<?php
require_once '../../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/topbar.php';

$id = $_GET['id'] ?? null;
$success = $error = "";

$stmt = $pdo->prepare("SELECT * FROM transports WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();

if (!$data) {
    echo "<div class='alert alert-danger m-4'>Véhicule introuvable.</div>";
    exit;
}

$societes = $pdo->query("SELECT id, nom FROM societes ORDER BY nom ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_societe = $_POST['id_societe'];
    $numero_vehicule = trim($_POST['numero_vehicule']);
    $type_vehicule = trim($_POST['type_vehicule']);
    $date_enregistrement = $_POST['date_enregistrement'];

    if ($id_societe && $numero_vehicule && $type_vehicule && $date_enregistrement) {
        $stmt = $pdo->prepare("UPDATE transports SET id_societe=?, numero_vehicule=?, type_vehicule=?, date_enregistrement=? WHERE id=?");
        $stmt->execute([$id_societe, $numero_vehicule, $type_vehicule, $date_enregistrement, $id]);
        $success = "✅ Mise à jour réussie.";
    } else {
        $error = "❌ Tous les champs sont requis.";
    }
}
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>✏️ Modifier un véhicule de transport</h5>
        </div>
        <div class="card-body">
            <?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
            <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label>Société *</label>
                    <select name="id_societe" class="form-select" required>
                        <?php foreach ($societes as $s): ?>
                            <option value="<?= $s['id'] ?>" <?= $s['id'] == $data['id_societe'] ? 'selected' : '' ?>><?= htmlspecialchars($s['nom']) ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Numéro du véhicule *</label>
                    <input type="text" name="numero_vehicule" class="form-control" value="<?= htmlspecialchars($data['numero_vehicule']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Type de véhicule *</label>
                    <input type="text" name="type_vehicule" class="form-control" value="<?= htmlspecialchars($data['type_vehicule']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Date d'enregistrement *</label>
                    <input type="date" name="date_enregistrement" class="form-control" value="<?= $data['date_enregistrement'] ?>" required>
                </div>
                <button type="submit" class="btn btn-success">💾 Modifier</button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
