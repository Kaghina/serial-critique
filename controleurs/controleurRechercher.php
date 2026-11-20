<?php
$titrePage = 'Rechercher';
// la connexion $connexion est déjà ouverte par index.php

if(isset($_POST['boutonValider'])) {

	$valeur = trim($_POST['valeur'] ?? '');
	$table = $_POST['champRech'] ?? '';

	if(!in_array($table, array('Series', 'Actrices'), true)) {
		$message = "Table de recherche invalide.";
	}
	elseif($valeur === '') {
		$message = "Veuillez saisir une valeur à rechercher.";
	}
	else {
		ajouterActiviteHistorique("recherche du terme $valeur dans la table $table");
		$resultats = search($connexion, $table, $valeur); // requête préparée : pas besoin d'échapper $valeur
		if(count($resultats) == 0) {
			$message = "Aucun résultat pour cette valeur !";
		}
	}
}
?>
