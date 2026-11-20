<!-- header -->
<header>
	<a href="index.php" class="logo">
		<img src="img/sheep.png" alt="Retour à l'accueil">
	</a>
	<div>
		<!-- le fameux titre <h1> à personnaliser ! faites-vous plaisir... -->
		<h1><a href="index.php"><?= e($nomSite) ?></a></h1>
		<!-- NB : le titre de l'onglet du navigateur est une métadonnée de la page (dans la balise <head> de index.php). -->
		<p class="baseline"><?= e($baseline) ?></p>
	</div>
</header>
