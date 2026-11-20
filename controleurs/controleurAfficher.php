<?php
ajouterActiviteHistorique('affichage des données');
$titrePage = 'Toutes les données';
$message = "";

// recupération des séries, chacune avec les critiques qui la concernent
$seriesCritiques = getSeriesAvecCritiques($connexion);
if(count($seriesCritiques) == 0) {
	$message .= "Aucune série n'a été trouvée dans la base de données ! ";
}

// recupération de toutes les critiques
$critiques = getCritiques($connexion);
if(count($critiques) == 0) {
	$message .= "Aucune critique n'a été trouvée dans la base de données ! ";
}

// recupération des actrices
$actrices = getInstances($connexion, "Actrices");
if(count($actrices) == 0) {
	$message .= "Aucun acteur ni aucune actrice n'a été trouvé·e dans la base de données ! ";
}

// recupération des épisodes numérotés 1 et 2 avec une requête préparée
$stmt = prepareRequeteEpisodes($connexion);
$episodes1 = getEpisodesPrepared($stmt, 1);
if(count($episodes1) == 0) {
	$message .= "Aucun épisode numéroté 1 n'a été trouvé dans la base de données ! ";
}
$episodes2 = getEpisodesPrepared($stmt, 2);
if(count($episodes2) == 0) {
	$message .= "Aucun épisode numéroté 2 n'a été trouvé dans la base de données ! ";
}
if($stmt != null)
	mysqli_stmt_close($stmt);

?>
