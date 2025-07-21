<!-- Topbar -->
<div class="flex-grow-1">
    <nav class="navbar navbar-expand navbar-light bg-light px-4 shadow-sm">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold">GEDATS</span>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link">👤 <?= $_SESSION['user_nom'] ?? 'Utilisateur' ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="../../logout.php">🔓 Déconnexion</a>
                </li>
            </ul>
        </div>
    </nav>
    <main class="p-4">
