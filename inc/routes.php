<?php

/*
** Il est possible d'automatiser le routing, notamment en cherchant directement le fichier controleur et le fichier vue.
** ex, pour page=afficher : verification de l'existence des fichiers controleurs/controleurAfficher.php et vues/vueAfficher.php
** Cela impose un nommage strict des fichiers.
*/

$routes = array(
	'series' => array('controleur' => 'controleurSeries', 'vue' => 'vueSeries'),
	'serie' => array('controleur' => 'controleurSerie', 'vue' => 'vueSerie'),
	'afficher' => array('controleur' => 'controleurAfficher', 'vue' => 'vueAfficher'),
	'ajouter' => array('controleur' => 'controleurAjouter', 'vue' => 'vueAjouter'),
	'rechercher' => array('controleur' => 'controleurRechercher', 'vue' => 'vueRechercher'),
	'historique' => array('controleur' => 'controleurHistorique', 'vue' => 'vueHistorique')
);

// fichiers statiques
$pathHeader = 'static/header.php';
$pathMenu = 'static/menu.php';
$pathFooter = 'static/footer.php';
$controleurAccueil = 'controleurAccueil';
$vueAccueil = 'vueAccueil';
?>
