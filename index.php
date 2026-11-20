<?php
// index.php fait office de controleur frontal
session_start(); // démarre ou reprend une session
ini_set('display_errors', 1); // affiche les erreurs (au cas où)
ini_set('display_startup_errors', 1); // affiche les erreurs (au cas où)
error_reporting(E_ALL); // affiche les erreurs (au cas où)
date_default_timezone_set('Europe/Paris'); // fuseau horaire utilisé par date()
require('inc/routes.php'); // fichiers de routes
require('inc/includes.php'); // inclut des informations du site (nom, slogan)
require('inc/config-bd.php'); // fichier de configuration d'accès à la BD
require_once('modele/modele.php'); // inclut le fichier modele

$connexion = getConnexionBD(); // connexion à la BD

// choix du contrôleur et de la vue à charger
$pageCourante = 'accueil';
$controleur = $controleurAccueil; // par défaut, on charge la page d'accueil
$vue = $vueAccueil;
if(isset($_GET['page']) && isset($routes[$_GET['page']])) { // si la page existe dans le tableau des routes, on la charge
	$pageCourante = $_GET['page'];
	$controleur = $routes[$pageCourante]['controleur'];
	$vue = $routes[$pageCourante]['vue'];
}

// le contrôleur est exécuté AVANT tout affichage : il peut ainsi rediriger (header Location) si besoin
include('controleurs/' . $controleur . '.php');
$flash = recupererFlash(); // message éventuel laissé avant une redirection
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!-- le titre du document, qui apparait dans l'onglet du navigateur -->
	<title><?= isset($titrePage) ? e($titrePage) . ' – ' : '' ?><?= e($nomSite) ?></title>
	<!-- lie le style CSS externe  -->
	<link href="<?= $styleCSS ?>" rel="stylesheet" media="all" type="text/css">
	<!-- ajoute une image favicon (dans l'onglet du navigateur) -->
	<link rel="icon" type="image/png" href="img/sheep.png" />
</head>
<body>
	<?php include($pathHeader); ?>
	<div id="divCentral">
		<?php include($pathMenu); ?>

		<main>
		<?php if($flash !== null) { ?>
			<p class="message message-<?= e($flash['type']) ?>"><?= e($flash['texte']) ?></p>
		<?php } ?>
		<?php include('vues/' . $vue . '.php'); ?>
		</main>
	</div>
	<?php include($pathFooter); ?>
</body>
</html>
<?php deconnectBD($connexion); ?>
