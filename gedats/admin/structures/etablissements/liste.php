<?php
require_once '../../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/topbar.php';

$stmt = $pdo->query("SELECT e.*, s.nom AS nom_societe 
                     FROM etablissements e 
                     JOIN societes s ON s.id = e.id_societe 
                     ORDER BY e.date_enregistrement DESC");
$etabs = $stmt->fetchAll();
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h5>🏭 Liste des Établissements</h5>
            <a href="ajouter.php" class="btn btn-light btn-sm">➕ Ajouter</a>
        </div>
        <div class="card-body">
            <?php if (count($etabs) === 0): ?>
                <div class="alert alert-info">Aucun établissement enregistré.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Société</th>
                                <th>Adresse</th>
                                <th>Produit</th>
                                <th>Marché</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($etabs as $i => $e): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($e['nom_societe']) ?></td>
                                    <td><?= htmlspecialchars($e['adresse']) ?></td>
                                    <td><?= htmlspecialchars($e['nature_produit']) ?></td>
                                    <td><?= htmlspecialchars($e['marche_destination']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($e['date_enregistrement'])) ?></td>
                                    <td>
                                        <a href="modifier.php?id=<?= $e['id'] ?>" class="btn btn-warning btn-sm">✏️</a>
                                        <a href="supprimer.php?id=<?= $e['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Confirmer ?')">🗑</a>
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
