<?php
ajouterActiviteHistorique('consultation historique');
$titrePage = 'Historique';

if(isset($_POST['boutonGenHisto'])) {
	// créer le répertoire des historiques s'il n'existe pas encore
	if(!is_dir(REP_HISTO))
		@mkdir(REP_HISTO, 0755, true);

	// construire le contenu puis écrire le fichier en une seule fois (le fichier est remplacé à chaque génération)
	$contenu = '';
	foreach($_SESSION['historique'] as $activiteDate)
		foreach($activiteDate as $date => $activite)
			$contenu .= "$date - $activite\n";

	$nomFichier = session_id() . '.log';
	$cheminFichier = REP_HISTO . '/' . $nomFichier; // '/' fonctionne aussi sous Windows et donne une URL valide

	if(@file_put_contents($cheminFichier, $contenu) === FALSE || !is_readable($cheminFichier)) {
		$erreurHisto = "Une erreur s'est produite, le fichier historique n'est pas disponible (droits d'écriture sur le répertoire « " . REP_HISTO . " » ?).";
	}
	else {
		$lienHisto = $cheminFichier;
	}
}

?>
