<?php
require_once '../includes/config.php';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';
require_once 'includes/topbar.php';
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12 mb-4">
            <h3 class="fw-bold">Tableau de bord - GEDATS</h3>
            <p class="text-muted">Bienvenue <?= $_SESSION['user_nom'] ?? '' ?> 👋</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sociétés -->
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle p-3 me-3">
                        <i class="fas fa-building fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Sociétés</h6>
                        <h4 class="fw-bold mb-0">
                            <?php
                                $stmt = $pdo->query("SELECT COUNT(*) FROM societes");
                                echo $stmt->fetchColumn();
                            ?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Agréments -->
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success text-white rounded-circle p-3 me-3">
                        <i class="fas fa-certificate fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Agréments</h6>
                        <h4 class="fw-bold mb-0">
                            <?php
                                $stmt = $pdo->query("SELECT COUNT(*) FROM agrements");
                                echo $stmt->fetchColumn();
                            ?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inspecteurs -->
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning text-white rounded-circle p-3 me-3">
                        <i class="fas fa-user-check fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Inspecteurs</h6>
                        <h4 class="fw-bold mb-0">
                            <?php
                                $stmt = $pdo->query("SELECT COUNT(*) FROM utilisateurs WHERE role = 'inspecteur'");
                                echo $stmt->fetchColumn();
                            ?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Structures -->
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-danger text-white rounded-circle p-3 me-3">
                        <i class="fas fa-cubes fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Structures</h6>
                        <h4 class="fw-bold mb-0">
                            <?php
                                $total = 0;
                                foreach (['navires','entrepots','glaces','transports','etablissements','gboya'] as $table) {
                                    $count = $pdo->query("SELECT COUNT(*) FROM $table")->fetchColumn();
                                    $total += $count;
                                }
                                echo $total;
                            ?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Graphique Placeholder -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">📊 Statistiques à venir</h5>
                    <canvas id="statistiquesChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('statistiquesChart').getContext('2d');
    const statistiquesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Navires', 'Entrepôts', 'Glaces', 'Transports', 'Etablissements', 'Gboya'],
            datasets: [{
                label: 'Structures enregistrées',
                backgroundColor: '#0d6efd',
                borderColor: '#0d6efd',
                data: [
                    <?= $pdo->query("SELECT COUNT(*) FROM navires")->fetchColumn() ?>,
                    <?= $pdo->query("SELECT COUNT(*) FROM entrepots")->fetchColumn() ?>,
                    <?= $pdo->query("SELECT COUNT(*) FROM glaces")->fetchColumn() ?>,
                    <?= $pdo->query("SELECT COUNT(*) FROM transports")->fetchColumn() ?>,
                    <?= $pdo->query("SELECT COUNT(*) FROM etablissements")->fetchColumn() ?>,
                    <?= $pdo->query("SELECT COUNT(*) FROM gboya")->fetchColumn() ?>
                ],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            }
        }
    });
</script>
