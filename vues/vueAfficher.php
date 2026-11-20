<?php if(!empty($message)) { ?>
	<p class="message message-info"><?= e($message) ?></p>
<?php } ?>

<h2>Liste des séries et de leurs critiques :</h2>
<ul>
<?php foreach($seriesCritiques as $nomSerie => $critiquesSerie) { ?>
	<li>
		<strong><a href="<?= e(urlSerie($nomSerie)) ?>"><?= e($nomSerie) ?></a></strong>
		<?php if(count($critiquesSerie) == 0) { ?>
			<em>(aucune critique)</em>
		<?php } else { ?>
			<ul>
			<?php foreach($critiquesSerie as $critique) { ?>
				<li>« <?= e($critique['texte']) ?> » par <em><?= e($critique['pseudo']) ?></em> le <?= e(dateFr($critique['dateCritique'])) ?></li>
			<?php } ?>
			</ul>
		<?php } ?>
	</li>
<?php } ?>
</ul>

<h2>Liste des critiques (de la plus récente à la plus ancienne) :</h2>
<table>
	<thead>
		<tr><th>Date</th><th>Pseudo</th><th>Série</th><th>Critique</th></tr>
	</thead>
	<tbody>
	<?php foreach($critiques as $critique) { ?>
		<tr>
			<td><?= e(dateFr($critique['dateCritique'])) ?></td>
			<td><?= e($critique['pseudo']) ?></td>
			<td><a href="<?= e(urlSerie($critique['nomSerie'])) ?>"><?= e($critique['nomSerie']) ?></a></td>
			<td><?= e($critique['texte']) ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>

<h2>Liste des acteurs et actrices :</h2>
<ul>
<?php foreach($actrices as $actrice) { ?>
	<li><?= e($actrice['prenom']) ?> <?= e($actrice['nom']) ?> (#<?= e($actrice['numINSEE']) ?>)</li>
<?php } ?>
</ul>

<h2>Titre des épisodes numérotés 1 :</h2>
<ul>
<?php foreach($episodes1 as $episode) { ?>
	<li><?= e($episode['titre']) ?></li>
<?php } ?>
</ul>

<h2>Titre des épisodes numérotés 2 :</h2>
<ul>
<?php foreach($episodes2 as $episode) { ?>
	<li><?= e($episode['titre']) ?></li>
<?php } ?>
</ul>
