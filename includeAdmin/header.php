<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Algovie Admin</title>

  <!--links  Bootstrap  -->
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- links sidebar -->
  <link href="css/simple-sidebar.css" rel="stylesheet">

  <!-- links pour les icon bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

  <!-- {# links pour databaseTables #} -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"/>

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-dark border-right" id="sidebar-wrapper">
      <div class="sidebar-heading text-dark">Algovie Admin </div>
      <div class="list-group list-group-flush">
        <!-- Gestion Membre -->
        <a href="<?= URL ?>admin/gestion_membre.php" class="list-group-item list-group-item-action bg-dark text-light py-5"><button type="button" class="btn btn-outline-dark text-light">Gestion des membres</button></a>
        <!-- Gestion Annonce -->
        <a href="<?= URL ?>admin/gestion_annonce.php" class="list-group-item list-group-item-action bg-dark text-light py-5"><button type="button" class="btn btn-outline-dark text-light">Gestion des articles</button></a>
        <!-- Gestion Categorie -->
        <a href="<?= URL ?>admin/gestion_categorie.php" class="list-group-item list-group-item-action bg-dark text-light py-5"><button type="button" class="btn btn-outline-dark text-light">Gestion des catégories</button></a>
        <a href="<?= URL ?>admin/stat.php" class="list-group-item list-group-item-action bg-dark text-light py-5"><button type="button" class="btn btn-outline-dark text-light">Statistiques</button></a>
        <!-- Retour Home  -->
        <a href="<?= URL ?>index.php" class="list-group-item list-group-item-action bg-dark text-light py-5"><button type="button" class="btn btn-outline-dark text-light">Retour Accueil Algovie</button></a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

<nav class="navbar navbar-expand-lg navbar-dark  border-bottom">
  <button class="btn btn-lg btn-outline-dark" id="menu-toggle"><i class="bi bi-caret-left-square-fill"></i> Menu <i class="bi bi-caret-right-square-fill"></i></button>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="<?= URL ?>index.php"><button type="button" class="btn btn-dark text-light">Home Algovie</button></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= URL ?>admin/index.php"><button type="button" class="btn btn-dark text-light">Home Admin</button></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <button type="button" class="btn btn-dark text-light">Menu Admin</button>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?= URL ?>admin/gestion_membre.php">Gestion des membres</a>
          <a class="dropdown-item" href="<?= URL ?>admin/gestion_annonce.php">Gestion des articles</a>
          <a class="dropdown-item" href="<?= URL ?>admin/gestion_categorie.php">Gestion des catégories</a>
          <a class="dropdown-item" href="<?= URL ?>admin/gestion_notes.php">Détail des commentaires</a>

        </div>
      </li>
    </ul>
  </div>
</nav>

<div class="container mb-5">