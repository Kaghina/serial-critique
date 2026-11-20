<?php
$nomSite = "Serial critique";
$baseline = "Critiquez vos séries !";
$styleCSS = "css/style.css";

define('REP_HISTO', 'historiques');  // répertoire des fichiers d'historique

// ajout d'une activité d'historique (avec date) à la session
function ajouterActiviteHistorique($activite) {
	if(!isset($_SESSION['historique']) || !is_array($_SESSION['historique']))
		$_SESSION['historique'] = array();
	$_SESSION['historique'][] = array(date("Y-m-d H:i:s") => $activite);
}

// échappe une valeur avant de l'afficher dans le HTML (protection contre les failles XSS)
function e($valeur) {
	return htmlspecialchars((string) $valeur, ENT_QUOTES, 'UTF-8');
}

// URL de la fiche d'une série
function urlSerie($nomSerie) {
	return 'index.php?page=serie&nom=' . urlencode($nomSerie);
}

// formate une date SQL (AAAA-MM-JJ ou AAAA-MM-JJ HH:MM:SS) au format français
function dateFr($dateSql) {
	if($dateSql === null || $dateSql === '')
		return '';
	$ts = strtotime($dateSql);
	if($ts === false)
		return $dateSql;
	return strlen($dateSql) > 10 ? date('d/m/Y à H\hi', $ts) : date('d/m/Y', $ts);
}

// mémorise un message à afficher après une redirection (pattern Post/Redirect/Get)
function flash($type, $texte) {
	$_SESSION['flash'] = array('type' => $type, 'texte' => $texte);
}

// récupère (et efface) le message mémorisé
function recupererFlash() {
	if(!isset($_SESSION['flash']))
		return null;
	$flash = $_SESSION['flash'];
	unset($_SESSION['flash']);
	return $flash;
}

// redirige vers $url et arrête le script
function rediriger($url) {
	header('Location: ' . $url);
	exit();
}
?>
