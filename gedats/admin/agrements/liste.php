<?php
require_once '../../includes/config.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
require_once '../includes/topbar.php';

$type = $_GET['type'] ?? '';

$agrements = [];

$types_valides = ['navires','entrepots','glaces','transports','etablissements','gboya'];

if ($type && in_array($type, $types_valides)) {
    $stmt = $pdo->prepare("
        SELECT a.*, s.nom AS nom_structure 
        FROM agrements a 
        JOIN $type s ON a.id_structure = s.id 
        WHERE a.type_structure = ?
        ORDER BY a.date_attribution DESC
    ");
    $stmt->execute([$type]);
    $agrements = $stmt->fetchAll();
}
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📄 Liste des Agréments <?= $type ? "(" . ucfirst($type) . ")" : "" ?></h5>
            <div class="d-flex align-items-center">
                <form method="GET" class="d-flex">
                    <select name="type" onchange="this.form.submit()" class="form-select">
                        <option value="">Choisir un type</option>
                        <?php foreach ($types_valides as $t): ?>
                            <option value="<?= $t ?>" <?= $type == $t ? 'selected' : '' ?>><?= ucfirst($t) ?></option>
                        <?php endforeach ?>
                    </select>
                </form>
                <a href="ajouter.php" class="btn btn-light btn-sm ms-2">➕ Attribuer un agrément</a>
            </div>
        </div>
        <div class="card-body">
            <?php if (!$type): ?>
                <div class="alert alert-info">Veuillez sélectionner un type de structure pour afficher les agréments.</div>
            <?php elseif (!$agrements): ?>
                <div class="alert alert-warning">Aucun agrément trouvé pour le type <strong><?= htmlspecialchars($type) ?></strong>.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Structure</th>
                                <th>Type</th>
                                <th>Référence</th>
                                <th>N° Agrément</th>
                                <th>Classification</th>
                                <th>Expiration</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($agrements as $i => $a): ?>
                                <tr>
                                    <td><?= $i+1 ?></td>
                                    <td><?= htmlspecialchars($a['nom_structure']) ?></td>
                                    <td><?= ucfirst($a['type_structure']) ?></td>
                                    <td><?= htmlspecialchars($a['reference']) ?></td>
                                    <td><?= htmlspecialchars($a['numero_agrement']) ?></td>
                                    <td><?= htmlspecialchars($a['classification']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($a['date_expiration'])) ?></td>
                                    <td>
                                        <a href="modifier.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
                                        <a href="supprimer.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">🗑</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
