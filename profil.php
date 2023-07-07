<?php
require_once('include/init.php');
require_once('include/affichage.php');


// $pageTitle = "Profil de " . $_SESSION['membre']['pseudo'];

// si le user n'est PAS connecté, alors on lui interdit l'accès à la page profil (redirection vers la page connexion ou autre selon reflexion)

if(!internauteConnecte()){
    header('location' . URL . 'connexion.php');
    exit();
}
if(isset($_GET['action']) && $_GET['action'] == 'validate') {

    $validate .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                    Félicitations, vous etes connecté 😉 !
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
}

$content .= '<div class="alert alert-success alert-dismissible fade show
mt-5" role="alert">
<strong>Félicitations !</strong> Votre profil a été modifier avec succès 😉 !
<button type="button" class="close" data-dismiss="alert" arialabel="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>';  

require_once('header.php');
?>

<?= $validate ?>

<!-- FORM PROFIL UTILISATEUR -->

<div class="header d-flex align-items-center justify-content-center vh-100 flex-wrap">
    <div class="hero-wrapper">
		<h1 class="text-center text-wrap  my-5">Bonjour <?= (internauteConnecteAdmin()) ? $_SESSION['membre']['pseudo'] .' ! <br> ' . "Vous êtes admin du site" : $_SESSION['membre']['pseudo'] ?>
        <!-- Bouton pour déposer un article -->
        <a href="post-article.php"><button class=" w-50 my-4 py-2 shadow btn btn-outline-dark border-0 btn-outline-primary btn-16 px-4  ">Déposez votre article</button></a></h1>
	</div>
	<div class="row justify-content-center w-col w-col-6 w-col-medium-6 ">
			<div class="col-md-10">
				<div class="card-body  bg-opacity-75 bg-light border-0 card rounded-sm">

					<div class="card-body ">
						<div class="row justify-content-around py-3">
							<div class="col-md-8">
							<form action="modif_profil.php" method="POST">
                        <div class="mb-3">
                            <label for="nouveau_pseudo" class="form-label">Pseudo</label>
                            <input type="text" class="form-control" id="nouveau_pseudo" name="nouveau_pseudo" value="<?= $_SESSION['membre']['pseudo'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="nouveau_nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nouveau_nom" name="nouveau_nom" value="<?= $_SESSION['membre']['nom'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="nouveau_prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="nouveau_prenom" name="nouveau_prenom" value="<?= $_SESSION['membre']['prenom'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="nouveau_mail" class="form-label">Adresse email</label>
                            <input type="email" class="form-control" id="nouveau_email" name="nouveau_email" value="<?= $_SESSION['membre']['email'] ?>">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-outline-light">Enregistrer les modifications</button>
                        </div>
                    </form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    </div>

    
	<?php
// Récupération des articles du membre
$id_membre = $_SESSION['membre']['id_membre'];
$recup = $pdo->prepare("SELECT * FROM articles WHERE membre_id = ?");
$recup->execute([$id_membre]);
$articles = $recup->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- Affiches des articles du membre -->

<div class=" my-5 row justify-content-center py-5">
    <div class="col-md-6">
        <h2 class="text-center mb-4">Vos articles</h2>
        <?php foreach ($articles as $articles) { ?>
            <div class="card mb-2 ">
                <div class="card-body ">
                    <h5 class="card-title"><?= $articles['titre'] ?></h5>
                    <?php if (!empty($articles['photo'])) { ?>
                        <img src="<?= URL . 'img/' . $articles['photo'] ?>" class="card-img-top mb-3" alt="Photo de l'articles">
                    <?php } ?>
                    <p class="card-text"><?= $articles['description_longue'] ?></p>
                    <p class="card-text"><small class="text-muted">Publiée le <?= $articles['date_enregistrement'] ?></small></p>
					<!-- Bouton pour voir ou supprimer l'articles -->
					<a href="modif_articles.php?id=<?= $articles['id_article'] ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
					<a href="fiche_article.php?id_article=<?= $articles['id_article']?>" class="btn btn-sm btn-outline-primary">Voir l'article</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>



<?php require_once('footer.php'); ?>