<!-- menu -->
<?php
$liensMenu = array(
	'accueil' => array('index.php', 'Accueil'),
	'series' => array('index.php?page=series', 'Séries'),
	'afficher' => array('index.php?page=afficher', 'Toutes les données'),
	'ajouter' => array('index.php?page=ajouter', 'Ajouter une série'),
	'rechercher' => array('index.php?page=rechercher', 'Rechercher'),
	'historique' => array('index.php?page=historique', 'Historique'),
);
$pageMenuActive = ($pageCourante == 'serie') ? 'series' : $pageCourante; // la fiche d'une série relève de « Séries »
?>
<nav>
	<?php foreach($liensMenu as $cle => $lien) { ?>
		<a href="<?= $lien[0] ?>"<?= $cle == $pageMenuActive ? ' class="actif" aria-current="page"' : '' ?>><?= $lien[1] ?></a>
	<?php } ?>
</nav>
