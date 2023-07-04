<?php
require_once('../include/init.php');

if(!internauteConnecteAdmin()){
    header('location:' . URL . 'connexion.php' );
    exit();
}

if(isset($_GET['action']) && $_GET['action'] == 'validate'){
    $validate .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                  Félicitations <strong>' . $_SESSION['membre']['pseudo'] .'</strong>, vous etes connecté 😉 !
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
}

require_once('includeAdmin/header.php');
?>

        <div class=" align-items-center justify-content-center vh-100">

        <h1 class="my-5 text-center"><div class="badge badge-light text-wrap p-3">Accueil Admin</div></h1>
        <?= $validate ?>
        <h2 class="text-center my-5"><div class="badge badge-dark text-wrap p-3">Bonjour <?= $_SESSION['membre']['pseudo'] ?> </div></h2>
        

        <div class=" justify-content-around ">
                <img class='img-fluid w-100' src="../img/home-office.png" alt="Image du Back Office" loading="lazy">  
        </div>
        </div>
<?php require_once('includeAdmin/footer.php'); ?>