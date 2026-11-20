<?php

// connexion à la BD, retourne un lien de connexion
function getConnexionBD() {
	mysqli_report(MYSQLI_REPORT_OFF); // on gère nous-mêmes les erreurs (comportement identique en PHP 7 et 8)
	$connexion = @mysqli_connect(SERVEUR, UTILISATRICE, MOTDEPASSE, BDD, PORT);
	if (mysqli_connect_errno()) {
		printf("Échec de la connexion à la base de données : %s<br>Vérifiez les paramètres dans inc/config-bd.php.",
			htmlspecialchars(mysqli_connect_error(), ENT_QUOTES, 'UTF-8'));
		exit();
	}
	mysqli_set_charset($connexion, 'utf8mb4'); // noms en UTF8
	return $connexion;
}

// déconnexion de la BD
function deconnectBD($connexion) {
	mysqli_close($connexion);
}

// liste blanche des tables autorisées (un nom de table ne peut pas être passé en paramètre d'une requête préparée)
function tableAutorisee($nomTable) {
	return in_array($nomTable, array('Series', 'Saisons', 'Episodes', 'Actrices', 'Jouer', 'Critiques'), true);
}

// nombre d'instances d'une table $nomTable
function countInstances($connexion, $nomTable) {
	if(!tableAutorisee($nomTable))
		return -1;
	$res = mysqli_query($connexion, "SELECT COUNT(*) AS nb FROM $nomTable");
	if($res != FALSE) {
		$row = mysqli_fetch_assoc($res);
		return (int) $row['nb'];
	}
	return -1;  // valeur négative si erreur de requête
}

// retourne les instances d'une table $nomTable
function getInstances($connexion, $nomTable) {
	if(!tableAutorisee($nomTable))
		return array();
	$res = mysqli_query($connexion, "SELECT * FROM $nomTable");
	if($res == FALSE)
		return array();
	return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

// exécute une requête préparée et retourne les tuples résultats (tableau associatif)
function executerRequetePreparee($connexion, $requete, $types = '', $params = array()) {
	$stmt = mysqli_prepare($connexion, $requete);
	if($stmt == FALSE)
		return array();
	if($types !== '')
		mysqli_stmt_bind_param($stmt, $types, ...$params);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_get_result($stmt);
	$instances = ($res == FALSE) ? array() : mysqli_fetch_all($res, MYSQLI_ASSOC);
	mysqli_stmt_close($stmt);
	return $instances;
}

// retourne les informations sur la série nommée $nomSerie
function getSeriesByName($connexion, $nomSerie) {
	return executerRequetePreparee($connexion, "SELECT * FROM Series WHERE nomSerie = ?", "s", array($nomSerie));
}

// insère une nouvelle série nommée $nomSerie
function insertSerie($connexion, $nomSerie) {
	$stmt = mysqli_prepare($connexion, "INSERT INTO Series (nomSerie) VALUES (?)");
	if($stmt == FALSE)
		return FALSE;
	mysqli_stmt_bind_param($stmt, "s", $nomSerie);
	$res = mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	return $res;
}

// recherche $valeur dans la table $table ('Series' ou 'Actrices')
function search($connexion, $table, $valeur) {
	$motif = '%' . $valeur . '%';
	if($table == 'Series')
		return executerRequetePreparee($connexion, "SELECT * FROM Series WHERE nomSerie LIKE ?", "s", array($motif));
	if($table == 'Actrices')
		return executerRequetePreparee($connexion, "SELECT * FROM Actrices WHERE nom LIKE ? OR prenom LIKE ?", "ss", array($motif, $motif));
	return array(); // table non autorisée
}

// retourne les critiques, de la plus récente à la plus ancienne
function getCritiques($connexion) {
	return executerRequetePreparee($connexion,
		"SELECT idCritique, dateCritique, pseudo, texte, nomSerie FROM Critiques ORDER BY dateCritique DESC");
}

// retourne chaque série avec ses critiques : array(nomSerie => array(critique, ...))
function getSeriesAvecCritiques($connexion) {
	$lignes = executerRequetePreparee($connexion,
		"SELECT S.nomSerie, C.idCritique, C.dateCritique, C.pseudo, C.texte
		 FROM Series S LEFT JOIN Critiques C ON C.nomSerie = S.nomSerie
		 ORDER BY S.nomSerie, C.dateCritique DESC");
	$resultat = array();
	foreach($lignes as $ligne) {
		if(!isset($resultat[$ligne['nomSerie']]))
			$resultat[$ligne['nomSerie']] = array();
		if($ligne['idCritique'] !== null)
			$resultat[$ligne['nomSerie']][] = $ligne;
	}
	return $resultat;
}

// retourne chaque série avec son nombre de saisons, d'épisodes et de critiques
function getResumeSeries($connexion) {
	return executerRequetePreparee($connexion,
		"SELECT S.nomSerie,
		        (SELECT COUNT(*) FROM Saisons Sa WHERE Sa.nomSerie = S.nomSerie) AS nbSaisons,
		        (SELECT COUNT(*) FROM Episodes E JOIN Saisons Sa ON E.idSaison = Sa.idSaison WHERE Sa.nomSerie = S.nomSerie) AS nbEpisodes,
		        (SELECT COUNT(*) FROM Critiques C WHERE C.nomSerie = S.nomSerie) AS nbCritiques
		 FROM Series S
		 ORDER BY S.nomSerie");
}

// retourne les $nb dernières critiques
function getDernieresCritiques($connexion, $nb) {
	return executerRequetePreparee($connexion,
		"SELECT idCritique, dateCritique, pseudo, texte, nomSerie FROM Critiques ORDER BY dateCritique DESC LIMIT ?",
		"i", array($nb));
}

// retourne les saisons d'une série, chacune avec ses épisodes : array(idSaison => array('dateLancement' => ..., 'episodes' => array(...)))
function getSaisonsAvecEpisodes($connexion, $nomSerie) {
	$lignes = executerRequetePreparee($connexion,
		"SELECT Sa.idSaison, Sa.dateLancement, E.numero, E.titre
		 FROM Saisons Sa LEFT JOIN Episodes E ON E.idSaison = Sa.idSaison
		 WHERE Sa.nomSerie = ?
		 ORDER BY Sa.dateLancement, Sa.idSaison, E.numero",
		"s", array($nomSerie));
	$saisons = array();
	foreach($lignes as $ligne) {
		$id = $ligne['idSaison'];
		if(!isset($saisons[$id]))
			$saisons[$id] = array('dateLancement' => $ligne['dateLancement'], 'episodes' => array());
		if($ligne['numero'] !== null)
			$saisons[$id]['episodes'][] = array('numero' => $ligne['numero'], 'titre' => $ligne['titre']);
	}
	return $saisons;
}

// retourne les actrices ayant joué dans une série, avec leur nombre d'épisodes
function getActricesSerie($connexion, $nomSerie) {
	return executerRequetePreparee($connexion,
		"SELECT A.numINSEE, A.prenom, A.nom, COUNT(*) AS nbEpisodes
		 FROM Actrices A
		 JOIN Jouer J ON J.numINSEE = A.numINSEE
		 JOIN Saisons Sa ON Sa.idSaison = J.idSaison
		 WHERE Sa.nomSerie = ?
		 GROUP BY A.numINSEE, A.prenom, A.nom
		 ORDER BY A.nom, A.prenom",
		"s", array($nomSerie));
}

// retourne les critiques d'une série, de la plus récente à la plus ancienne
function getCritiquesSerie($connexion, $nomSerie) {
	return executerRequetePreparee($connexion,
		"SELECT idCritique, dateCritique, pseudo, texte FROM Critiques WHERE nomSerie = ? ORDER BY dateCritique DESC",
		"s", array($nomSerie));
}

// insère une critique (datée de maintenant) sur la série $nomSerie
function insertCritique($connexion, $pseudo, $texte, $nomSerie) {
	$stmt = mysqli_prepare($connexion, "INSERT INTO Critiques (dateCritique, pseudo, texte, nomSerie) VALUES (NOW(), ?, ?, ?)");
	if($stmt == FALSE)
		return FALSE;
	mysqli_stmt_bind_param($stmt, "sss", $pseudo, $texte, $nomSerie);
	$res = mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	return $res;
}

// prépare la requête qui retourne les épisodes
function prepareRequeteEpisodes($connexion) {
	$requete = "SELECT titre FROM Episodes WHERE numero = ?";
	$stmt = mysqli_prepare($connexion, $requete);
	if($stmt == false) {
		return null;
	}
	return $stmt;
}

// retourne les épisodes numérotés $numEpisode (tableau associatif) avec une requête préparée
function getEpisodesPrepared($stmt, $numEpisode) {
	if($stmt == null)
		return array();
	mysqli_stmt_bind_param($stmt, "i", $numEpisode); // lier la variable $numEpisode au paramètre de la requête
	mysqli_stmt_execute($stmt); // exécution de la requête
	$res = mysqli_stmt_get_result($stmt);  // récupération des tuples résultats
	if($res == FALSE)
		return array();
	return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

?>
