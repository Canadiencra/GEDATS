<?php
// Définir le préfixe relatif pour les liens selon la profondeur du fichier actuel
$prefix = dirname($_SERVER['PHP_SELF']);
$prefix = (strpos($prefix, '/modules') !== false) ? '../../' : '../';
?>

<section id="sidebar">
 <a href="#" class="brand">
  <img src="../../assets/images/logo-onsap.png" alt="Logo GEDATS" style="height: 36px; margin-right: 8px;">
  <span class="text">GEDATS</span>
</a>
  <ul class="side-menu top">
    <li class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
      <a href="../../templates/dashboard.php">
        <i class='bx bxs-dashboard'></i>
        <span class="text">Tableau de Bord</span>
      </a>
    </li>

    <li class="<?= strpos($_SERVER['PHP_SELF'], 'societes') !== false ? 'active' : '' ?>">
      <a href="<?= $prefix ?>modules/societes/liste.php">
        <i class='bx bxs-building'></i>
        <span class="text">Sociétés</span>
      </a>
    </li>

    <li class="<?= strpos($_SERVER['PHP_SELF'], 'structures') !== false ? 'active' : '' ?>">
      <a href="<?= $prefix ?>modules/structures/liste.php">
        <i class='bx  bxs-network-chart'></i>
        <span class="text">Structures</span>
      </a>
    </li>

    <li class="<?= strpos($_SERVER['PHP_SELF'], 'agrements') !== false ? 'active' : '' ?>">
      <a href="<?= $prefix ?>modules/agrements/liste.php">
        <i class='bx bxs-certification'></i>
        <span class="text">Agréments</span>
      </a>
    </li>

    <li class="<?= strpos($_SERVER['PHP_SELF'], 'certificats') !== false ? 'active' : '' ?>">
      <a href="<?= $prefix ?>modules/certificats/liste.php">
        <i class='bx bxs-file-doc'></i>
        <span class="text">Certificats</span>
      </a>
    </li>

    <li class="<?= strpos($_SERVER['PHP_SELF'], 'inspections') !== false ? 'active' : '' ?>">
      <a href="<?= $prefix ?>modules/inspections/liste.php">
        <i class='bx bxs-search-alt-2'></i>
        <span class="text">Inspections</span>
      </a>
    </li>

    <li class="<?= strpos($_SERVER['PHP_SELF'], 'utilisateurs') !== false ? 'active' : '' ?>">
      <a href="<?= $prefix ?>modules/utilisateurs/liste.php">
        <i class='bx bxs-user'></i>
        <span class="text">Utilisateurs</span>
      </a>
    </li>
  </ul>

  <ul class="side-menu">
    <li>
      <a href="#">
        <i class='bx bxs-cog'></i>
        <span class="text">Paramètres</span>
      </a>
    </li>
    <li>
      <a href="<?= $prefix ?>logout.php" class="logout">
        <i class='bx bxs-log-out-circle'></i>
        <span class="text">Déconnexion</span>
      </a>
    </li>
  </ul>
</section>
