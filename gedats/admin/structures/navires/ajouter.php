<?php
require_once '../../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/topbar.php';

// Récupération des sociétés pour le select
$societes = $pdo->query("SELECT id, nom FROM societes ORDER BY nom ASC")->fetchAll();

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_societe = $_POST['id_societe'] ?? null;
    $type_peche = trim($_POST['type_peche']);
    $marche_destination = trim($_POST['marche_destination']);
    $type_navire = trim($_POST['type_navire']);
    $nom_navire = trim($_POST['nom_navire']);
    $longueur = floatval($_POST['longueur']);
    $pavillon = trim($_POST['pavillon']);
    $date_enregistrement = $_POST['date_enregistrement'];

    if ($id_societe && $type_peche && $marche_destination && $type_navire && $nom_navire && $longueur > 0 && $pavillon && $date_enregistrement) {
        $stmt = $pdo->prepare("INSERT INTO navires (id_societe, type_peche, marche_destination, type_navire, nom, longueur, pavillon, date_enregistrement)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id_societe, $type_peche, $marche_destination, $type_navire, $nom_navire, $longueur, $pavillon, $date_enregistrement]);
        $success = "✅ Navire enregistré avec succès.";
    } else {
        $error = "❌ Veuillez remplir tous les champs.";
    }
}
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">🚢 Ajouter un navire</h5>
            <a href="liste.php" class="btn btn-light btn-sm">↩ Retour à la liste</a>
        </div>
        <div class="card-body">
            <?php if ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php elseif ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Société *</label>
                        <select name="id_societe" class="form-select" required>
                            <option value="">-- Choisir la société --</option>
                            <?php foreach ($societes as $s): ?>
                                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Type de pêche *</label>
                        <input type="text" name="type_peche" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Marché de destination *</label>
                        <input type="text" name="marche_destination" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Type de navire *</label>
                        <input type="text" name="type_navire" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nom du navire *</label>
                        <input type="text" name="nom_navire" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Longueur (m) *</label>
                        <input type="number" name="longueur" step="0.01" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Pavillon *</label>
                        <input type="text" name="pavillon" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date d'enregistrement *</label>
                    <input type="date" name="date_enregistrement" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">💾 Enregistrer</button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
