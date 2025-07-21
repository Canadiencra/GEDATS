<?php
require_once '../../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/topbar.php';

$id = $_GET['id'] ?? null;
$success = $error = "";

$stmt = $pdo->prepare("SELECT * FROM etablissements WHERE id = ?");
$stmt->execute([$id]);
$etab = $stmt->fetch();

if (!$etab) {
    echo "<div class='alert alert-danger m-4'>Établissement introuvable.</div>";
    exit;
}

$societes = $pdo->query("SELECT id, nom FROM societes ORDER BY nom ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_societe = $_POST['id_societe'];
    $adresse = trim($_POST['adresse']);
    $nature_produit = trim($_POST['nature_produit']);
    $marche_destination = trim($_POST['marche_destination']);
    $date_enregistrement = $_POST['date_enregistrement'];

    if ($id_societe && $adresse && $nature_produit && $marche_destination && $date_enregistrement) {
        $stmt = $pdo->prepare("UPDATE etablissements SET id_societe=?, adresse=?, nature_produit=?, marche_destination=?, date_enregistrement=? WHERE id=?");
        $stmt->execute([$id_societe, $adresse, $nature_produit, $marche_destination, $date_enregistrement, $id]);
        $success = "✅ Modification réussie.";
    } else {
        $error = "❌ Tous les champs sont obligatoires.";
    }
}
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>✏️ Modifier l'établissement</h5>
        </div>
        <div class="card-body">
            <?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
            <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label>Société *</label>
                    <select name="id_societe" class="form-select" required>
                        <?php foreach ($societes as $s): ?>
                            <option value="<?= $s['id'] ?>" <?= $s['id'] == $etab['id_societe'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['nom']) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Adresse *</label>
                    <input type="text" name="adresse" class="form-control" value="<?= htmlspecialchars($etab['adresse']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Nature du produit *</label>
                    <input type="text" name="nature_produit" class="form-control" value="<?= htmlspecialchars($etab['nature_produit']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Marché de destination *</label>
                    <input type="text" name="marche_destination" class="form-control" value="<?= htmlspecialchars($etab['marche_destination']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Date d'enregistrement *</label>
                    <input type="date" name="date_enregistrement" class="form-control" value="<?= $etab['date_enregistrement'] ?>" required>
                </div>
                <button type="submit" class="btn btn-success">💾 Modifier</button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
