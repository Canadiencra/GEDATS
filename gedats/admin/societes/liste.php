<?php
require_once '../../includes/config.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
require_once '../includes/topbar.php';

// Gestion de la recherche
$search = $_GET['search'] ?? '';
if (!empty($search)) {
    $stmt = $pdo->prepare("SELECT * FROM societes 
        WHERE nom LIKE :search 
        OR responsable LIKE :search 
        OR telephone LIKE :search 
        OR email LIKE :search 
        OR adresse LIKE :search 
        ORDER BY date_enregistrement DESC");
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM societes ORDER BY date_enregistrement DESC");
}
$societes = $stmt->fetchAll();
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📋 Liste des sociétés</h5>
            <a href="ajouter.php" class="btn btn-light btn-sm">➕ Ajouter une société</a>
        </div>
        <div class="card-body">
            <!-- Barre de recherche -->
            <form method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="🔍 Rechercher par nom, responsable, téléphone..." value="<?= htmlspecialchars($search) ?>">
                    <button class="btn btn-outline-primary" type="submit">Rechercher</button>
                    <?php if ($search): ?>
                        <a href="liste.php" class="btn btn-outline-secondary">Annuler</a>
                    <?php endif; ?>
                </div>
            </form>

            <?php if (count($societes) === 0): ?>
                <div class="alert alert-warning">Aucune société trouvée.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Responsable</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>Adresse</th>
                                <th>Date enregistrement</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($societes as $i => $societe): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($societe['nom']) ?></td>
                                    <td><?= htmlspecialchars($societe['responsable']) ?></td>
                                    <td><?= htmlspecialchars($societe['telephone']) ?></td>
                                    <td><?= htmlspecialchars($societe['email']) ?></td>
                                    <td><?= htmlspecialchars($societe['adresse']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($societe['date_enregistrement'])) ?></td>
                                    <td>
                                        <a href="modifier.php?id=<?= $societe['id'] ?>" class="btn btn-sm btn-warning">✏️ Modifier</a>
                                        <a href="supprimer.php?id=<?= $societe['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">🗑 Supprimer</a>
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
