<?php
require_once '../../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/topbar.php';

// Gestion de la recherche
$search = $_GET['search'] ?? '';

if (!empty($search)) {
    $stmt = $pdo->prepare("
        SELECT n.*, s.nom AS nom_societe 
        FROM navires n
        JOIN societes s ON s.id = n.id_societe
        WHERE n.nom LIKE :search 
           OR s.nom LIKE :search 
           OR n.type_peche LIKE :search 
           OR n.pavillon LIKE :search
        ORDER BY n.date_enregistrement DESC
    ");
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt = $pdo->query("
        SELECT n.*, s.nom AS nom_societe 
        FROM navires n
        JOIN societes s ON s.id = n.id_societe
        ORDER BY n.date_enregistrement DESC
    ");
}
$navires = $stmt->fetchAll();
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">🚢 Liste des navires</h5>
            <a href="ajouter.php" class="btn btn-light btn-sm">➕ Ajouter un navire</a>
        </div>
        <div class="card-body">
            <!-- Barre de recherche -->
            <form method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="🔍 Rechercher navire, société, pavillon..." value="<?= htmlspecialchars($search) ?>">
                    <button class="btn btn-outline-primary" type="submit">Rechercher</button>
                    <?php if ($search): ?>
                        <a href="liste.php" class="btn btn-outline-secondary">Annuler</a>
                    <?php endif; ?>
                </div>
            </form>

            <?php if (count($navires) === 0): ?>
                <div class="alert alert-info">Aucun navire trouvé.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nom navire</th>
                                <th>Société</th>
                                <th>Type pêche</th>
                                <th>Type navire</th>
                                <th>Longueur (m)</th>
                                <th>Pavillon</th>
                                <th>Date enregistrement</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($navires as $i => $n): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($n['nom']) ?></td>
                                    <td><?= htmlspecialchars($n['nom_societe']) ?></td>
                                    <td><?= htmlspecialchars($n['type_peche']) ?></td>
                                    <td><?= htmlspecialchars($n['type_navire']) ?></td>
                                    <td><?= htmlspecialchars($n['longueur']) ?></td>
                                    <td><?= htmlspecialchars($n['pavillon']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($n['date_enregistrement'])) ?></td>
                                    <td>
                                        <a href="modifier.php?id=<?= $n['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
                                        <a href="supprimer.php?id=<?= $n['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">🗑</a>
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
