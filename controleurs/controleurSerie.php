<?php
// contrôleur de la fiche d'une série : saisons, épisodes, distribution, critiques + ajout d'une critique
$nomSerie = trim($_GET['nom'] ?? '');
$serieTrouvee = ($nomSerie !== '' && count(getSeriesByName($connexion, $nomSerie)) > 0);

if(!$serieTrouvee) {
	$titrePage = 'Série introuvable';
	return; // la vue affichera un message d'erreur
}

$titrePage = $nomSerie;

// --- traitement du formulaire d'ajout de critique ---
$erreurs = array();
$pseudoSaisi = $_SESSION['pseudo'] ?? ''; // on pré-remplit avec le dernier pseudo utilisé
$texteSaisi = '';

if(isset($_POST['boutonCritiquer'])) {
	$pseudoSaisi = trim($_POST['pseudo'] ?? '');
	$texteSaisi = trim($_POST['texte'] ?? '');

	if($pseudoSaisi === '')
		$erreurs[] = "Le pseudo est obligatoire.";
	elseif(mb_strlen($pseudoSaisi) > 100)
		$erreurs[] = "Le pseudo ne doit pas dépasser 100 caractères.";
	if($texteSaisi === '')
		$erreurs[] = "La critique ne peut pas être vide.";
	elseif(mb_strlen($texteSaisi) > 255)
		$erreurs[] = "La critique ne doit pas dépasser 255 caractères.";

	if(count($erreurs) == 0) {
		if(insertCritique($connexion, $pseudoSaisi, $texteSaisi, $nomSerie)) {
			$_SESSION['pseudo'] = $pseudoSaisi;
			ajouterActiviteHistorique("critique ajoutée sur la série $nomSerie");
			flash('succes', 'Merci ! Votre critique a bien été publiée.');
			rediriger(urlSerie($nomSerie) . '#critiques'); // Post/Redirect/Get : évite le double envoi en rafraîchissant
		}
		$erreurs[] = "Erreur lors de l'enregistrement de la critique.";
	}
}
else {
	ajouterActiviteHistorique("consultation de la série $nomSerie");
}

// --- données de la fiche ---
$saisons = getSaisonsAvecEpisodes($connexion, $nomSerie);
$distribution = getActricesSerie($connexion, $nomSerie);
$critiquesSerie = getCritiquesSerie($connexion, $nomSerie);
?>
