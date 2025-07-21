<?php
require_once '../../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/topbar.php';

$stmt = $pdo->query("SELECT t.*, s.nom AS nom_societe FROM transports t JOIN societes s ON s.id = t.id_societe ORDER BY t.date_enregistrement DESC");
$transports = $stmt->fetchAll();
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h5>🚛 Liste des véhicules de transport</h5>
            <a href="ajouter.php" class="btn btn-light btn-sm">➕ Ajouter</a>
        </div>
        <div class="card-body">
            <?php if (count($transports) === 0): ?>
                <div class="alert alert-info">Aucun véhicule enregistré.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Société</th>
                                <th>Numéro</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transports as $i => $t): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($t['nom_societe']) ?></td>
                                    <td><?= htmlspecialchars($t['numero_vehicule']) ?></td>
                                    <td><?= htmlspecialchars($t['type_vehicule']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($t['date_enregistrement'])) ?></td>
                                    <td>
                                        <a href="modifier.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
                                        <a href="supprimer.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer ?')">🗑</a>
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

<?php require_once '../../includes/footer.php'; ?>
