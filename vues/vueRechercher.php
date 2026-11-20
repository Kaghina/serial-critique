<?php
$tableChoisie = $table ?? 'Series';
$valeurSaisie = $valeur ?? '';
?>
<h2>Recherche dans la base</h2>

<form method="post" action="index.php?page=rechercher" class="formulaire formulaire-ligne">
	<div>
		<label for="idChamp">Rechercher dans</label>
		<select name="champRech" id="idChamp">
			<option value="Series" <?= $tableChoisie == 'Series' ? 'selected' : '' ?>>Séries</option>
			<option value="Actrices" <?= $tableChoisie == 'Actrices' ? 'selected' : '' ?>>Acteurs / Actrices</option>
		</select>
	</div>
	<div>
		<label for="idValeur">la valeur</label>
		<input type="text" name="valeur" id="idValeur" placeholder="abc" value="<?= e($valeurSaisie) ?>" required/>
	</div>
	<input type="submit" name="boutonValider" value="Rechercher"/>
</form>

<article>
	<?php if(isset($message)) { ?>
		<p class="message message-info"><?= e($message) ?></p>
	<?php } ?>
	<?php if(!empty($resultats)) { ?>
		<p><?= count($resultats) ?> résultat(s) :</p>
		<ul>
		<?php foreach($resultats as $instance) { ?>
			<?php if($tableChoisie == 'Actrices') { ?>
				<li><?= e($instance['prenom']) ?> <?= e($instance['nom']) ?> <span class="discret">(#<?= e($instance['numINSEE']) ?>)</span></li>
			<?php } else { ?>
				<li><a href="<?= e(urlSerie($instance['nomSerie'])) ?>"><?= e($instance['nomSerie']) ?></a></li>
			<?php } ?>
		<?php } ?>
		</ul>
	<?php } ?>
</article>
