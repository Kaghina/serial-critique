<?php

/****************
Paramètres de connexion à la BD, choisis automatiquement :
- EN LOCAL (site ouvert via http://localhost/...) : WAMP/XAMPP, réglages ci-dessous ;
- SUR LE SERVEUR DE L'UE : identifiants lus dans "inc/config-bd.local.php" (fichier privé,
  non versionné : copiez "inc/config-bd.local.example.php" pour le créer).
****************/

$enLocal = PHP_SAPI === 'cli'
	|| in_array($_SERVER['SERVER_NAME'] ?? '', array('localhost', '127.0.0.1', '::1'), true);

if(file_exists('../serial-critique-private/config-bd.php'))  // fichier de configuration "privé" (enseignants)
	require('../serial-critique-private/config-bd.php');
elseif($enLocal) {
	// ===== EN LOCAL (WAMP : MySQL sur le port 3308, MariaDB sur 3307 ; XAMPP : 3306) =====
	define('SERVEUR', '127.0.0.1');
	define('PORT', 3308);
	define('UTILISATRICE', 'root'); // utilisateur par défaut de WAMP/XAMPP
	define('MOTDEPASSE', '');       // mot de passe vide par défaut
	define('BDD', 'serial_critique');
}
elseif(file_exists(__DIR__ . '/config-bd.local.php')) {
	// ===== SERVEUR DE L'UE (bdw.univ-lyon1.fr) =====
	require(__DIR__ . '/config-bd.local.php');
}
else {
	exit("Configuration manquante : copiez inc/config-bd.local.example.php en inc/config-bd.local.php et renseignez vos identifiants.");
}

if(!defined('PORT'))
	define('PORT', 3306); // port MySQL standard
?>
