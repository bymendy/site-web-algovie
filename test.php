// connexion à la bdd en local
// dans ce fichier init, je code ce qui va me servir sur l'intégralité des fichiers du site algovie

// connexion à la bdd en local
$pdo = new PDO('mysql:host=localhost;dbname=algovie', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8') );

// le session_start obligatoire en haut de chaque fichier
session_start();

// constante pour définir le chemin vers mon projet (je récupère automatiqument C:/wamp/www grace à $_SERVER[DOCUMENT_ROOOT] auquel je concatène le dossier de mon projet)
// ce chemin fonctionnera en local comme en ligne
define('RACINE_SITE', $_SERVER['DOCUMENT_ROOT'] .'/algovie/' );

// constante URL pour notre projet (a modifier avec le nom de domaine plus tard lorsque le site sera hébergé, mis en ligne)
define('URL', 'http://localhost/algovie/');

// initialisation de qlq variables utiles sur tout le site
$erreur = "";
$erreur_index = "";
$validate = "";
$validate_index = "";
$content = "";
$toutesArticles = ['1 = 1'];

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'algovie';


***************************************************************
// connexion à la bdd en ligne
$pdo = new PDO('mysql:host=cl1-sql10;dbname=guk19762', 'guk19762', 'cdYwHI7Wbsnc', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8') );

// le session_start obligatoire en haut de chaque fichier
session_start();

// constante pour définir le chemin vers mon projet (je récupère automatiqument C:/wamp/www grace à $_SERVER[DOCUMENT_ROOOT] auquel je concatène le dossier de mon projet)
// ce chemin fonctionnera en local comme en ligne
define('RACINE_SITE', $_SERVER['DOCUMENT_ROOT'] .'/algovie/' );

// constante URL pour notre projet (a modifier avec le nom de domaine plus tard lorsque le site sera hébergé, mis en ligne)
define('URL', 'https://algovie.bymendy.fr/');

// initialisation de qlq variables utiles sur tout le site
$erreur = "";
$erreur_index = "";
$validate = "";
$validate_index = "";
$content = "";
$toutesArticles = ['1 = 1'];

$servername = 'cl1-sql10';
$username = 'guk19762';
$password = 'cdYwHI7Wbsnc';
$dbname = 'guk19762';