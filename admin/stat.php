<?php

require_once('../include/init.php');


if (!internauteConnecteAdmin()) {
    header("Location: connexion.php");
    exit();
}


// Requête pour récupérer les 5 membres les mieux notés
$statistique = "SELECT membre_id1, AVG(note) as note_moyenne
        FROM note
        GROUP BY membre_id1
        ORDER BY note_moyenne DESC
        LIMIT 5";

// Exécution de la requête
$resultat = mysqli_query($conn, $statistique);

// Tableau pour stocker les données
$membres_notes = array();

// Ajouter les résultats au tableau
// if (mysqli_num_rows($resultat) > 0) {
//     while ($stat = mysqli_fetch_assoc($resultat)) {
//         $membres_notes[] = array(
//             "id" => $stat["membre_id1"],
//             "note" => $stat["note_moyenne"]
//         );
//     }
// }

// Récupération des 5 membres les plus actifs
$statistique = "SELECT m.id_membre, m.pseudo, COUNT(a.id_article) as nb_articles
        FROM membre m
        LEFT JOIN article a ON m.id_membre = a.membre_id
        GROUP BY m.id_membre
        ORDER BY nb_articles DESC
        LIMIT 5;";
$result = $conn->query($statistique);

// Tableau pour stocker les données
$membres_actifs = array();

// Ajouter les résultats au tableau
// if ($result->num_rows > 0) {
//     while ($stat = $result->fetch_assoc()) {
//         $membres_actifs[] = array(
//             "id" => $stat["id_membre"],
//             "pseudo" => $stat["pseudo"],
//             "nb_articles" => $stat["nb_articles"]
//         );
//     }
// }
// Requête SQL pour récupérer le top 5 des catégories contenant le plus d'articles
$lesCategories = "SELECT categorie_id, COUNT(*) AS nb_articles 
        FROM article 
        GROUP BY categorie_id 
        ORDER BY nb_articles DESC 
        LIMIT 5";
$result = $conn->query($lesCategories);
// Vérification des résultats et stockage des données dans un tableau
$categories = array();
// if ($result->num_rows > 0) {
//     while ($stat = $result->fetch_assoc()) {
//         $categorie_id = $stat["categorie_id"];
//         $nb_articles = $stat["nb_articles"];

//         // Requête SQL pour récupérer le nom de la catégorie
//         $lesCategories_categorie = "SELECT titre FROM categorie WHERE id_categorie = $categorie_id";
//         $result_categorie = $conn->query($lesCategories_categorie);
//         $stat_categorie = $result_categorie->fetch_assoc();
//         $titre_categorie = $stat_categorie["titre"];

//          // Stockage des données dans un tableau
//          $categories[] = array(
//             "categorie" => $titre_categorie,
//             "nb_articles" => $nb_articles
//         );
//     }
// } else {
//     echo "0 résultats";
// }
// Requête SQL pour récupérer les 5 articles les plus anciennes
$statistique = "SELECT *
        FROM article
        ORDER BY date_enregistrement ASC
        LIMIT 5;";
$result = $conn->query($statistique);

// Tableau pour stocker les données
$articles_anciennes = array();

// Afficher les résultats dans le tableau 
// if ($result->num_rows > 0) {
//     while ($stat = $result->fetch_assoc()) {
//         $articles_anciennes[] = array(
//             "titre" => $stat["titre"],
//             "description_courte" => $stat["description_courte"],
//             "description_longue" => $stat["description_longue"],
//             "prix" => $stat["prix"],
//             "photo" => $stat["photo"],
//             "pays" => $stat["pays"],
//             "ville" => $stat["ville"],
//             "adresse" => $stat["adresse"],
//             "cp" => $stat["cp"],
//             "membre_id" => $stat["membre_id"],
//             "photo_id" => $stat["photo_id"],
//             "categorie_id" => $stat["categorie_id"],
//             "date_enregistrement" => $stat["date_enregistrement"]
//         );
//     }
// }
require_once('includeAdmin/header.php');
?>

<div class="container">
    <div class="row">
    <div class="row">
                <!-- Tableau MEMBRES -->
        <div class="col-md-6">
            <h2>Membres les plus actifs</h2>
            <table class="table table-bordered table-primary">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pseudo</th>
                        <th>Nombre d'articles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($membres_actifs as $membre_actif) : ?>
                        <tr>
                            <td><?= $membre_actif['id'] ?></td>
                            <td><?= $membre_actif['pseudo'] ?></td>
                            <td><?= $membre_actif['nb_articles'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <h2>Membres les mieux notés</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Note moyenne</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($membres_notes as $membre_note) : ?>
                        <tr>
                            <td><?= $membre_note['id'] ?></td>
                            <td><?= $membre_note['note'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Tableau CATEGORIES -->
        <div class="col-md-12 table-responsive">
            <h2>Catégories avec le plus d'articles</h2>
            <table class="table table-striped table-hover table-bordered  table-outline-light text-center">
                <thead>
                    <tr>
                        <th>Catégorie</th>
                        <th>Nombre d'articles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $categorie) : ?>
                        <tr>
                            <td><?= $categorie["categorie"] ?></td>
                            <td><?= $categorie["nb_articles"] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
    <!-- Tableau articleS -->
        <div class="col-md-12">
            <h2>articles les plus anciens</h2>
            <table class="table table-bordered  table-outline-light text-center table-responsive table-hover">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Description courte</th>
                        <th>Prix</th>
                        <th>Photo</th>
                        <th>Membre ID</th>
                        <th>Photo ID</th>
                        <th>Catégorie ID</th>
                        <th>Date d'enregistrement</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles_anciennes as $article) : ?>
                        <tr>
                            <td><?= $article['titre'] ?></td>
                            <td><?= $article['description_courte'] ?></td>
                            <td><?= $article['prix'] ?></td>
                            <td><?= $article['photo'] ?></td>
                            <td><?= $article['membre_id'] ?></td>
                            <td><?= $article['photo_id'] ?></td>
                            <td><?= $article['categorie_id'] ?></td>
                            <td><?= $article['date_enregistrement'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
</div>
<?php require_once('includeAdmin/footer.php'); ?>