<?php
require_once '../../includes/config.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
require_once '../includes/topbar.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $telephone = trim($_POST['telephone']);
    $adresse = trim($_POST['adresse']);
    $responsable = trim($_POST['responsable']);
    $email = trim($_POST['email']);

    if ($nom && $telephone && $adresse && $responsable) {
        $stmt = $pdo->prepare("INSERT INTO societes (nom, telephone, adresse, responsable, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $telephone, $adresse, $responsable, $email]);
        $success = "✅ Société enregistrée avec succès.";
    } else {
        $error = "❌ Veuillez remplir tous les champs obligatoires.";
    }
}
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">➕ Ajouter une société</h5>
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
                        <label class="form-label">Nom de la société *</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Téléphone *</label>
                        <input type="text" name="telephone" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Adresse *</label>
                    <input type="text" name="adresse" class="form-control" required>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nom du responsable *</label>
                        <input type="text" name="responsable" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email (facultatif)</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn btn-success">💾 Enregistrer</button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
