<div class="component word-edit-component">
	<p><a href="/lang/<?php echo $word->getLanguage()->getCode(); ?>"><?php echo $word->getLanguage()->getName(); ?></a></p>
	<form method="post" action="/word/<?php echo $word->getId(); ?>">
		<input name="orthography" placeholder="Orthography" value="<?php echo $word->getOrthography(); ?>">
		<input name="pronounciation" placeholder="Pronounciation" value="<?php echo $word->getPronounciation(); ?>">
		<input type="submit" value="Save">
	</form>
</div>
