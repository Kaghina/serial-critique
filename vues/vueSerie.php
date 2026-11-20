<?php if(!$serieTrouvee) { ?>
	<h2>Série introuvable</h2>
	<p class="message message-erreur">Cette série n'existe pas dans la base.</p>
	<p><a href="index.php?page=series">← Retour à la liste des séries</a></p>
<?php return; } ?>

<p class="fil"><a href="index.php?page=series">← Toutes les séries</a></p>
<h2><?= e($nomSerie) ?></h2>

<div class="colonnes">
	<section>
		<h3>Saisons et épisodes</h3>
		<?php if(count($saisons) == 0) { ?>
			<p class="vide">Aucune saison renseignée.</p>
		<?php } else { ?>
			<?php foreach($saisons as $idSaison => $saison) { ?>
				<div class="saison">
					<strong>Saison #<?= e($idSaison) ?></strong>
					<span class="discret">lancée le <?= e(dateFr($saison['dateLancement'])) ?></span>
					<?php if(count($saison['episodes']) == 0) { ?>
						<p class="vide">Aucun épisode renseigné.</p>
					<?php } else { ?>
						<ol>
						<?php foreach($saison['episodes'] as $episode) { ?>
							<li value="<?= (int) $episode['numero'] ?>"><?= e($episode['titre']) ?></li>
						<?php } ?>
						</ol>
					<?php } ?>
				</div>
			<?php } ?>
		<?php } ?>
	</section>

	<section>
		<h3>Distribution</h3>
		<?php if(count($distribution) == 0) { ?>
			<p class="vide">Aucun acteur ni aucune actrice renseigné·e.</p>
		<?php } else { ?>
			<ul>
			<?php foreach($distribution as $actrice) { ?>
				<li><?= e($actrice['prenom']) ?> <?= e($actrice['nom']) ?>
					<span class="discret">(<?= $actrice['nbEpisodes'] ?> épisode(s))</span></li>
			<?php } ?>
			</ul>
		<?php } ?>
	</section>
</div>

<section id="critiques">
	<h3>Critiques (<?= count($critiquesSerie) ?>)</h3>
	<?php if(count($critiquesSerie) == 0) { ?>
		<p class="vide">Aucune critique pour l'instant : soyez la première personne à donner votre avis !</p>
	<?php } ?>
	<?php foreach($critiquesSerie as $critique) { ?>
		<blockquote class="critique">
			<p><?= e($critique['texte']) ?></p>
			<footer>— <strong><?= e($critique['pseudo']) ?></strong>, le <?= e(dateFr($critique['dateCritique'])) ?></footer>
		</blockquote>
	<?php } ?>

	<h3>Donner votre avis</h3>
	<?php if(count($erreurs) > 0) { ?>
		<div class="message message-erreur">
			<?php foreach($erreurs as $erreur) { ?><div><?= e($erreur) ?></div><?php } ?>
		</div>
	<?php } ?>
	<form method="post" action="<?= e(urlSerie($nomSerie)) ?>#critiques" class="formulaire">
		<label for="pseudo">Pseudo</label>
		<input type="text" name="pseudo" id="pseudo" maxlength="100" required value="<?= e($pseudoSaisi) ?>" placeholder="fan2100" />

		<label for="texte">Votre critique <span class="discret">(255 caractères max.)</span></label>
		<textarea name="texte" id="texte" maxlength="255" rows="3" required placeholder="Qu'avez-vous pensé de cette série ?"><?= e($texteSaisi) ?></textarea>

		<input type="submit" name="boutonCritiquer" value="Publier la critique" />
	</form>
</section>
