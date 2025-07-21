<?php
require_once '../../includes/config.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
require_once '../includes/topbar.php';

$success = $error = "";

$type_structure = $_POST['type_structure'] ?? '';
$id_structure = $_POST['id_structure'] ?? '';
$mode_paiement = $_POST['mode_paiement'] ?? '';
$classification = $_POST['classification'] ?? '';
$date_expiration = $_POST['date_expiration'] ?? '';
$annee = date('Y');

// Fonctions de génération automatique des numéros
function generer_reference($pdo, $type_structure) {
    $annee_ref = '2022'; // année figée pour les références comme demandé
    $prefix = "ATS/ONSPA/{$annee_ref}";

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM agrements WHERE type_structure = ?");
    $stmt->execute([$type_structure]);
    $count = $stmt->fetchColumn();

    $numero = str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    return "{$numero}/{$prefix}";
}

function generer_numero_agrement($pdo, $type_structure) {
    $annee = date('Y');
    $prefixes = [
        'navires'      => 'ONSPA/MPEM',
        'transport'    => 'V/ONSPA/MPEM',
        'entrepots'    => 'ETP/ONSPA/MPEM',
        'etablissement'=> 'ETS/ONSPA/MPEM',
        'gboya'        => 'ETS/ONSPA/MPEM',
        'glace'        => 'GLA/ONSPA/MPEM'
    ];

    $prefix = $prefixes[$type_structure] ?? 'ONSPA/MPEM';

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM agrements WHERE type_structure = ? AND YEAR(date_attribution) = ?");
    $stmt->execute([$type_structure, $annee]);
    $count = $stmt->fetchColumn();

    $numero = str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    return "{$numero}/{$prefix}/{$annee}";
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($type_structure && $id_structure && $mode_paiement && $classification && $date_expiration) {
        // Vérifier si la structure a déjà été agréée cette année
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM agrements WHERE id_structure = ? AND type_structure = ? AND YEAR(date_attribution) = ?");
        $stmt_check->execute([$id_structure, $type_structure, $annee]);
        $existe = $stmt_check->fetchColumn();

        if ($existe > 0) {
            $error = "❌ Cette structure a déjà été agréée pour l’année $annee.";
        } else {
            $reference = generer_reference($pdo, $type_structure);
            $numero_agrement = generer_numero_agrement($pdo, $type_structure);

            $stmt = $pdo->prepare("INSERT INTO agrements (id_structure, type_structure, mode_paiement, classification, date_expiration, reference, numero_agrement, date_attribution) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$id_structure, $type_structure, $mode_paiement, $classification, $date_expiration, $reference, $numero_agrement]);
            $success = "✅ Agrément attribué avec succès.";
        }
    } else {
        $error = "❌ Tous les champs sont requis.";
    }
}

// Charger les structures selon le type sélectionné
$structures = [];
if ($type_structure) {
    $stmt = $pdo->prepare("SELECT id, nom FROM {$type_structure} ORDER BY nom ASC");
    $stmt->execute();
    $structures = $stmt->fetchAll();
}
?>

<!-- HTML d'affichage (identique) -->
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5>📄 Attribuer un Agrément</h5>
        </div>
        <div class="card-body">
            <?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
            <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

            <form method="POST">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Type de structure *</label>
                        <select name="type_structure" class="form-select" onchange="this.form.submit()" required>
                            <option value="">-- Choisir --</option>
                            <?php
                            $types = ['navires','entrepots','glace','transport','etablissement','gboya'];
                            foreach ($types as $type) {
                                echo "<option value='$type' " . ($type === $type_structure ? 'selected' : '') . ">$type</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Structure à agréer *</label>
                        <select name="id_structure" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            <?php foreach ($structures as $s): ?>
                                <option value="<?= $s['id'] ?>" <?= $id_structure == $s['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($s['nom']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Mode de paiement *</label>
                        <input type="text" name="mode_paiement" class="form-control" value="<?= htmlspecialchars($mode_paiement) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label>Classification *</label>
                        <select name="classification" class="form-select" required>
                            <option value="">-- Choisir --</option>
                            <?php foreach (['A', 'B', 'C', 'D'] as $c): ?>
                                <option value="<?= $c ?>" <?= $c == $classification ? 'selected' : '' ?>><?= $c ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Date d'expiration *</label>
                    <input type="date" name="date_expiration" class="form-control" value="<?= $date_expiration ?>" required>
                </div>

                <button type="submit" class="btn btn-success">✅ Attribuer</button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
