<?php
require_once 'includes/config.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $mot_de_passe = trim($_POST['mot_de_passe']);

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $mot_de_passe === $user['mot_de_passe']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_role'] = $user['role'];

        // Redirection selon le rôle
        switch ($user['role']) {
            case 'admin':
                header("Location: admin/dashboard.php");
                break;
            case 'agent':
                header("Location: agent/dashboard.php");
                break;
            case 'inspecteur':
                header("Location: inspecteur/dashboard.php");
                break;
            case 'chef_service':
                header("Location: chef/dashboard.php");
                break;
            case 'personnel':
                header("Location: personnel/dashboard.php");
                break;
            default:
                $message = "Rôle inconnu.";
                session_destroy();
                break;
        }
        exit;
    } else {
        $message = "Email ou mot de passe incorrect.";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - GEDATS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap & Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Custom Style -->
    <style>
        body {
            background: linear-gradient(to right, #007bff, #00c6ff);
            font-family: 'Roboto', sans-serif;
        }
        .login-container {
            max-width: 450px;
            margin: auto;
            padding-top: 80px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            text-align: center;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0069d9;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="card">
        <div class="card-header py-3">
            <h4 class="mb-0">Connexion GEDATS</h4>
        </div>
        <div class="card-body p-4">
            <?php if ($message): ?>
                <div class="alert alert-danger"><?= $message ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" name="email" class="form-control" placeholder="Entrez votre email" required>
                </div>
                <div class="mb-3">
                    <label for="mot_de_passe" class="form-label">Mot de passe</label>
                    <input type="password" name="mot_de_passe" class="form-control" placeholder="••••••••••" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
