<?php
// contrôleur de la page d'accueil : statistiques et dernières critiques (la vue ne fait plus de requête)
$nbSeries = countInstances($connexion, "Series");
$nbEpisodes = countInstances($connexion, "Episodes");
$nbActrices = countInstances($connexion, "Actrices");
$nbCritiques = countInstances($connexion, "Critiques");
$dernieresCritiques = ($nbSeries >= 0) ? getDernieresCritiques($connexion, 3) : array();
?>
