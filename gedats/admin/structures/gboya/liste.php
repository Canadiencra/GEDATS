<?php
require_once '../../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/topbar.php';

$stmt = $pdo->query("SELECT g.*, s.nom AS nom_societe 
                     FROM gboya g 
                     JOIN societes s ON s.id = g.id_societe 
                     ORDER BY g.date_enregistrement DESC");
$gboyas = $stmt->fetchAll();
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h5>🛶 Liste des Gboya</h5>
            <a href="ajouter.php" class="btn btn-light btn-sm">➕ Ajouter</a>
        </div>
        <div class="card-body">
            <?php if (count($gboyas) === 0): ?>
                <div class="alert alert-info">Aucun gboya enregistré.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Société</th>
                                <th>Port d'attache</th>
                                <th>Nom</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($gboyas as $i => $g): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($g['nom_societe']) ?></td>
                                    <td><?= htmlspecialchars($g['port_atache']) ?></td>
                                    <td><?= htmlspecialchars($g['nom']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($g['date_enregistrement'])) ?></td>
                                    <td>
                                        <a href="modifier.php?id=<?= $g['id'] ?>" class="btn btn-warning btn-sm">✏️</a>
                                        <a href="supprimer.php?id=<?= $g['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Confirmer la suppression ?')">🗑</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
