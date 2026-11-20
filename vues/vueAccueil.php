<section class="bandeau">
	<div>
		<h2>Le site de critique sur les séries</h2>
		<p>Parcourez les séries, découvrez leurs saisons et leur distribution, et partagez votre avis.</p>
		<p><a class="bouton" href="index.php?page=series">Voir les séries</a></p>
	</div>
	<img src="img/top-series.jpg" alt="Les meilleures séries" class="img-accueil" />
</section>

<?php if($nbSeries < 0) { ?>
	<p class="message message-erreur">Erreur : impossible de lire la table Series. Avez-vous importé le fichier bd.sql ?</p>
<?php } else { ?>
	<div class="stats">
		<div><span class="chiffre"><?= $nbSeries ?></span> série(s)</div>
		<div><span class="chiffre"><?= max(0, $nbEpisodes) ?></span> épisode(s)</div>
		<div><span class="chiffre"><?= max(0, $nbActrices) ?></span> acteur·ice(s)</div>
		<div><span class="chiffre"><?= max(0, $nbCritiques) ?></span> critique(s)</div>
	</div>

	<h3>Dernières critiques</h3>
	<?php if(count($dernieresCritiques) == 0) { ?>
		<p class="vide">Aucune critique pour l'instant.</p>
	<?php } ?>
	<?php foreach($dernieresCritiques as $critique) { ?>
		<blockquote class="critique">
			<p><?= e($critique['texte']) ?></p>
			<footer>— <strong><?= e($critique['pseudo']) ?></strong> sur
				<a href="<?= e(urlSerie($critique['nomSerie'])) ?>"><?= e($critique['nomSerie']) ?></a>,
				le <?= e(dateFr($critique['dateCritique'])) ?></footer>
		</blockquote>
	<?php } ?>
<?php } ?>
