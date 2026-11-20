<h2>Les séries</h2>

<?php if(count($resumeSeries) == 0) { ?>
	<p class="message message-info">Aucune série pour l'instant. <a href="index.php?page=ajouter">Ajoutez-en une !</a></p>
<?php } else { ?>
	<p><?= count($resumeSeries) ?> série(s) dans la base. Cliquez sur une série pour voir ses saisons, sa distribution et ses critiques.</p>
	<div class="grille">
	<?php foreach($resumeSeries as $s) { ?>
		<a class="carte" href="<?= e(urlSerie($s['nomSerie'])) ?>">
			<span class="carte-titre"><?= e($s['nomSerie']) ?></span>
			<span class="carte-infos">
				<?= $s['nbSaisons'] ?> saison(s) · <?= $s['nbEpisodes'] ?> épisode(s)
			</span>
			<span class="pastille"><?= $s['nbCritiques'] ?> critique(s)</span>
		</a>
	<?php } ?>
	</div>
<?php } ?>
