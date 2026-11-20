<h2>Historique des activités (de cette session)</h2>

<?php if(isset($erreurHisto)) { ?>
	<p class="message message-erreur"><?= e($erreurHisto) ?></p>
<?php } elseif(isset($lienHisto)) { ?>
	<p class="message message-succes">Télécharger le <a href="<?= e($lienHisto) ?>" download>fichier historique généré</a>.</p>
<?php } ?>

<ul class="historique">
<?php foreach(array_reverse($_SESSION['historique']) as $activiteDate) { ?>
	<?php foreach($activiteDate as $date => $activite) { ?>
		<li><span class="discret"><?= e(dateFr($date)) ?></span> <?= e($activite) ?></li>
	<?php } ?>
<?php } ?>
</ul>

<form action="index.php?page=historique" method="post">
	<input type="submit" name="boutonGenHisto" value="Générer un fichier historique">
</form>
