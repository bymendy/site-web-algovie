<?php
require_once('include/init.php');
require_once('include/affichage.php');
if(!empty($_GET['id_article'])) {

    $recup_article = $pdo->prepare("SELECT articles.*, membre.*, categorie.titre AS titre_categorie FROM articles, categorie, membre WHERE id_membre = membre_id AND id_categorie = categorie_id AND id_article = :id_article");
    $recup_article->bindParam(':id_article', $_GET['id_article']);
    $recup_article->execute();

    // POUR RECUPERER LES PHOTOS
    if($recup_article->rowCount() > 0) {
        $infos_articles = $recup_article->fetch(PDO::FETCH_ASSOC);

        $liste_photos_annexes = $pdo->prepare("SELECT * FROM photo WHERE id_photo = :id_photo");
        $liste_photos_annexes->bindParam(':id_photo', $infos_articles['photo_id']);
        $liste_photos_annexes->execute();

        $infos_photos_annexes = $liste_photos_annexes->fetch(PDO::FETCH_ASSOC);
    } else {
        header('location:index.php');
    }

} else {
    header('location:index.php');
}

require_once('header.php');
?>
</div>
<div class=" d-flex align-items-center justify-content-center vh-100">
    <div class="row">
        <!-- debut de la colonne qui va afficher les categories -->
        <div class="container-fluid d-flex">
		<div class="row justify-content-center mx-auto">
			<div class="col-md-12">
            <ul class="nav nav-pills ">
            <li class="nav-item">
                <li class="nav-item">
                <?php while($menuCategorie = $afficheMenuCategories->fetch(PDO::FETCH_ASSOC)): ?>
                    <a class="btn btn-light my-2" href="<?= URL ?>?categorie=<?= $menuCategorie['id_categorie'] ?>"><?= $menuCategorie['titre'] ?></a>
                <?php endwhile; ?>
            </li>
        </ul>
                </li>
            </ul>
			</div>
		</div>
	</div>

        <!-- fin de la colonne catégories -->
        <div class="container p-5">
  <div class="row">
    <div class="col-md-8">
      <h1><?php echo $infos_articles['titre']; ?></h1>
      <div class="card shadow p-3 mb-5 bg-white rounded w-100" style="width: 22rem;"><img src=" <?= URL . 'img/' . $detail['photo'] ?>" class="card-img-top" alt="image de l'article"></div>





      <p><?php echo $infos_articles['description_longue']; ?></p>
      <div class="row">
    <div class="col-md-6">
    <p><strong>Date de publication</strong> : <?php echo $infos_articles['date_enregistrement']; ?></p>


    </div>
    <div class="col-md-6">

    <!-- Boutton pour contacter le membre ayant diffuser l'annonce  -->
    <a href="#" data-toggle="modal" data-target="#membreModal" class="btn btn-light btn-outline-primary">Publié par <?php echo $infos_articles['pseudo']; ?></a>
    </div>
  </div>
    </div>

    
  </div>

</div>




<?php require_once('footer.php');?>