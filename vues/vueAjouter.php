<h2>Ajout d'une série</h2>

<?php if(isset($message)) { ?>
	<p class="message message-erreur"><?= e($message) ?></p>
<?php } ?>

<form method="post" action="index.php?page=ajouter" class="formulaire">
	<label for="nomSerie">Nom de la série</label>
	<input type="text" name="nomSerie" id="nomSerie" placeholder="Orange is the new black" maxlength="255" required
		value="<?= e($_POST['nomSerie'] ?? '') ?>" />
	<input type="submit" name="boutonValider" value="Ajouter"/>
</form>
