<?php
require_once '../../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/topbar.php';

$societes = $pdo->query("SELECT id, nom FROM societes ORDER BY nom ASC")->fetchAll();
$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_societe = $_POST['id_societe'] ?? null;
    $adresse = trim($_POST['adresse']);
    $nom = trim($_POST['nom']);
    $nature_produit = trim($_POST['nature_produit']);
    $marche_destination = trim($_POST['marche_destination']);
    $date_enregistrement = $_POST['date_enregistrement'];

    if ($id_societe && $adresse && $nature_produit && $marche_destination && $date_enregistrement) {
        $stmt = $pdo->prepare("INSERT INTO entrepots (id_societe, adresse, nom, nature_produit, marche_destination, date_enregistrement)
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id_societe, $adresse, $nom, $nature_produit, $marche_destination, $date_enregistrement]);
        $success = "✅ Entrepôt enregistré avec succès.";
    } else {
        $error = "❌ Veuillez remplir tous les champs.";
    }
}
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h5>➕ Ajouter un entrepôt</h5>
            <a href="liste.php" class="btn btn-light btn-sm">↩ Retour à la liste</a>
        </div>
        <div class="card-body">
            <?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
            <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label>Société *</label>
                    <select name="id_societe" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <?php foreach ($societes as $s): ?>
                            <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Nom *</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Adresse *</label>
                    <input type="text" name="adresse" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Nature du produit *</label>
                    <input type="text" name="nature_produit" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Marché de destination *</label>
                    <input type="text" name="marche_destination" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Date d'enregistrement *</label>
                    <input type="date" name="date_enregistrement" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">💾 Enregistrer</button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
