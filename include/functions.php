<?php
// Fichier Functions.php
function debug($var, $mode = 1){
    $trace = debug_backtrace();
    // array_shift, fonction prédéfinie qui permet de contourner une dimension d'un tableau 
    $trace = array_shift($trace);

    echo "Debug demandé à la ligne <strong> $trace[line]</strong>,dans le fichier <strong> $trace[file] </strong> ";

    if($mode == 1){
        echo "<pre>"; print_r($var); echo "</pre>";
    }else{
        echo "<pre>"; var_dump($var); echo "</pre>";
    }

}

// fonction qui détermine si un utilisateur est connecté 
function internauteConnecte(){
    if(!isset($_SESSION['membre'])){
        return FALSE;
    }else{
        // dans le cas ou  ce fichier existe
        return TRUE;
    }
}

function internauteConnecteAdmin(){
    if(internauteConnecte() && $_SESSION['membre']['statut'] == 1){
        return TRUE;

    }else {
        return FALSE;
    }
}