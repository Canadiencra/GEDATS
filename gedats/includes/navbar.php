<nav> 
  <i class='bx bx-menu'></i>
  <a href="#" class="nav-link">GEDATS</a>
  
  <?php
  // On récupère la page active
  $pageCourante = basename($_SERVER['PHP_SELF']);

  // On autorise la recherche que sur certaines pages
  $pagesAvecRecherche = ['liste.php', 'structures.php', 'agrements.php']; // ajoute les pages nécessaires

  // On vérifie si la page doit afficher la barre de recherche
  $afficherRecherche = in_array($pageCourante, $pagesAvecRecherche);
?>

<?php if ($afficherRecherche): ?>
  <form action="<?= $pageCourante ?>" method="GET">
    <div class="form-input">
      <input type="search" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" placeholder="Rechercher...">
      <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
    </div>
  </form>
<?php else: ?>
  <div class="form-input disabled">
    <input type="search" placeholder="Recherche indisponible ici..." disabled>
    <button type="button" class="search-btn"><i class='bx bx-search'></i></button>
  </div>
<?php endif; ?>

  
  <input type="checkbox" id="switch-mode" hidden>
  <label for="switch-mode" class="switch-mode"></label>
  
  <a href="#" class="notification">
    <i class='bx bxs-bell'></i>
    <span class="num">3</span>
  </a>

  <div class="profile" id="profileDropdown">
    <img src="<?= dirname($_SERVER['PHP_SELF']) === '/dashboard' ? '../assets/images/user.png' : '../../assets/images/user.png' ?>" alt="Profil">
    <div class="profile-menu" id="dropdownMenu">
      <a href="#">Mon Profil</a>
      <a href="#">Changer mot de passe</a>
      <a href="<?= dirname($_SERVER['PHP_SELF']) === '/dashboard' ? '../logout.php' : '../../logout.php' ?>">Déconnexion</a>
    </div>
  </div>
</nav>

<style>
  .profile {
    position: relative;
    cursor: pointer;
  }

  .profile img {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #3C91E6;
  }

  .profile-menu {
    display: none;
    position: absolute;
    right: 0;
    top: 50px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    padding: 10px 0;
    z-index: 1000;
    min-width: 180px;
  }

  .profile-menu a {
    display: block;
    padding: 10px 16px;
    color: #333;
    text-decoration: none;
    font-size: 14px;
    transition: background 0.2s;
  }

  .profile-menu a:hover {
    background-color: #f5f5f5;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const profile = document.getElementById('profileDropdown');
    const menu = document.getElementById('dropdownMenu');

    profile.addEventListener('click', function (e) {
      e.stopPropagation();
      menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function () {
      menu.style.display = 'none';
    });
  });
</script>
