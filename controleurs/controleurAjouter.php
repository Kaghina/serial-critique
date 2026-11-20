<?php
$titrePage = 'Ajouter une série';
if(isset($_POST['boutonValider'])) { // formulaire soumis

	$nomSerie = trim($_POST['nomSerie'] ?? ''); // recuperation de la valeur saisie

	if($nomSerie === '') {
		$message = "Le nom de la série ne peut pas être vide.";
	}
	elseif(mb_strlen($nomSerie) > 255) {
		$message = "Le nom de la série est trop long (255 caractères maximum).";
	}
	elseif(count(getSeriesByName($connexion, $nomSerie)) > 0) {
		$message = "Une série existe déjà avec ce nom ($nomSerie).";
	}
	elseif(insertSerie($connexion, $nomSerie)) {
		ajouterActiviteHistorique("ajout de la série $nomSerie");
		flash('succes', "La série « $nomSerie » a bien été ajoutée !");
		rediriger(urlSerie($nomSerie)); // on affiche directement la fiche de la nouvelle série
	}
	else {
		$message = "Erreur lors de l'insertion de la série « $nomSerie ».";
	}
}
else {
	ajouterActiviteHistorique('consultation ajout d\'une série');
}

?>
