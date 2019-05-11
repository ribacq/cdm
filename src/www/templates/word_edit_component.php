<div class="component word-edit-component">
	<form method="post" action="">
		<input type="hidden" name="edit-word-id" value="<?php echo $word->getId(); ?>">
		<input type="hidden" name="language-code" value="<?php echo $word->getLanguage()->getCode(); ?>">
		<input name="orthography" placeholder="Orthography" value="<?php echo $word->getOrthography(); ?>">
		<input name="pronounciation" placeholder="Pronounciation" value="<?php echo $word->getPronounciation(); ?>">
		<input type="submit" value="Save">
	</form>
</div>
