<?php
// contrôleur du catalogue : liste des séries avec quelques statistiques
ajouterActiviteHistorique('consultation du catalogue des séries');
$titrePage = 'Séries';

$resumeSeries = getResumeSeries($connexion);
?>
