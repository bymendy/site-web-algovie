<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Algovie Admin</title>

  <!-- lien Bootstrap -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

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
    <div class="bg-primary border-right" id="sidebar-wrapper">
      <div class="sidebar-heading text-primary">Algovie Admin </div>
      <div class="list-group list-group-flush">
        <!-- Gestion Membre -->
        <a href="../admin/gestion_membre.php" class="list-group-item list-group-item-action bg-primary text-light py-5"><button type="button" class="btn btn-outline-primary text-light">Gestion des membres</button></a>
        <!-- Gestion article -->
        <a href="../admin/gestion_article.php" class="list-group-item list-group-item-action bg-primary text-light py-5"><button type="button" class="btn btn-outline-primary text-light">Gestion des articles</button></a>
        <!-- Gestion Categorie -->
        <a href="../admin/gestion_categorie.php" class="list-group-item list-group-item-action bg-primary text-light py-5"><button type="button" class="btn btn-outline-primary text-light">Gestion des catégories</button></a>
        <a href="../admin/stat.php" class="list-group-item list-group-item-action bg-primary text-light py-5"><button type="button" class="text-center btn btn-outline-primary text-light">Statistiques</button></a>
        <!-- Retour Home  -->
        <a href="../index.php" class="list-group-item list-group-item-action bg-primary text-light py-5"><button type="button" class="btn btn-outline-dark text-light">Retour Accueil Algovie</button></a>      </div>
    </div>
    <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

<nav class="navbar navbar-expand-lg navbar-primary  border-bottom">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="../index.php"><button type="button" class="btn btn-light text-dark">Home Algovie</button></a>
      </li>
    </ul>
  </div>
</nav>

<div class=" mb-5 container ">